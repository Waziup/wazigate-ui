<?php
// unplanned execution path
defined( 'IN_WAZIHUB') or die( 'e902!');

$conf	= callAPI( 'system/conf');

$clouds = CallEdge('clouds');
$cloudInfo	= @reset( $clouds);

/*------------*/

$templateData = array(

	'icon'	=>	$pageIcon,
	'title'	=>	$lang['CloudTitle'],
	'msgDiv'=>	'gw_config_msg',
	'tabs'	=>	array(
		
		/*-----------*/

		array(
			'title'		=>	'Waziup.io',
			'active'	=>	true,
			'notes'		=>	$lang['Notes_Cloud_Waziup'],
			'content'	=>	array(

				array( $lang['Activation']	, 
						editEnabled( array( 
									'id'		=>	'enabled',
									'value'		=>	$cloudInfo['paused'] != 1,
									'params'	=>	array( 'edge' => 'clouds', 'conf_node' => 'paused'),
							)
						)
					),

				array( 
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
				),
				
				array( 
						$lang['Username'], 
						editText( array( 
									'id'		=> 'username',
									'label'		=> $lang['Username'],
									'pholder'	=> $lang['Username'] .' [A-Za-z0-9]',
									//'note'		=> $lang['Username'] .' [A-Za-z0-9]',
									'value'		=>	@$cloudInfo['credentials']['username'],
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
									'value'		=>	empty( @$cloudInfo['credentials']['token']) ? '' : '*********',
									'params'	=>	array( 'edge' => 'clouds', 'conf_node' => 'credentials'),

						)
					)
				),
				
				/*array( $lang['PublicVisibility']	, 
					editEnabled( array( 
								'id'		=>	'public',
								'value'		=>	$conf['cloud_conf']['public'],
								//'source'	=>	array( 'true' => 'public', 'false' => 'private'),
								'params'	=>	array( 'cfg' => 'system/conf', 'conf_node' => 'cloud_conf'),
						)
					)
				),/**/

			),
		),

		/*-----------*/

		/*array(
			'title'		=>	$lang['SensorsList'],
			'active'	=>	false,
			'notes'		=>	$lang['Notes_SensorsList'],
			'content'	=>	array(
				
				array( 
						$lang['SensorsList'], 
						editText( array( 
									'id'		=> 'source_list',
									'label'		=> $lang['SensorsList'],
									//'pholder'	=> implode( "\n", array( 2,3,4,5)),
									'note'		=> $lang['SensorsList_Note'],
									'value'		=> @implode( "\n", $key_clouds['waziup_source_list']),
									'type'		=> 'textarea',
									'params'	=>	array( 'cfg' => 'waziup_key'),
						)
					)
				),

			),
		),/**/
		
		/*-----------*/
		/*-----------*/
	
	),
);

/*------------*/

require( './inc/template_admin.php');

/*--------------------*/
/*--------------------*/
/*--------------------*/
/*--------------------*/

?>
