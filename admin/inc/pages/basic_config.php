<?php
// unplanned execution path
defined( 'IN_WAZIHUB') or die( 'e902!');

$conf	=	callAPI( 'system/conf');
$gwInfo	=	CallEdge( 'device');

$maxAddr = 255;

/*------------*/

$templateData = array(

	'icon'	=>	$pageIcon,
	'title'	=>	$lang['BasicConfTitle'],
	'msgDiv'=>	'gw_config_msg',
	'tabs'	=>	array(
		
		/*-----------*/

		//Moved to the advanced config
		array(
			'title'		=>	$lang['Gateway'],
			'active'	=>	true,
			'notes'		=>	$lang['Notes_BasicConf_Gateway'],
			'content'	=>	array(
				
				array( $lang['GatewayID']	, @$gwInfo['id']),
				
				array( 
						$lang['GatewayName'], 
						editText( array( 
									'id'		=> 'name',
									'label'		=> $lang['GatewayName'],
									'pholder'	=> 'My fish farm gateway',
									//'type'		=> 'email',
									//'note'		=> $lang['Username'] .' [A-Za-z0-9]',
									'value'		=>	@$gwInfo['name'],
									'params'	=>	array( 'edge' => 'gateway'),
						)
					)
				),
				
			),
		),/**/

		array(
			'title'		=>	$lang['Radio'],
			'active'	=>	false,
			'notes'		=>	$lang['Notes_BasicConf_Radio'],
			'content'	=>	array(
				array( $lang['LoRaBand'], editRadioFreq()),
			),
		),
		
		/*-----------*/
		/*-----------*/
		/*-----------*/
	),
);

/*------------*/

require( './inc/template_admin.php');

/*------------*/


?>
