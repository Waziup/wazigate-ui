<?php
// unplanned execution path
defined( 'IN_WAZIHUB') or die( 'e902!');

/*-----------------*/

if( !empty( $_GET['get']))
{
	//if( $_GET['get'] == 'ssid')	$err = CallAPI( 'system/wifi/ssid');
	
	if( $_GET['get'] == 'wifiForm') print( wifiForm( array( 'cfg' => 'system/wifi')));
	if( $_GET['get'] == 'logs')
	{
		if( @$_GET['n'] == 50)
		{
			if( empty( $_GET['cId']))
			{
				print( callAPI( 'system/logs50'));

			}else{

				print( CallHost( 'docker/'. $_GET['cId'] .'/logs/50'));
			}
			
		}elseif( @$_GET['n'] == 500){
			
			if( empty( $_GET['cId']))
			{
				print( callAPI( 'system/logs500'));

			}else{

				print( CallHost( 'docker/'. $_GET['cId'] .'/logs/500'));
			}
		
		}else{
		
			$date = new DateTime();
			$filename = 'logs-'. $_GET['type'] .'-'. $date->format("Y-m-d_H.i.s") .'.txt';

			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename='. $filename); 
			header('Content-Transfer-Encoding: binary');
			header('Connection: Keep-Alive');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');
			#header('Content-Length: ' . $size);			

			if( empty( $_GET['cId']))
			{
				print( callAPI( 'system/logs'));

			}else{

				print( CallHost( 'docker/'. $_GET['cId'] .'/logs'));
			}
			
			exit();
		}

	}//End of if( $_GET['get'] == 'logs');
	
	if( $_GET['get'] == 'location') print( getLocation());
	if( $_GET['get'] == 'remote.it') print( json_encode( callAPI( 'remote.it')));
	if( $_GET['get'] == 'hardware_status') print( json_encode( CallHost( 'hardware/status')));
	
	if( $_GET['get'] == 'dockerState')
	{
		$api = 'docker/'. $_REQUEST['id'] .'/';
		if( $_REQUEST['cName'] == 'wazigate-ui')//We should not stop this, restarting instead!
		{
			$api .= 'restart';
		
		}else{
			
			$api .= $_REQUEST['value'] ? 'start' : 'stop';
		}
		$res = CallHost( $api, null, 'POST');
		
		if( empty( $res))
		{
			print( $lang['Success'] ." [ {$_REQUEST['cName']} ]");
		}else{
			print( $lang['Error'] .' [ '. @$res['message'] .' ]');
		}

	}//End of if( $_GET['get'] == 'dockerState');

	//printr( $_REQUEST);
	exit();
}/**/

/*-----------------*/

if( !empty( $_REQUEST['status']))
{
	$err = CallAPI( 'system/'. $_REQUEST['status'], NULL, 'PUT');

	print( $err);
	//print( 'Done.');
	exit();

}//End of if( !empty( $_POST['status']));

/*-----------------*/

if( !empty( $_GET['edge']) && $_GET['edge'] == 'clouds')
{
	$clouds = CallEdge('clouds');
	$cloudInfo	= @reset( $clouds);

	if( empty( $cloudInfo)) //If it does not exist, create it!
	{
  		$default = array(
  			'url'	=> 'api.waziup.io/api/v2',
  			'paused'=> true,
  			'credentials' => array( 'username' => '', 'token' => '')
  		);

		$cloudInfo['id'] = CallEdge( 'clouds', $default, 'POST');

	}//End of if( empty( $cloudInfo));
	
	switch( $_REQUEST['conf_node'])
	{
		case 'paused' 		: $jsonData = $_REQUEST['value'] != 1; break;
		case 'credentials'	: $jsonData = array( $_REQUEST['name'] => $_REQUEST['value'] ); break;
		default:	$jsonData = $_REQUEST['value'];
	}
	
	$API = "clouds/${cloudInfo['id']}/{$_REQUEST['conf_node']}";
	$err = CallEdge( $API, $jsonData, 'POST');
	
	/*---------*/

	if( $err)
	{
		print( $lang['SavedSuccess']);

	}else{

		print( $lang['SaveError'] ." [ $err ]");

	}//End of if( $err == 0);
	
	exit();

}//End of if( !empty( $_GET['edge']) && $_GET['edge'] == 'clouds');


/*-----------------*/

if( !empty( $_GET['cfg']))
{
	$err = 0;
	if( !empty( $_POST['name']))
	{
		//Handling Smart Checkboxes
		if( !empty( $_POST['chk']))
		{
			$_REQUEST['value']	=	empty( $_GET['custom']) ? $_REQUEST['value'] == 1 : $_GET[ $_REQUEST['value']];
			$_REQUEST['name']	=	$_POST['name'] = $_GET['name']; // We need this to overcome the limitations of the nice switches in HTML id

		}//End of if( !empty( $_POST['chk']));

		if( $_REQUEST['name'] == 'contact_mail')
		{
			$_REQUEST['value'] = str_replace( "\n", ',', $_REQUEST['value']);
		}

		if( $_REQUEST['name'] == 'contact_sms')
		{
			$_REQUEST['value'] = explode( "\n", $_REQUEST['value']);
		}		

		$_REQUEST[ $_REQUEST['name'] ] = $_REQUEST['value'];

	}//End of if( !empty( $_POST['name']));
	
	/*---------*/

	if( isset( $_POST['band']))
	{
		$_GET['cfg'] = 'system/conf';
		$_REQUEST['json']['radio_conf'] = array( 'band' => $_POST['band'], 'freq' => $_POST['freq']);

	}//End of if( isset( $_POST['band']));
	
	/*---------*/

	if( isset( $_POST['ref_latitude']))
	{
		$_GET['cfg'] = 'system/conf';
		$_REQUEST['json']['gateway_conf'] = array( 'ref_latitude' => $_POST['ref_latitude'], 'ref_longitude' => $_POST['ref_longitude']);

	}//End of if( isset( $_POST['ref_latitude']));	
	
	/*---------*/
	
	if( isset( $_POST['ssid']))
	{
		$_REQUEST = array(
			'ssid'		=>	$_POST['ssid'] ? $_POST['ssid'] : $_POST['newssid'],
			'password'	=>	$_POST['password']
		);
	}
	
	/*---------*/

	//Handling Json config parameters
	empty( $_REQUEST['conf_node']) or $_REQUEST['json'][ $_REQUEST['conf_node'] ] = array( $_REQUEST['name'] => $_REQUEST['value']);
	
	/*---------*/
	
	//Calling the thing :P
	$err = CallAPI( $_GET['cfg'], $_REQUEST, 'POST'); # Needs to be fixed
	
	/*---------*/

	if( $err == 0)
	{
		print( $lang['SavedSuccess']);

	}else{

		is_array( $err) and $err = implode( '<br />', $err);
		//print( $lang['SaveError'] ." [ $err ]");
		print( $err);

	}//End of if( $err == 0);

}//End of if( !empty( $_GET['cfg']));


/*-----------------------------------*/

// Copied from the old version, this has to be re-written

/*************************
 * Setting profile
 *************************/
if(isset($_POST['current_username'], $_POST['new_username'], $_POST['current_pwd'], $_POST['new_pwd'])){
	
	$c_usr = htmlspecialchars( $_POST['current_username']);
	$n_usr = htmlspecialchars( $_POST['new_username']);
    $c_pwd = htmlspecialchars( $_POST['current_pwd']);
    $n_pwd = htmlspecialchars( $_POST['new_pwd']);
    $rn_pwd = htmlspecialchars( $_POST['rep_new_pwd']);
    
//	session_start();

	if(empty( $c_usr) || empty( $n_usr) || empty( $c_pwd) || empty( $n_pwd) || empty( $rn_pwd)){
		echo '<p><center><font color="red">'. $lang['FillAll'] .'</font></center></p>';
	
	}elseif( $n_pwd != $rn_pwd){
		
		echo '<p><center><font color="red">'. $lang['PasswordNotMatch'] .'</font></center></p>';
		
	}else{ 
		/*
		echo 'Current username='.$c_usr.'</br>';
		echo 'Current pwd='.$c_pwd.'</br>';
		echo 'Current pwd md5='.md5($c_pwd).'</br>';
		echo '$_SESSION["username"]='.$_SESSION['username'].'</br>';
		echo '$_SESSION["password"]='.$_SESSION['password'].'</br>';
		*/
		if(! check_login( $c_usr, md5( $c_pwd), $_SESSION['username'], $_SESSION['password'])){
			echo '<p><center><font color="red">'. $lang['LoginError'] .'</font></center></p>';
		}
		else{
			$output = set_profile( $n_usr, md5($n_pwd));
			if($output == 0){
				echo '<p><center><font color="green">'. $lang['SavedSuccess'] .'</font></center></p>';
				//echo '<p><center><font color="green">Please logout then login again using new connection settings</font></center></p>';
			}
			else{
				echo '<p><center><font color="red">'. $lang['SaveError'] .'</font></center></p>';
			}
		}
	}
}



/*------------------*/

function wifiForm( $params)
{
	global $lang;
	
	$getQStr = http_build_query( $params);
	
	$resA = CallAPI( 'system/wifi/scan');
	$res = array();
	foreach( @$resA as $data)
	{
		if( empty( $res[ $data['name'] ])	|| 
			$res[ $data['name'] ]['signal'] < $data['signal']
			)
				$res[ $data['name'] ] = $data;
	}
	
	
	$out = '<div id="div_update_wifi" class="form-group"><form id="wifiForm"><ul class="wifi" style="list-style: none; padding:0px;">';

	foreach( $res as $key => $data)
	{
		$txt = $data['signal'] .' '. $data['name'] .' ('. $data['security'] .')';
		
		$wpa = $data['security'] == 'WPA';
		
		$out .= '<li><i class="fa fa-fw wifibar" id="wifibar'. ( intval( $data['signal'] / 21) ) .'" ></i> ';
		$out .= ' <i class="fa fa-fw '. ( $wpa ? 'fa-lock': 'fa-unlock' ) .'"></i> ';
		$out .= '<input type="radio" name="ssid" id="'. $key .'_rd" data-security="'. ( $wpa ? '1' : '0') .'" value="'. $data['name'] .'" /> ';
		$out .= '<label style="cursor: pointer;" for="'. $key .'_rd" >'. $data['name'];
		$out .= '</label></li>';

	}//End of foreach( $resA as $key => $data)
	
	$out .= '<li> ';
	$out .= '<input type="radio" name="ssid" id="0_rd" data-security="1" value="0" /> ';
	$out .= '<label style="cursor: pointer;" for="0_rd" >'. $lang['hiddenWiFiNetwork'];
	$out .= '</label></li>';
	
	$out .= '</ul>
			<input type="text" class="form-control" name="newssid" style="display:none;" id="newssid" placeholder="SSID" /> <br />
			<input type="text" class="form-control" name="password" style="display:none;" id="wifi_password" placeholder="WiFi Password" /><br />

			<div style="display:none" class="inline-msg" id="wifi_msg"></div>
			
			<input type="submit" name="submit" value="'. $lang['Submit'] .'" class="btn btn-primary" />
			</form>
		</div>
		<script>
			$(function(){
				$("input[name=\'ssid\']").change(function(e){
					if( $(this).val() == "0"){ $("#newssid").show(200);} else { $("#newssid").hide(200);}
					if( $(this).attr("data-security") == "1"){ $("#wifi_password").show(200);} else { $("#wifi_password").val("").hide(200);}
				});
				$( "#wifiForm").submit( function(){
					$("#wifi_msg").html( "<img src=\"./style/img/loading.gif\" /> Configuring the wifi connection...").fadeIn();
					var formValues = $(this).serialize();
					$.post( "?'. $getQStr .'&", formValues, function( data){
						$("#wifi_msg").html( data).fadeIn().delay(5000).fadeOut("slow");
						setTimeout( function(){location.reload();}, 2000);
					});
					return false;
				});
			});
		</script>
		';

	return $out;
}

/*--------------------*/

function getLocation()
{
	$info = callAPI( 'location');
	//printr( $info);
	
	$out = "<table cellpadding=\"10\">";
	foreach( $info as $k => $v)
	{
		$out .= "<tr><td style=\"padding: 5px;\">$k :</td><td>$v</td></tr>";
	}
	$out .= "</table>";
	
	return $out .'
	<div id="mapid" style="width: 100%; height: 400px;"></div>
	<script>
		$(function(){
			var map = L.map("mapid").setView(['. $info['latitude'] .', '. $info['longitude'] .'], 8);
			L.tileLayer("https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1Ijoid2F6aWdhdGUiLCJhIjoiY2p3cms2eHQzMDByYjQwbnh6cjJzNG1kdCJ9.LqEwxWIQ65NmGgMi3GCQUg", {
				attribution: "Map data &copy; <a href=\"https://www.openstreetmap.org/\">OpenStreetMap</a> contributors, <a href=\"https://creativecommons.org/licenses/by-sa/2.0/\">CC-BY-SA</a>, Imagery © <a href=\"https://www.mapbox.com/\">Mapbox</a>",
				maxZoom: 10,
				id: "mapbox.streets"
			}).addTo(map);
			
			L.marker(['. $info['latitude'] .', '. $info['longitude'] .']).addTo(map)
				.bindPopup("My WaziGate")
				.openPopup();
			});
    </script>';
	
}

/*--------------------*/

//printr( $_GET); printr( $_POST); 
//printr( $_REQUEST);

?>
