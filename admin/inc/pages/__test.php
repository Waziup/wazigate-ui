<?php
// unplanned execution path
defined( 'IN_WAZIHUB') or die( 'e902!');

$conf	= callAPI( 'system/conf');

$maxAddr = 255;

/*------------*/

$templateData = array(

	'icon'	=>	$pageIcon,
	'title'	=>	$lang['TestDebugTitle'],
	'msgDiv'=>	'gw_config_msg',
	'tabs'	=>	array(
		
		/*-----------*/
		
		array(
			'title'		=>	$lang['DownlinkReq'],
			'active'	=>	true,
			'notes'		=>	$lang['Notes_Test_Downlink'],
			'content'	=>	array(

				array( downlinkReqForm()),
				
			),
		),
		
		/*-----------*/
	
	),
);

/*------------*/

require( './inc/template_admin.php');

/*------------*/

function downlinkReqForm()
{
	global $lang, $maxAddr;

	return '<form id="downlink_form" role="form">
				<fieldset>
					<div class="form-group">
						<label>'. $lang['Destination'] .'</label>
						<input class="form-control" placeholder="Between 2 and '. $maxAddr .'" name="destination" type="number" value="" min="2" max="'. $maxAddr .'" autofocus />
					</div>
					<div class="form-group">
						<label>'. $lang['Message'] .'</label>
						<input class="form-control" placeholder="'. $lang['Message'] .'" name="message" type="text" value="" autofocus />
					</div>
					
					<center>
						<button  type="submit" class="btn btn-primary">'. $lang['Submit'] .'</button>
						<button  id="btn_downlink_form_reset" type="reset" class="btn btn-primary">'. $lang['Clear'] .'</button>
					</center> 
				</fieldset>
			</form>';

}

/*------------*/

?>
