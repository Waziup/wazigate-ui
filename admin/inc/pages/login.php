<?php
defined( 'IN_WAZIHUB') or die( 'e902!');
$message = ""; 

$json_data = read_database_json();
$conf = callAPI( 'system/conf');

if( empty( $json_data))
{
	//No databse so create the default credentials
	set_profile( "admin", "loragateway");
}

$username = $json_data['username'];
$password = "";

// if default settings (i.e. username = admin and password = loragateway), encrypt password
if( check_login( $json_data['username'], $json_data['password'], "admin", "loragateway")){
	$password = md5( $json_data['password']);
}
else{ // password is already encrypted
	$password = $json_data['password'];
}

// create a connexion attempt session
if( !isset( $_SESSION['attempt'])) $_SESSION['attempt'] = 0;

// check if the user is already logged in
if(( isset( $_SESSION['username'])) && ( isset( $_SESSION['password']))){
	//$message = 'User is already logged in';
	if(check_login($username, $password, $_SESSION['username'], $_SESSION['password'])){
		if( $conf['setup_conf']['wizard'])// if the setup wizard has been done
		{
			header('Location: ./');

		}else{
			header('Location: ./?page=setup_wizard');
		}
		exit();
	}
}

// check that both the username, password have been submitted
if(!isset( $_POST['username'], $_POST['password'])){
    $message = '';
}
else{ // isset($_POST['username']) && isset($_POST['password'])
	
	if(!empty($_POST['username']) && !empty($_POST['password']))
	{
		$_POST['username'] = strtolower( $_POST['username']);

		if(check_login($username, $password, $_POST['username'], md5($_POST['password']))){
			$_SESSION['username'] = $_POST['username'];
			$_SESSION['password'] = md5($_POST['password']);
 
			if( $conf['setup_conf']['wizard'])// if the setup wizard has been done
			{
				// $message = $lang['LoginSuccess'] .'[ <a href="?">'. $lang['Home'] .'</a> ] <script type="text/javascript">window.location.href="?";</script>';
				jsRedirect( '?');
				exit();

			}else{
				// $message = $lang['LoginSuccess'] .'[ <a href="?page=setup_wizard">'. $lang['Home'] .'</a> ] <script type="text/javascript">window.location.href="?page=setup_wizard";</script>';
				jsRedirect( '?page=setup_wizard');
				exit();
			}			
		}
		else{
			$_SESSION['attempt']++;
 
			//header('Location: ./');
			$message = $lang['LoginError'];
			//exit();
		}
  	}
}

//$lang['Login']

?><div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php print( $lang['SignInMsg']);?></h3>
                </div>
                <div class="panel-body">
                    <form id="login_form" role="form" method="post">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="<?php print( $lang['Username']); ?>" name="username" type="text" value="" maxlength="20" autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="<?php print( $lang['Password']); ?>" name="password" type="password" maxlength="20" value="">
                            </div>

							<h4>Default username: <b>admin</b><br />
								Default password:&nbsp; <b>loragateway</b></h4>

							<?php if( !empty( $message)) { ?>
								<div id="login_form_msg" class="error">
									<i class="fa fa-times-circle"></i>
									<?php print( $message);?>
								</div>
							<?php } ?>

					
							<button  type="submit" class="btn btn-lg btn-success btn-block"><?php print( $lang['Login']);?></button>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

<!-- Bootstrap Core JavaScript -->
<script src="./style/js/bootstrap.min.js"></script>

<!-- 
<div class="info">
	<i class="fa fa-info-circle"></i>
	INFO text.
</div>
 
<div class="success">
	<i class="fa fa-check"></i>
	SUCCESS text.
</div>
  
<div class="warning">
	<i class="fa fa-warning"></i>
	WARNING text.
</div>

<div class="error">
	<i class="fa fa-times-circle"></i>
	ERROR text.
</div> -->
