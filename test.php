<?php
/*
* @date: 27/03/2019 
* @author: Moji 
* @note: test codes go here
*/


define( 'IN_WAZIHUB', 1);

require( './admin/config.inc.php');
require( './admin/inc/functions.php');

printr( 'sh '. getRootDir(). '../update_docs.sh');

// print( shell_exec( 'sh '. getRootDir(). '../update_docs.sh' ));
exit();

#printr( getenv( 'WAZIGATE_SYSTEM_PORT'));
#printr( $_ENV['WAZIGATE_SYSTEM_PORT']);

printr( @$_ENV['WAZIGATE_SYSTEM_ADDR']);
printr( @$_ENV['WAZIGATE_EDGE_ADDR']);

$addr = explode( ':', @$_ENV['WAZIGATE_EDGE_ADDR']);
printr( $addr);

printr( waziDocsUpdateCheck());

?>