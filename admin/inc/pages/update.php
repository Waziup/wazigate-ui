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
			'title'		=>	$lang['Update'],
			'active'	=>	true,
			'notes'		=>	'',
			'content'	=>	array(
					array( updateButton()),
					array( getUpdateLogs()),
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
						$("#sinkAjx_1").html( data).fadeIn().delay(5000).fadeOut("slow");
						setTimeout( function(){location.reload();}, 15*60*1000);

					});
					return false;
			});
		</script>';	
}
#$.get( "?status=reboot", function(d){alert(d)});
/*------------*/

function getUpdateLogs()
{
	global $lang;

	return '
		<div class="logs" id="logsAjx"></div>
		<div style="text-align:center;height:20px;max-width:900px;" id="indAjx"></div>
	  <script>
		var autoR = 0;
		function loadLogs(){
			clearTimeout( autoR);
			$("#indAjx").html( "<img src=\"./style/img/loading.gif\" />");
			$.get( "?get=updateLogs", function( data){
				$("#indAjx").html( " ");
				$("#logsAjx").html( data);
				autoR = setTimeout( function(){loadLogs()}, 3000);
			});
		}
		$(function(){ loadLogs();});
	 </script>';
}

/*--------------------*/

?>
