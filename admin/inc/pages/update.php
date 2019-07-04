<?php
// unplanned execution path
defined( 'IN_WAZIHUB') or die( 'e902!');

$updateLogs = CallHost( 'docker/update/status');
$updateStatus = empty( $updateLogs) ? "" : "{$lang['LastUpdate']}: <b>{$updateLogs['time']}</b><hr /><pre>{$updateLogs['logs']}</pre>";

/*------------*/

$templateData = array(

	'icon'	=>	$pageIcon,
	'title'	=>	$lang['Update'],
	'msgDiv'=>	'xxx',
	'tabs'	=>	array(
	
		array(
			'title'		=>	$lang['Update'],
			'active'	=>	true,
			'notes'		=>	'',
			'content'	=>	array(
					array( updateButton()),
					array( $updateStatus),
			),
		),
	),
);

/*------------*/

require( './inc/template_admin.php');

/*------------*/

/*------------*/

function updateButton()
{
	global $lang;
	
	return '<form id="saveForm_1">
			<input type="hidden" name="ref_latitude" id="latitude" value="0" />
			<input type="hidden" name="ref_longitude" id="longitude" value="0" />
			<input type="submit" name="submit" id="submit" value="'. $lang['FullUpdate'] .'" class="btn btn-primary"/>
			<div id="sinkAjx_1"></div>
		</form>
		<script>
			$( "#saveForm_1").submit( function(){
					$("#sinkAjx_1").html( "<br /><img src=\"./style/img/loading.gif\" /> '. $lang['UpdatingMsg'] .'").fadeIn();
					$.get( "?get=update", function( data){
						if( data == "REBOOT")
						{
							$("#sinkAjx_1").html( "'. $lang['Rebooting'] .'").fadeIn();
							$.post("?", "&status=reboot", function(d){alert(d);});
							setTimeout( function(){location.reload();}, 5*60*1000);

						}else{

							$("#sinkAjx_1").html( data).fadeIn().delay(5000).fadeOut("slow");
							setTimeout( function(){location.reload();}, 5000);
						}

					});
					return false;
			});
		</script>';	
}
#$.get( "?status=reboot", function(d){alert(d)});
/*------------*/

?>
