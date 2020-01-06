<?php

/*-------------------*/

function is_connected(){

	// $headers = get_headers( "https://www.waziup.io");
	//$headers = @get_headers( "https://api.waziup.io/api/v2/ontologies/units");
	//if( empty( $headers)) return false;

	
	$res = callAPI( 'internet');
	
	return $res == "1";
}


/*-------------------*/

function read_database_json()
{
	$json_src = file_get_contents( getRootDir() .'../conf/database.json');
	return json_decode( $json_src, true);
}

/*-------------------*/

function set_profile( $new_username, $new_password)
{
	$jsonContent = array(
		'username'	=>	$new_username,
		'password'	=>	$new_password,
	);

	$fp = fopen( getRootDir() .'../conf/database.json', 'w');
	fwrite( $fp, json_encode( $jsonContent));
	fclose( $fp);
}

/*-------------------*/

//TODO: Need to make it work
function low_level_gw_status(){
	return false;
	return shell_exec("sudo /var/www/html/admin/libs/sh/web_shell_script.sh low_level_gw_status");
}

/*-------------------*/

//TODO: Need to make it work
function send_downlink($dst, $msg){
	return false;
	return shell_exec("sudo /var/www/html/admin/libs/sh/web_shell_script.sh downlink_request ".$dst." ".$msg);
}

/*-------------------*/

function display_array($arr){
	for($i = 0; $i < sizeof($arr); $i++ ){	
		if($i == sizeof($arr)-1)		
			echo $arr[$i];
		else
			echo $arr[$i].", ";
	}
}

/*-------------------*/

function check_login($db_log, $db_pwd, $form_log, $form_pwd){
	return $db_log==$form_log && $db_pwd==$form_pwd;
}

/*-------------------*/

function printr( $msg, $dump = false)
{
	print( '<pre style="background-color:#EC0;padding:2px;">');
	$dump ? var_dump( @$msg) : print_r( @$msg);
	print( '</pre>');
}

/*-------------------*/

function timer()
{
    return microtime( true);
}

/*-------------------*/

function getRootDir()
{
	return dirname( __FILE__). '/../';
}

/*--------------------------*/

function printEnabled( $val , $enText = 'Enabled', $disText = 'Disabled')
{
	global $lang;
	if( $val) return( '<div class="enabled"><i class="fa fa-check"></i> '. $lang[ $enText ] .'</div>'); 

	return( '<div class="err"><i class="fa fa-remove"></i> '. $lang[ $disText ] .'</div>');
}

/*--------------------------*/


function getGPScoordinates()
{
	global $conf, $_cfg;
	if( empty( $conf)) $conf = callAPI( 'system/conf');

	return '<div id="latitude_value" class="display:inline">
		Latitude : '. $conf['gateway_conf']['ref_latitude'] .'
	</div>
	<div id="longitude_value" class="display:inline">
	 	Longitude : '. $conf['gateway_conf']['ref_longitude'] .'
	</div>';
}

/*----------------*/

function getRadioFreq()
{
	global $conf, $_cfg;
	
	if( empty( $conf)) $conf = callAPI( 'system/conf');
	
	return $conf['radio_conf']['freq'] != -1 ? $_cfg['loraFreqs'][ $conf['radio_conf']['band']] : printEnabled( $conf['radio_conf']['freq'] != -1, 'Accessible', 'NotSet');

}

/*----------------*/

function getLowLevelStatus()
{
	$output = low_level_gw_status();
	if( empty( $output))
		return '<div class="err">NEED TO WORK ON THE API<br /><i class="fa fa-remove"></i> Desynchronization => '.date('Y-m-d H:i:s') .'</div>';

	$date = explode(".", $output );
	return '<i class="fa fa-check"></i> Last low-level gateway status ON:'. $date[0]; 
}

/*--------------------*/

function editEnabled( $field )
{
	global $_cfg, $lang;
	static $counter = 0;

	
	
	//isset( $field['id']) 			or $field[ '' ] = '';
	isset( $field['enText'])		or $field[ 'enText' ]	= 'ON';
	isset( $field['disText'])		or $field[ 'disText' ]	= 'OFF';
	isset( $field['value']) 		or $field[ 'value' ]	= false;
	isset( $field['callbackJS']) 	or $field[ 'callbackJS' ]	= '';
	

	if( !empty( $field['source']))
	{
		$field[ 'value' ]	=	@$field['source'][1] == $field[ 'value' ];
		$field['params']	=	array_merge( $field['params'], $field['source']);
	}

	$field['params']['name'] = $field['id'];
	$getQStr = http_build_query( $field['params']);
	
	$htmlId = str_replace( '-', '', $field['id']) . ($counter++); //Escape problematic characters
	
	return '<input type="hidden" class="custom-switch" '. ( $field[ 'value' ] ? 'checked' : '') .' name="'. $htmlId .'" id="'. $htmlId .'" data-url="./?'. $getQStr .'" data-textOn="'. $field[ 'enText' ] .'" value="'. $field[ 'value' ] .'" data-textOff="'. $field['disText'] .'" data-trackColorOn="#512DA8" data-trackColorOff="#616161" data-textColorOff="#fff" data-trackBorderColor="#555" />
	<div style="display:none" class="inline-msg" id="'. $htmlId .'_msg"></div>
	<script>function '. $htmlId .'_trigger(){'. $field['callbackJS'] .'}</script>';

}
/*--------------------*/

function editText( $field )
{
	global $_cfg, $lang;
	
	//isset( $field['id']) 		or $field[ '' ] = '';
	isset( $field['pholder'])	or $field[ 'pholder' ]	= '';
	isset( $field['note']) 		or $field[ 'note' ]		= '';
	isset( $field['value']) 	or $field[ 'value' ]	= '';
	isset( $field['type']) 		or $field[ 'type' ]		= 'text';
	isset( $field['source']) 	or $field[ 'source' ]	= '';
	isset( $field['send']) 		or $field[ 'send' ]		= 'auto';
	isset( $field['class']) 	or $field[ 'class' ]	= 'inlineEdit';
	
	isset( $field['cache']) 	or $field[ 'cache' ]	= 'true';

	isset( $field['params'])	or $field[ 'params' ]	= array();
	$getQStr = http_build_query( $field['params']);
	
	if( is_array( $field[ 'source' ]))
	{
		$out = '[';
		
		foreach( $field[ 'source' ] as $k => $v)
		{
			$out .= "{value: '$k', text: '$v'},";
		}
		$out = rtrim( $out, ',');
		$out .= ']';
		$field[ 'source' ] = $out;

	}//End of if( is_array( $field[ 'source' ]));

	return '<div id="div_update_'. $field['id'] .'" class="form-group">
		<a href="#" id="'. $field['id'] .'" class="'. $field['class'] .'" data-pk="1" data-sourceCache="'. $field[ 'cache' ] .'" data-url="./?'. $getQStr .'" data-type="'. $field[ 'type' ] .'" data-placement="right" data-send="'. $field['send'] .'" data-source="'. $field[ 'source' ] .'" data-title="" data-placeholder="'. $field['pholder'] .'">'. $field['value'] .'</a>
		<div style="display:none" class="inline-msg" id="'. $field['id'] .'_msg"></div>
		<p style="display:none" id="'. $field['id'] .'_note">
			<font color="red">
				'. $field['note'] .'
			</font>
		</p>
	</div>
	';
}

/*--------------------*/

function urlLabel( $field )
{
	global $_cfg, $lang;
	static $counter = 0;

	//isset( $field['id'])	or $field[ '' ] = '';
	isset( $field['value'])	or $field[ 'value' ] = '';
	isset( $field['url'])	or $field[ 'url' ] = '';

	return '<a href="#" id="'. $field['id'] .'_label" class="urlLabel" data-url="'. $field[ 'url' ] .'">'. $field['value'] .'</a>';

}

/*--------------------*/

function editRadioFreq( $advance = false)
{
	global $_cfg, $conf, $lang;
	
	if( empty( $conf)) $conf = callAPI( 'system/conf');

	$out = '<div class="form-group">
        		<label>ISM Band</label>
        		<select id="band_freq_select" class="form-control">';

		foreach( $_cfg['loraFreqs'] as $key => $val)
		{
			$selected = $key == $conf['radio_conf']['band'] ? 'selected="selected"' : '';
			$out .= "<option $selected value='$key'>$val</option>";
		}

		$out .=  '</select>
	   			<label style="'. ( $advance ? '' : 'display:none') .'">Frequency</label>
				<select style="'. ( $advance ? '' : 'display:none') .'" id="freq_select" class="form-control">
	   			</select>
			</div>
		<button id="freq_submit" type="submit" class="btn btn-primary">
			'. $lang['Submit'] .'<span class="fa fa-arrow-right"></span>
		</button>
		<script>
			$(function(){
				$("#band_freq_select").trigger("change");
				$("#freq_select").val( "'. $conf['radio_conf']['freq'] .'");
			});
		</script>';
		
		//array( 'cfg' => 'system/conf', 'conf_node' => 'gateway_conf'),

	return $out;
}

/*--------------------*/

function getAllLangs()
{
	$langs = array();
	foreach( glob( getRootDir() . 'lang/*') as $file)
	{
		$lang = require( $file);
		if( $lang['ACTIVE']) $langs[ basename( $file, '.php')] = $lang['TITLE'];
	}
	return $langs;
}

/*--------------------*/

function getNetwokIFs()
{
	return CallAPI( 'system/wifi/devices');
}

/*--------------------*/

function CallEdge( $name, $data = false, $method = 'GET', $json = true, $getHTTPcode = false)
{
	global $_cfg;
	//Calling wazigate-edge API
	return restCall( $_cfg['EdgeServer'], $name, $data, $method, $json, $getHTTPcode);
}

/*--------------------*/

function CallAPI( $name, $data = false, $method = 'GET', $json = true, $getHTTPcode = false)
{
	global $_cfg;
	//Calling wazigate-system API
	return restCall( $_cfg['APIServer'], $name, $data, $method, $json, $getHTTPcode);
}

/*--------------------*/

function CallHost( $name, $data = false, $method = 'GET', $json = true, $getHTTPcode = false)
{
	global $_cfg;
	//Calling wazigate-host API
	return restCall( $_cfg['HostServer'], $name, $data, $method, $json, $getHTTPcode);
}

/*--------------------*/

function restCall( $apiInfo, $name, $data = false, $method = 'GET', $json = true, $getHTTPcode = false)
{
	$curl = curl_init();
	
    $url = $apiInfo['URL'] . $name;
    $data_json = $json ? json_encode( $data) : @http_build_query( $data);
    
	// printr( $url);printr( $data_json);

    switch( $method)
    {
        case "POST":
            
			curl_setopt( $curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
			curl_setopt( $curl, CURLOPT_POST, 1);
			curl_setopt( $curl, CURLOPT_POSTFIELDS, $data_json);

            break;

        case "PUT":
            curl_setopt( $curl, CURLOPT_PUT, 1);
            curl_setopt( $curl, CURLOPT_POSTFIELDS, $data_json);
            curl_setopt( $curl, CURLOPT_HTTPHEADER, array(
            							'Content-Type: application/json',
            							'Content-Length: '. strlen( $data_json)
            						)
            		);
            
            break;

        default:
            if( $data)
                $url = sprintf( "%s?%s", $url, http_build_query( $data));

    }//End of switch( $method);

    //<!-- Authentication:
    if( !empty( $apiInfo['username']))
    {
		curl_setopt( $curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt( $curl, CURLOPT_USERPWD, $apiInfo['username'] .':'. $apiInfo['password']);
	}
	
	
    curl_setopt( $curl, CURLOPT_URL, $url);
    curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1);
	
    $result		= curl_exec( $curl);
    if( $json)	$result = json_decode( $result, true);
    
    if( $getHTTPcode)
    { 
		if( !is_array( $result)) $result['res'] = $result;
		$result['httpcode'] = curl_getinfo( $curl, CURLINFO_HTTP_CODE);
	}
    
    curl_close( $curl);

    return $result;
}

/*--------------------*/

function strbool( $str)
{
	return $str == 'true';
}

/*--------------------*/

//Update the local copy of Waziup.io
function waziDocsUpdateCheck()
{
	global $_cfg;
	$res = array();
	
	$content = file_get_contents( $_cfg['wazidocs']['git']);
	
	preg_match('/(Commits\ on)([^<]+)/', $content, $matches, PREG_OFFSET_CAPTURE);
	$strDate = trim( $matches[2][0]);

	$res['latestVer']	= date( 'Y-m-d', strtotime( $strDate));
	$res['currentVer']	= date( 'Y-m-d', @filectime( getRootDir() .'../waziup.io'));

	if( $res['latestVer'] > $res['currentVer'])
	{
		$res['doUpdate'] = true;
	}
	
	return $res;
}

/*--------------------*/

function waziDocsUpdateDo()
{
	//TODO
	printr( 'TODO....');
	set_time_limit(0);
	printr( shell_exec( 'ls -al'));
}

/*--------------------*/

function formatFileSize( $bytes, $precision = 2)
{
	$units = array('B', 'KB', 'MB', 'GB', 'TB'); 

    $bytes = max( $bytes, 0); 
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
    $pow = min($pow, count($units) - 1); 

    // Uncomment one of the following alternatives
    $bytes /= pow(1024, $pow);
    // $bytes /= (1 << (10 * $pow)); 

    return round( $bytes, $precision) . ' ' . $units[$pow];    
}

/*--------------------*/

function ajaxLoad( $params)
{
	global $lang;
	
	static $seq = 0;
	$seq++;

	$getQStr = http_build_query( $params);

	return'<div id="ajaxLoad_'. $seq .'"></div>
			<script>
			$(function(){
				$("#ajaxLoad_'. $seq .'").html( "<img src=\"./style/img/loading.gif\" /> '. $lang['Loading'] .'...").fadeIn();
				$.get( "?get=ajaxLoad&'. $getQStr .'", function( data){
					$("#ajaxLoad_'. $seq .'").html( data).fadeIn();
				});
			})
	 </script>';
	
	
}

/*--------------------*/

function jsRedirect( $url, $msg = 'Home')
{
	print( '<!DOCTYPE html><html>
	<head>
			<style>
			.container {
				width: 100%;
				max-width: 100% ;
				text-align: center;
			}
			.wrapper {
				width: 100%;
				padding: 10px 30px;
				background: #EEE;
				border: 3px solid #A3A3A3; 
				border-radius: 25px;
			}
	
			.center {
				position: absolute;
				top: 50%;
				left: 50%;
				-moz-transform: translateX(-50%) translateY(-50%);
				-webkit-transform: translateX(-50%) translateY(-50%);
				transform: translateX(-50%) translateY(-50%);
			}
			p { color: #005;}
			h2 { color: #005;}
			
			.col-md-6 {
				float: left;
				padding-bottom: 100px;
			}        
			.css-loader {
				border: 16px solid #f3f3f3; 
				border-top: 16px solid #335; 
				border-radius: 50%;
				width: 50px;
				height: 50px;
				animation: spin 1s linear infinite;
				margin-left:35%;
			}
	
			@keyframes spin {
				0% { transform: rotate(0deg); }
				100% { transform: rotate(360deg); }
			}
			#msg{
				clear:both;
			}
		</style>
	
	</head>
	<body>
		<div class="center">
			<div class="wrapper">
				<div class="container">
					<h3>Redirecting <a href="'. $url .'">'. $msg .'</a> ...</h3>
					<div class="container clear clear-fix">
						<div class="css-loader"></div>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			window.location.href="'. $url .'";
		</script>
	</body>
	</html>');
}

/*--------------------*/

?>