<?php
// unplanned execution path
defined( 'IN_WAZIHUB') or die( 'e902!');

/*------------*/

$wifi	= callAPI( 'system/wifi');
$conf	= callAPI( 'system/conf');

$templateData = array(

	'icon'	=>	$pageIcon,
	'title'	=>	$lang['InternetConnectivity'],
	'msgDiv'=>	'zzza',
	'tabs'	=>	array(
		
		/*-----------*/

		array(
			'title'		=>	'WiFi',
			'active'	=>	true,
			'notes'		=>	$lang['Notes_Internet'],
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

				// array( $lang['Internet']	, ajaxLoad( array( 'load' => 'is_connected'))),
				
				array(	$lang['ConnectedWiFiNetwork'], $wifi['ap_mode'] ? $lang['APMode'] : ( '<b>'. $wifi['ssid'] .'</b>'. ( $wifi['ssid'] == '' ? '' : " ( {$wifi['ip']} )"))),
				
				//array( 'NetInterface' , getNetwokIFs()),
				
				array( $lang['WiFiNetwork'], getAjaxWiFiForm())

				),
			),

		/*-----------*/

		array(
			'title'		=>	$lang['Cellular'],
			'active'	=>	false,
			'notes'		=>	$lang['Notes_Cellular'],
			'content'	=>	array(
			
				array(	$lang['3G_boot'], 
						editEnabled( array( 
									'id'			=>	'3G_boot',
									'value'			=>	$conf['cell_conf']['3G_boot'],
									'params'	=>	array( 'cfg' => 'system/conf', 'conf_node' => 'cell_conf'),
									#'callbackJS'	=>	'setTimeout( function(){location.reload();}, 2000);',
							)
						)
					),

				/*array(	$lang['Loragna_boot'], 
						editEnabled( array( 
									'id'			=>	'loragna_boot',
									'value'			=>	$conf['cell_conf']['loragna_boot'],
									'params'	=>	array( 'cfg' => 'system/conf', 'conf_node' => 'cell_conf'),
									#'callbackJS'	=>	'setTimeout( function(){location.reload();}, 2000);',
							)
						)
					),

				array(	$lang['Loragna_G'], 
						editEnabled( array( 
									'id'		=>	'loragna_g',
									'value'		=>	$conf['cell_conf']['loragna_g'],
									'source'	=>	array( false => '2G', true => '3G'),
									'params'	=>	array( 'cfg' => 'system/conf', 'conf_node' => 'cell_conf', 'custom' => 1),
									'enText'	=>	'3G',
									'disText'	=>	'2G',
									#'callbackJS'	=>	'setTimeout( function(){location.reload();}, 2000);',
							)
						)
					),/**/

				),
			),

		/*-----------*/
		
		/*-----------*/
		
		
		
		/*-----------*/	
		
		/*-----------*/
		/*-----------*/
	
	),
);

/*------------*/

require( './inc/template_admin.php');

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
			$("#wifiFormAjx").append( "<img src=\"./style/img/loading.gif\" /> '. $lang['ScanningWiFi'] .'").fadeIn();
			$.get( "?get=wifiForm", function( data){
				$("#wifiFormAjx").html( data).fadeIn();
				autoR = setTimeout( function(){loadStuff()}, 5000);
				$("#wifiForm").click(function(){ clearTimeout( autoR);});
			});
		}
		$(function(){ loadStuff();});
	 </script>';
}

?>
