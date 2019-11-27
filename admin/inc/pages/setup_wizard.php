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

	$templateData[ 'tabs' ][] = array(
	
				'title'		=>	'Registration',
				'active'	=>	true,
				'notes'		=>	'', //$lang['Notes_Wizard_WiFi'],
				'content'	=>	array(

					//array( 'NetInterface' , getNetwokIFs()),
					
					array( askQuestionForm())

				),
			);

	/*---------------------------*/
	
}elseif( @$_GET['next'] == 'cloudReg'){
	
	$templateData[ 'tabs' ][] = array(
	
				'title'		=>	'Registration',
				'active'	=>	true,
				'notes'		=>	'', //$lang['Notes_Wizard_WiFi'],
				'content'	=>	array(

					array( cloudRegForm())

				),
			);

	/*---------------------------*/
	
}elseif( @$_GET['next'] == 'cloud'){

	$clouds = CallEdge('clouds');
	$cloudInfo	= @reset( $clouds);
	$gwInfo	=	CallEdge( 'device');
	
	$templateData[ 'tabs' ][] = array(
			'title'		=>	$lang['Cloud'],
			'active'	=>	true,
			'notes'		=>	$lang['Notes_Wizard_Cloud'],
			'content'	=>	array(

				/*array( $lang['Activation']	, 
						editEnabled( array( 
									'id'		=>	'enabled',
									'value'		=>	$cloudInfo['paused'] != 1,
									'params'	=>	array( 'edge' => 'clouds', 'conf_node' => 'paused'),
							)
						)
					), /**/
					
				array( 
						$lang['GatewayName'], 
						editText( array( 
									'id'		=> 'name',
									'label'		=> $lang['GatewayName'],
									'pholder'	=> 'My fish farm gateway',
									//'type'		=> 'email',
									//'note'		=> $lang['Username'] .' [A-Za-z0-9]',
									'value'		=>	@$gwInfo['name'],
									'params'	=>	array( 'edge' => 'gateway'),
						)
					)
				),				

				
				array( 
						$lang['EmailLogin'], 
						editText( array( 
									'id'		=> 'username',
									'label'		=> $lang['Email'],
									'pholder'	=> 'your_email@example.com',
									//'type'		=> 'email',
									//'note'		=> $lang['Username'] .' [A-Za-z0-9]',
									'value'		=>	@$cloudInfo['username'],
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
									'value'		=>	empty( @$cloudInfo['token']) ? '' : '*********',
									'params'	=>	array( 'edge' => 'clouds', 'conf_node' => 'credentials'),

						)
					)
				),
				
				/*array( 
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
				), /**/
				
				array( '', getCloudWizardForm())
			),
		);
	
	/*---------------------------*/

}elseif( @$_GET['next'] == 'wifi'){
	
	$wifi	= callAPI( 'system/wifi');
	$templateData[ 'tabs' ][] = array(
	
				'title'		=>	'WiFi',
				'active'	=>	true,
				'notes'		=>	$lang['Notes_Wizard_WiFi'],
				'content'	=>	array(

					/*array(	$lang['Activation']	, 
							editEnabled( array( 
										'id'			=>	'enabled',
										'value'			=>	$wifi['enabled'],
										'params'		=>	array( 'cfg' => 'system/wifi'),
										'callbackJS'	=>	'setTimeout( function(){location.reload();}, 2000);',
								)
							)
						),/**/

					// array( $lang['Internet']	, ajaxLoad( array( 'load' => 'is_connected'))),
					
					array(	$lang['ConnectedWiFiNetwork'], $wifi['ap_mode'] ? $lang['APMode'] : ( '<b>'. $wifi['ssid'] .'</b>'. ( $wifi['ssid'] == '' ? '' : " ( {$wifi['ip']} )"))),
					
					//array( 'NetInterface' , getNetwokIFs()),
					
					array( $lang['WiFiNetwork'], getAjaxWiFiForm())

				),
			);

	/*---------------------------*/
	

}elseif( @$_GET['next'] == 'finish'){
	
	//Storing the done flag for wizard

		$_REQUEST['json']['setup_conf']['wizard'] = true;
		$err = CallAPI( 'system/conf', $_REQUEST, 'POST');

		if( $err == 0)
		{
			$err = '<h3>Congratulations! <br />
						You have successfully configured your WaziGate
						</h3>
						<p>							
						</p>';

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

	return '<div id="wifiFormAjx">
				<form id="wifiForm"></form>
			</div>
		<script>
		var autoR = 0;
		function loadStuff(){
			if( ! $("#wifiFormAjx").is(":visible"))
			{ 
				autoR = setTimeout( function(){loadStuff()}, 1000);
				return false;
			}
			clearTimeout( autoR);
			$("#wifiFormAjx").append( "<img src=\"./style/img/loading.gif\" /> '. $lang['ScanningWiFi'] .'").fadeIn();
			$.get( "?get=wifiForm", function( data){
				$("#wifiFormAjx").html( data).fadeIn();
				autoR = setTimeout( function(){loadStuff()}, 5000);
				$("#wifiForm").click(function(){ 
					clearTimeout( autoR);
				});
				$("#wifiSubmit").val("'. $lang['ConnectAndFinish'] .'");
				$("#wifiSubmit").click( function(){ 
					$.get( location.href + "&next=finish", function(dt){});
				});
				addButtons( "#wifiForm");
			});
		}
		
		function addButtons( formId)
		{
			$( formId).append( $("<input/>").attr({
						type:	"button",
						id:		"wizardPrev",
						class:	"btn btn-primary",
						style:	"margin-right:10px;",
						value:	"'. $lang['Back'] .'"
					})
				);
			
			$("#wizardPrev").click( function(){
				location.href += "&next=cloud";
			});
			
			$( formId).append( $("<input/>").attr({
					type:	"button",
					id:		"wizardFinish",
					class:	"btn btn-primary",
					style:	"margin-right:10px;",
					value:	"'. $lang['Skip'] .'"
				})
			);

			$("#wizardFinish").click( function(){
				location.href += "&next=finish";
			});
		}

		$(function(){ addButtons( "#wifiForm"); loadStuff(); });
	 </script>';
}

/*--------------------*/

function getCloudWizardForm()
{
	global $lang;
	return '<div id="div_update_wifi" class="form-group">
				<form id="wizardForm"></form>
			</div>
			<script>
				$(function(){ 

					$("#wizardForm").append( $("<input />").attr({
							type:	"button",
							id:		"wizardBack",
							class:	"btn btn-primary",
							style:	"margin-right:10px; width:100px;",
							value:	"'. $lang['Back'] .'"
						})
					);

					$("#wizardBack").click( function(){
						location.href += "&next=";
					});

					$("#wizardForm").append( $("<input />").attr({
							type:	"button",
							id:		"wizardNext",
							class:	"btn btn-primary",
							style:	"margin-right:10px; width:100px;",
							value:	"'. $lang['Next'] .'"
						})
					);

					$("#wizardNext").click( function(){
						location.href += "&next=wifi";
					});

				});
			 </script>';
	
}

/*--------------------*/

function askQuestionForm()
{
	global $lang;
	return '<div id="div_form" class="form-group">
				<form id="wizardForm" style="text-align:center;">
					<p>
						<h3>
							Do you already have a <b>WAZIUP</b> account?
						</h3>
					</p>
					<br />
				</form>
			</div>
			<script>
				$(function(){ 
					
				$("#wizardForm").append( $("<input />").attr({
						type:	"button",
						id:		"wizardNext",
						class:	"btn btn-primary",
						style:	"margin-right:10px; width:100px;",
						value:	"'. $lang['Yes'] .'"
					})
				);

				$("#wizardNext").click( function(){
					location.href += "&next=cloud";
				});

				$("#wizardForm").append( $("<input />").attr({
						type:	"button",
						id:		"wizardNext2",
						class:	"btn btn-primary",
						style:	"margin-right:10px; width:100px;",
						value:	"'. $lang['No'] .'"
					})
				);

				$("#wizardNext2").click( function(){
					location.href += "&next=cloudReg";
				});
				
				});
			 </script>';
	
}

/*--------------------*/

function cloudRegForm()
{
	global $lang;
	return '<div id="div_form" class="form-group">
				<form id="wizardForm" style="text-align:center;">
					<h3 style="text-align:justify;">
						Please go to <a href="https://dashboard.waziup.io" target="_blank">https://dashboard.waziup.io</a> 
						and use your email address to create an account.
					</h3>
				</form>
			</div>
			<script>
				$(function(){ 
					$("#wizardForm").append( $("<input />").attr({
							type:	"button",
							id:		"wizardBack",
							class:	"btn btn-primary",
							style:	"width:120px;",
							value:	"'. $lang['Back'] .'"
						})
					);

					$("#wizardBack").click( function(){
						location.href += "&next=";
					});
				});
			 </script>';
	
}

/*--------------------*/

?>