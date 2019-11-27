<?php
// unplanned execution path
defined( 'IN_WAZIHUB') or die( 'e902!');

//$conf	=	callAPI( 'system/conf');
$status = CallHost( 'docker/status');

//printr( $status);

/*------------*/

$tabs = array();
foreach( $status as $k => $container)
{
	$cName = ltrim( $container['Names'][0], '/');
	$tabs[] = array(
			'title'		=>	stateCName( $container['State'], $cName),
			'active'	=>	$k == 0, // Active only the first tab
			'notes'		=>	'',
			'content'	=>	array(
				array( $lang['State'], stateTxt( $container['State'] )),
				array( $lang['Status'], $container['Status'] ),
				//array( $lang['Version'], $container['Status'] ),
				array( $lang['LastUpdate'], date('r', $container['Created'] )),
				array( $lang['Enabled'],
						editEnabled( array( 
								'id'		=> $cName .'_enabled',
								'value'		=> $container['State'] == 'running',
								'params'	=>	array( 'get' => 'dockerState', 'cName' => $cName, 'id' => $container['Id']),
								'callbackJS'	=>	'setTimeout( function(){location.reload();}, 2000);',
							)
						)
					),
			)
		);
	
}

/*------------*/

$templateData = array(

	'icon'	=>	$pageIcon,
	'title'	=>	$lang['Containers'],
	'msgDiv'=>	'msg',
	'tabs'	=>	$tabs
);

/*------------*/

require( './inc/template_admin.php');

/*------------*/

function stateTxt( $state)
{
	if( $state == 'running') return( '<div class="enabled"><i class="fa fa-check"></i> '. $state .'</div>'); 
	return( '<div class="err"><i class="fa fa-remove"></i> '. $state .'</div>');
}

/*------------*/

function stateCName( $state, $cName)
{
	if( $state == 'running') return( '<i class="fa fa-check"></i> '. $cName .''); 
	return( '<div class="err"><i class="fa fa-remove"></i> '. $cName .'</div>');
}

/*------------*/
?>