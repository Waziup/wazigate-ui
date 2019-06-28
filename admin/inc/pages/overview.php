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
				//array( 'Low-level status ON'	, 	getLowLevelStatus()),
			),
		),

		/*-----------*/
		
		array(
			'title'		=>	'Remote.it',
			'active'	=>	false,
			'notes'		=>	'',
			'content'	=>	array(
				
				array( 'Remote.it', remoteItStatus()),
			),
		),
		
		/*-----------*/
		
		array(
			'title'		=>	$lang['Location'],
			'active'	=>	false,
			'notes'		=>	$lang['Notes_Overview_Location'],
			'content'	=>	array(
				
				array( storeLocationInfoButton()),
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

function storeLocationInfoButton()
{
	global $lang;
	
	return '<form id="saveForm_1">
			<input type="hidden" name="ref_latitude" id="latitude" value="0" />
			<input type="hidden" name="ref_longitude" id="longitude" value="0" />
			<input type="submit" name="submit" id="submit" value="'. $lang['SaveLocation'] .'" class="btn btn-primary" style="display:none" />
			<div id="sinkAjx_1"></div>
		</form>
		<script>
			$( "#saveForm_1").submit( function(){
					$("#sinkAjx_1").html( "<img src=\"./style/img/loading.gif\" />").fadeIn();
					var formValues = $(this).serialize();
					$.post( "?cfg=location", formValues, function( data){
						$("#sinkAjx_1").html( data).fadeIn().delay(5000).fadeOut("slow");
					});
					return false;
			});
		</script>';	
}

/*------------*/

function remoteItStatus()
{
	$notRegistered = printEnabled( false, 'Done', 'NotRegistered');

	return '<div id="remoteSinkAjx"></div>
	  <script>
		  function loadRemoteStatus()
		  {
		  	$("#remoteSinkAjx").html( "<p align=\"center\"><img src=\"./style/img/loading.gif\" /></p>").fadeIn();
		  	$.get( "?get=remote.it", function( data){
				out = "";
				res = JSON.parse( data);
				if( res)
				{
					if( typeof res.msg != "undefined")
					{
						out = "<b>"+ res.msg +"</b>";
						setTimeout( loadRemoteStatus, 3000);

					}else{
						out = "<table cellpadding=\"10\">";
						for( var key in res)
						{
							out += "<tr><td style=\"padding: 5px;\">"+ key +" :</td><td><b>"+ res[key].replace(/\n/g, "<br />") +"</b></td></tr>";
						}
						out += "</table>";
					}
				}else{
					out = \''. $notRegistered .'\';
				}
				$("#remoteSinkAjx").html( out).fadeIn();
			});
			return true;
		  }
		  $(function(){ loadRemoteStatus();});
	 </script>';	
}

/*------------*/

?>
