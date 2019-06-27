<?php
// unplanned execution path
defined( 'IN_WAZIHUB') or die( 'e902!');

/*------------*/

$conf	= callAPI( 'system/conf');

/*------------*/

$templateData = array(
	'icon'	=>	$pageIcon,
	'title'	=>	$lang['SetupWizard'],
	'msgDiv'=>	'ddd',
	'tabs'	=>	array()
);


if( empty( $_GET['next']))
{
	$wifi	= callAPI( 'system/wifi');
	$templateData[ 'tabs' ][] = array(
	
				'title'		=>	'WiFi',
				'active'	=>	true,
				'notes'		=>	$lang['Notes_Wizard_WiFi'],
				'content'	=>	array(

					array(	$lang['Activation']	, 
							editEnabled( array( 
										'id'			=>	'enabled',
										'value'			=>	$wifi['enabled'],
										'params'		=>	array( 'cfg' => 'system/wifi'),
										'callbackJS'	=>	'setTimeout( function(){location.reload();}, 2000);',
								)
							)
						),

					array(	'Waziup.io' , printEnabled( is_connected(), 'Accessible', 'NoInternet')),
					
					array(	$lang['ConnectedWiFiNetwork'], $wifi['ssid'] . ( $wifi['ssid'] == '' ? '' : " ( {$wifi['ip']} )")),
					
					//array( 'NetInterface' , getNetwokIFs()),
					
					array( $lang['WiFiNetwork'], getAjaxWiFiForm())

				),
			);

	/*---------------------------*/

}elseif( $_GET['next'] == 'cloud'){
	
	$clouds = CallEdge('clouds');
	$cloudInfo	= @reset( $clouds);	
	
	$templateData[ 'tabs' ][] = array(
			'title'		=>	$lang['Cloud'],
			'active'	=>	true,
			'notes'		=>	$lang['Notes_Wizard_Cloud'],
			'content'	=>	array(

				array( $lang['Activation']	, 
						editEnabled( array( 
									'id'		=>	'enabled',
									'value'		=>	$cloudInfo['paused'] != 1,
									'params'	=>	array( 'edge' => 'clouds', 'conf_node' => 'paused'),
							)
						)
					),

				array( 
						$lang['Server'], 
						editText( array( 
									'id'		=> 'rest',
									'label'		=> $lang['Server'],
									'pholder'	=> 'e.g. api.staging.waziup.io/api/v2',
									//'note'		=> 'e.g. waziup_myfarm',
									'value'		=>	@$cloudInfo['rest'],
									'params'	=>	array( 'edge' => 'clouds', 'conf_node' => 'rest'),
						)
					)
				),
				
				array( 
						$lang['Username'], 
						editText( array( 
									'id'		=> 'username',
									'label'		=> $lang['Username'],
									'pholder'	=> $lang['Username'] .' [A-Za-z0-9]',
									//'note'		=> $lang['Username'] .' [A-Za-z0-9]',
									'value'		=>	@$cloudInfo['credentials']['username'],
									'params'	=>	array( 'edge' => 'clouds', 'conf_node' => 'credentials'),
						)
					)
				),				
				
				array( 
						$lang['Password'], 
						editText( array( 
									'id'		=> 'token',
									'label'		=> $lang['Password'],
									'pholder'	=> $lang['Password'] .' [A-Za-z0-9]',
									//'note'		=> $lang['Password'] .' [A-Za-z0-9]',
									'value'		=>	empty( @$cloudInfo['credentials']['token']) ? '' : '*********',
									'params'	=>	array( 'edge' => 'clouds', 'conf_node' => 'credentials'),

						)
					)
				),
				
				array( '', getCloudWizardForm())
			),
		);
	
	/*---------------------------*/
	
}elseif( $_GET['next'] == 'finish'){
	
	//Storing the done flag for wizard

		$_REQUEST['json']['setup_conf']['wizard'] = true;
		$err = CallAPI( 'system/conf', $_REQUEST, 'POST');

		if( $err == 0)
		{
			$err = $lang['SavedSuccess'];

		}else{

			is_array( $err) and $err = implode( '<br />', $err);

		}//End of if( $err == 0);
		
	$templateData[ 'tabs' ][] = array(
			'title'		=>	$lang['Finish'],
			'active'	=>	true,
			'notes'		=>	'',
			'content'	=>	array( array( $err))
		);

	/*---------------------------*/
}

/*------------*/

require( './inc/template_admin.php');

/*------------*/


/*--------------------*/

function getAjaxWiFiForm()
{
	global $lang;

	return '<div id="wifiFormAjx"></div>
		<script>
		var autoR = 0;
		function loadStuff(){
			if( ! $("#wifiFormAjx").is(":visible"))
			{ 
				autoR = setTimeout( function(){loadStuff()}, 1000);
				return false;
			}
			clearTimeout( autoR);
			$("#wifiFormAjx").html( "<img src=\"./style/img/loading.gif\" /> Scanning for WiFi networks...").fadeIn();
			$.get( "?get=wifiForm", function( data){
				$("#wifiFormAjx").html( data).fadeIn();
				autoR = setTimeout( function(){loadStuff()}, 5000);
				$("#wifiForm").click(function(){ clearTimeout( autoR);});
				$("#wifiSubmit").val("'. $lang['Connect'] .'");
				
				$("#wifiForm").append( $("<input />").attr({
						type:	"button",
						id:		"wizardWiFiNext",
						class:	"btn btn-primary",
						value:	"'. $lang['Next'] .'"
					})
				);

				$("#wizardWiFiNext").click( function(){
					location.href += "&next=cloud";
				});

			});
		}
		$(function(){ loadStuff();});
	 </script>';
}

/*--------------------*/

function getCloudWizardForm()
{
	global $lang;
	return '<div id="div_update_wifi" class="form-group">
				<form id="CloudWizardForm"></form>
			</div>
			<script>
				$(function(){ 

					$("#CloudWizardForm").append( $("<input/>").attr({
							type:	"button",
							id:		"wizardPrev",
							class:	"btn btn-primary",
							value:	"'. $lang['Previous'] .'"
						})
					);

					$("#wizardPrev").click( function(){
						location.href += "&next=";
					});
					
					$("#CloudWizardForm").append( " ");
					$("#CloudWizardForm").append( $("<input/>").attr({
							type:	"button",
							id:		"wizardFinish",
							class:	"btn btn-primary",
							value:	"'. $lang['Finish'] .'"
						})
					);

					$("#wizardFinish").click( function(){
						location.href += "&next=finish";
					});
				
				});
			 </script>';
	
}

/*--------------------*/

?>