<?php
/*
* @date: 27/03/2019 
* @author: Moji eskandari@fbk.eu
* @note: some functions are used from the previous code written by M. Diop and C. Pham
*/

define( 'IN_WAZIHUB', 1);
require( './config.inc.php');

session_start();

require( './inc/functions.php');

// printr( $_SERVER);

/*---------------------------------*/
//Language stuff

empty( $_SESSION['lang']) and $_SESSION['lang'] = $_cfg['lang'];

$allLangs = getAllLangs();
if( !empty( $_GET['lang']) && isset( $allLangs[ $_GET['lang'] ])) $_SESSION['lang'] = $_GET['lang'];

$lang = require( './lang/'. $_SESSION['lang'] .'.php'); // Loading the language pack...

/*---------------------------------*/

if( !empty( $_GET['logout']))
{
	$_SESSION['username'] = '';
	unset( $_SESSION);

	// header('Location: ./'); //To fix the issue if remote redirection
	print( '<html>
				<body>
					[ <a href="?"> Home </a> ]
					<script type="text/javascript">
						window.location.href="?";
					</script>
				</body>
			</html>');

	exit();
}

if( @empty( $_SESSION['username']))
{
	require( './inc/header.php');
	require( './inc/pages/login.php');
	require( './inc/footer.php');
	exit();
}

/*---------------------------------*/

if( !empty( $_POST) || !empty( $_GET['get']))
{ 
	require( './inc/processAPIs.php');
	die();
}

/*---------------------------------*/

@empty( $_GET['page']) and $_GET['page'] = 'overview';

require( './inc/header.php');
require( './inc/sidebar.php');
require( './inc/pages/'. $_GET['page'] .'.php');

/*---------------------------------*/

require( './inc/footer.php');
?>