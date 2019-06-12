<?php
// unplanned execution path
defined( 'IN_WAZIHUB') or die( 'e902!');

$conf	=	callAPI( 'system/conf');
$net	=	callAPI( 'system/net');

/*------------*/

$templateData = array(

	'icon'	=>	$pageIcon,
	'title'	=>	$lang['OverviewTitle'],
	'msgDiv'=>	'gw_config_msg',
	'tabs'	=>	array(
		
		/*-----------*/
		
		array(
			'title'		=>	$lang['Basic'],
			'active'	=>	true,
			'notes'		=>	$lang['Notes_Overview_Basic'],
			'content'	=>	array(

				array( $lang['RadioFreq']	, getRadioFreq()),
				array( $lang['GatewayID']	, $conf['gateway_conf']['gateway_ID']),
				array( $lang['IPaddress']	, $net['ip']),
				array( $lang['MacAddress']	, empty( $net['dev']) ? '' : ($net['dev'] .' [ '. $net['mac'] .' ]')),
				array( 'Waziup.io'			, printEnabled( is_connected(), 'Accessible', 'NoInternet')),
			),
		),
		
		/*-----------*/
		
		array(
			'title'		=>	$lang['Advance'],
			'active'	=>	false,
			'notes'		=>	$lang['Notes_Overview_Advance'],
			'content'	=>	array(
				
				array( $lang['LoraMode']		, 	$conf['radio_conf']['mode']),
				array( $lang['Encryption']		, 	printEnabled( $conf['gateway_conf']['aes'])),
				array( $lang['GPScoordinates']	, 	getGPScoordinates()),
				//array( $lang['CloudMQTT']		, 	printEnabled( cloud_status( $clouds, "python CloudMQTT.py"))),
				array( 'Low-level status ON'	, 	getLowLevelStatus()),
			),
		),

		/*-----------*/
		
		array(
			'title'		=>	$lang['Location'],
			'active'	=>	false,
			'notes'		=>	$lang['Notes_Overview_Location'],
			'content'	=>	array(
				
				array( loadLocationInfo( 3 /*The tab Id, loads it only if tab is active*/) ),
			),
		),		
		
		
		/*-----------*/

	),
);

/*------------*/

require( './inc/template_admin.php');

/*------------*/

function loadLocationInfo( $tabId)
{
	global $lang;
	
	return '<div id="sinkAjx"></div>
	  <script>
	  	  var autoR = 0;
		  function loadLocation()
		  {
		  	clearTimeout( autoR);
		  	if( $("#sinkAjx").html() == "") { autoR = setTimeout( loadLocation, 300); }else{ return false;}
		  	if( ! $("#sinkAjx").is(":visible")) return false;

		  	$("#sinkAjx").html( "<p align=\"center\"><img src=\"./style/img/loading.gif\" /></p>").fadeIn();
		  	$.get( "?get=location", function( data){
				$("#sinkAjx").html( data).fadeIn();
			});
			return true;
		  }
		  $(function(){ loadLocation();});
	 </script>';
}


/*------------*/


?>
