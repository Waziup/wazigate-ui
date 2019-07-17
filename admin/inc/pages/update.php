<?php
// unplanned execution path
defined( 'IN_WAZIHUB') or die( 'e902!');

/*------------*/

$templateData = array(

	'icon'	=>	$pageIcon,
	'title'	=>	$lang['Update'],
	'msgDiv'=>	'xxx',
	'tabs'	=>	array(
	
		array(
			'title'		=>	$lang['UpdateGateway'],
			'active'	=>	true,
			'notes'		=>	'',
			'content'	=>	array(
					array( updateButton()),
					array( getUpdateLogs( 'updateLogs')),
			),
		),
		
		/*----------------*/
	
		array(
			'title'		=>	$lang['UpdateWaziupIO'],
			'active'	=>	false,
			'notes'		=>	'',
			'content'	=>	array(
					array( updateButtonWaziupIo()),
					array( getUpdateLogs( 'updateLogsWaziup_io')),
			),
		),
		
		/*----------------*/
		
		
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
						$("#sinkAjx_1").html( data).fadeIn().delay(5000).fadeOut("slow");
						setTimeout( function(){location.reload();}, 15*60*1000);

					});
					return false;
			});
		</script>';	
}
#$.get( "?status=reboot", function(d){alert(d)});
/*------------*/

function getUpdateLogs( $param)
{
	global $lang;

	return '
		<div class="logs" id="logsAjx_'. $param .'"></div>
		<div style="text-align:center;height:20px;max-width:900px;" id="indAjx_'. $param .'"></div>
	  <script>
		var autoR_'. $param .' = 0;
		function loadLogs_'. $param .'(){
			clearTimeout( autoR_'. $param .');
			$("#indAjx_'. $param .'").html( "<img src=\"./style/img/loading.gif\" />");
			$.get( "?get='. $param .'", function( data){
				$("#indAjx_'. $param .'").html( " ");
				$("#logsAjx_'. $param .'").html( data);
				autoR_'. $param .' = setTimeout( function(){loadLogs_'. $param .'()}, 3000);
			});
		}
		$(function(){ loadLogs_'. $param .'();});
	 </script>';
}

/*--------------------*/

function updateButtonWaziupIo()
{
	global $lang;
	$sNum = 2;
	
	return '<form id="saveForm_'. $sNum .'">
			<input type="hidden" name="ref_latitude" id="latitude" value="0" />
			<input type="hidden" name="ref_longitude" id="longitude" value="0" />
			<input type="submit" name="submit" id="submit" value="'. $lang['Update'] .'" class="btn btn-primary"/>
			<div id="sinkAjx_'. $sNum .'"></div>
		</form>
		<script>
			$( "#saveForm_'. $sNum .'").submit( function(){
					$("#sinkAjx_'. $sNum .'").html( "<br /><img src=\"./style/img/loading.gif\" /> '. $lang['UpdatingMsg'] .'").fadeIn();
					$.get( "?get=updateWaziup.io", function( data){
						$("#sinkAjx_'. $sNum .'").html( data).fadeIn().delay(5000).fadeOut("slow");
						//setTimeout( function(){location.reload();}, 15*60*1000);
					});
					return false;
			});
		</script>';	
}

/*------------*/

?>
