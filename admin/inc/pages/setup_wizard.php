<?php
// unplanned execution path
defined( 'IN_WAZIHUB') or die( 'e902!');

/*------------*/

$templateData = array(

	'icon'	=>	$pageIcon,
	'title'	=>	'Under construction', $lang['OverviewTitle'],
	'msgDiv'=>	'gw_config_msg',
	'tabs'	=>	array(
	
		array(
			'title'		=>	'Under construction',
			'active'	=>	true,
			'notes'		=>	'',
			'content'	=>	array(
		
				/*-----------*/
	
					array( 'This section is under construction!'),
	
				/*-----------*/
			),
		),
	),
);

/*------------*/

require( './inc/template_admin.php');

/*------------*/

/*------------*/

?>
