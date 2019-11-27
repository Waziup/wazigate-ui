<?php
// unplanned execution path
defined( 'IN_WAZIHUB') or die( 'e902!');

/*------------*/

?>
<div id="page-wrapper">
	<iframe src="<?php print( urldecode( $_GET['src'])); ?>" style="width:100%; height:800px;" name="wframe"></iframe>

<?php require( './inc/footer.php'); ?>