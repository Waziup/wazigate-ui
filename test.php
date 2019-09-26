<?php
/*
* @date: 27/03/2019 
* @author: Moji eskandari@fbk.eu
* @note: some functions are used from the previous code written by M. Diop and C. Pham
*/

define( 'IN_WAZIHUB', 1);

require( './admin/config.inc.php');
require( './admin/inc/functions.php');

printr( getenv('WAZIGATE_SYSTEM_ADDR'));
printr( getenv('WAZIGATE_EDGE_ADDR'));

$addr = explode( ':', getenv('WAZIGATE_EDGE_ADDR'));
printr( $addr);

printr( waziDocsUpdateCheck());

?>

