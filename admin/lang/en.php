<?php

return array(

	'ACTIVE'		=>	true, // if true: shows it on the ui

	'LANG'			=>	'en',
	'TITLE'			=>	'English',
	'LDIR'			=>	'ltr', // ltr, rtl, auto
	
	'SignInMsg'		=>	'Please Sign In',
	'Login'			=>	'Login',
	'Username'		=>	'Username',
	'Email'			=>	'Email Address',
	'Password'		=>	'Password',
	'LoginError'	=>	'Please enter a valid username and password!',

	'AdminPageTitle' 	=>	'WaziGate Administration',
	'OverviewTitle'		=>	'Gateway Overview',
	'CannotDetermined'	=>	'Cannot be determined!',
	'Radio'			=>	'LoRa Radio',
	'Basic'			=>	'Basic',
	'Advance'		=>	'Advanced',
	'Enabled'		=>	'Enabled',
	'Disabled'		=>	'Disabled',
	'Accessible'	=>	'Accessible',
	'NoInternet'	=>	'No Internet!',
	'NotSet'		=>	'Not Set',
	'Registered'	=>	'Registered',
	'Internet'		=>	'Internet',

	'BasicConfTitle'=>	'Basic Configurations',
	'Gateway'		=>	'Gateway',
	'RadioFreq'		=>	'Radio Frequency',
	'LoRaBand'		=>	'LoRa Band',
	'LoraMode'		=>	'LoRa Mode',
	'Encryption'	=>	'LoRa Encryption (AES)',
	'GPScoordinates'=>	'GPS coordinates',
	'SelectAmode'	=>	'Select a mode',
	'GatewayID'		=>	'Gateway ID',
	'MacAddress'	=>	'Mac address',
	'IPaddress'		=>	'IP address',

	'GatewayIDWarning'		=>	'WARNING: the gateway id is normally derived from the MAC address of the gateway. When you run Update/Basic config the gateway id will be automatically determined so it is not recommended to manually edit the gateway id.',
	
	'NewValue'		=>	'New value',
	'Submit'		=>	'Submit',
	'RawFormat'		=>	'Raw format',
	'wappkey'		=>	'Wapp Key',
	'AdvanceConfTitle'		=>	'Advanced Configurations',
	
	'NotifsTitle'	=>	'Notifications',
	'AlertMail'		=>	'Alert Mail',
	'AlertSMS'		=>	'Alert SMS',
	'Activation'	=>	'Activation',
	'MailAccount'	=>	'Mail Account',
	'MailPassword'	=>	'Mail Password',
	'Empty'			=>	'Empty',
	'MailServer'	=>	'Mail Server',
	'MailRecievers'	=>	'Mail Recievers',
	'MailRecieversNote'	=>	'Please enter one email address per line.',

	'Notes_Overview_Basic'		=>	'',
	'Notes_Overview_Advance'	=>	'',
	'Notes_Overview_Maintenance'=>	'',
	'Notes_BasicConf_Radio'		=>	'',
	'Notes_BasicConf_Gateway'	=>	'<ul>
										<li>
											The <tt>Gateway Name</tt> is a custom user defined name for yourself to be able to identify this particular gateway on your waziup cloud dashboard. 
										</li>										
									</ul>',
	'Notes_AdvanceConf_Radio'	=>	'',
	'Notes_AdvanceConf_Gateway'	=>	'',
	'Notes_Notifs_Mail'			=>	'The email and SMS notifications are just for alerting when the gateway is booting and on radio reset',
	'Notes_Notifs_SMS'			=>	'The email and SMS notifications are just for alerting when the gateway is booting and on radio reset',
	'Notes_Test_Downlink'		=>	'',
	'Notes_Test_Logs'			=>	'',
	'Notes_Cloud_Waziup'		=>	'<ul>
										<li>
											The <tt>Gateway Name</tt> is a custom user defined name for yourself to be able to identify this particular gateway on your waziup cloud dashboard. 
										</li>										
										<li>
											The <tt>Email address</tt> is the one used as your WAZIUP username. <tt>password</tt> is your WAZIUP password. To create an account on the WAZIUP platform, go to <a href="https://dashboard.waziup.io">https://dashboard.waziup.io</a>. 
										</li>
										<li>
											The <tt>Server</tt> is the address of your MQTT waziup server. If you don\'t know what it is, just leave it empty.
										</li>
									</ul>',
	'Notes_SensorsList'			=>	'',
	'Notes_AdvanceConf_Clouds'	=>	'',
	'Notes_GPSConf_Clouds'		=>	'<ul>
										<li>
											<tt>Active Interval</tt> defines the time window to mark remote GPS devices as active. It is expressed in minutes.<br /><br />
										</li>
										<li>
											<b>Do not use space nor "/"</b> in any of these parameters, use "_" or "-" instead.
										</li>
									</ul>',
	'Notes_Profile'		=>	'',
	'Notes_Internet'	=>	'<b>Warning: activating the Wifi will disable the hotspot access point.</b><br />
	If the gateway cannot connect to the WiFi, it will switch back to the Access point.',
	'Notes_AP'			=>	'',
	'Notes_Cellular'	=> 	'You MUST reboot for changes to take effect.',
	'Loragna_G'			=> 	'Loragna Option',
	'SwitchAP'		=> 		'Switch to Hotspot Mode',
	''		=> 		'',
	''		=> 		'',
	''		=> 		'',
	''		=> 		'',
	''		=> 		'',
	''		=> 		'',
	''		=> 		'',
	''		=> 		'',
	''		=> 		'',
	
	/*------------------*/
	

	'PinCode'			=>	'Pin Code',
	'PinCode_Note'		=>	'Be sure that you can access to the sim card and thus change the pin code using telephone/smartphone.',
	'SMSRecievers'		=>	'SMS Recievers',
	'SMSRecievers_Note'	=>	'Please enter one phone number per line.',

	'TestDebugTitle'=>	'Test and Debug',
	'DownlinkReq'	=>	'Downlink Request',
	'SysLogs'		=>	'System Logs',
	'LoraLogs'		=>	'Lora Logs',
	'Destination'	=>	'Destination',
	'Message'		=>	'Message',
	'Clear'			=>	'Clear',
	'LogsDownload_All'	=>	'Download The entire content of log file',
	'LogsDownload_500L'	=>	'Load Last 500 lines of logs',
	'Logs_Auto_Referesh'=>	'Auto Referesh',
	'ClickHere'			=>	'Click Here',

	'Cloud'				=>	'WaziCloud',
	'Clouds'			=>	'Clouds',
	'CloudTitle'		=>	'WaziCloud Setup',
	'Domain'			=>	'Domain',
	'Visibility'		=>	'Visibility',
	'PublicVisibility'	=>	'Public Visibility',
	
	'Overview'			=>	'Overview',
	'Configurations'	=>	'Configurations',
	'SetupWizard'		=>	'Setup Wizard',
	'Maintenance'		=>	'Maintenance',
	'TestDebug'			=>	'Test & Debug',
	'UpdatingMsg'		=>	'This usually takes some time, please be patient.',
	'Rebooting'			=>	'Rebbooting the gateway...',
	'Update'			=>	'Update',
	'FullUpdate'		=>	'Full Update',
	'LastUpdate'		=>	'Last Update',
	'Notifications'		=>	'Notifications',
	'SensorsList'		=>	'Sensors List',
	'SensorsList_Note'	=>	'Add one sensor per line to your list',
	'CloudNoInternet'	=>	'Cloud No Internet',
	'cloudNodeRed'		=>	'Cloud Node Red',
	'CloudGpsFile'		=>	'Cloud Gps File',
	'ActiveInterval'	=>	'Active Interval',
	'ActiveIntervalNote'=>	'Interval in minutes',
	'SMS'				=>	'SMS',
	'CloudMQTT'			=>	'Cloud MQTT',
	
	'SavedSuccess'		=>	'Saved Successfully.',
	'SaveError'			=>	'Error Saving!',
	
	'Profile'			=>	'User Profile',
	'NewPassword'		=>	'New Password',
	'CurrentUsername'	=>	'Current Username',
	'CurrentPassword'	=>	'Current Password',
	'NewUsername'		=>	'New Username',
	'RepeatNewPassword'	=>	'Repeat New Password',
	'FillAll'			=>	'Please fill all fields!',
	'PasswordNotMatch'	=>	'The new password and the repeat do not match!',

	'Logout'			=>	'Logout',
	'Shutdown'			=>	'Shutdown',
	'Reboot'			=>	'Reboot',
	'ConfirmShutdown'	=>	'Confirm Shutdown',
	'ShutdownDialog'	=>	'<p>You are about to shutdown the gateway.<b><i class="title"></i></b></p>
		                <p>Note that physical access to gateway is needed to power on it again.</p>
		                <p>Do you want to proceed?</p>',
	
	'ConfirmReboot'		=>	'Confirm Reboot',
	'RebootDialog'		=>	'<p>You are about to reboot the gateway.<b><i class="title"></i></b></p>
                    <p>Note that you have to wait a while and then refresh the page.</p>
                    <p>Do you want to proceed?</p>',
	'LoginSuccess'		=>	'Login Successful.<br />Redirecting...',
	'Home'				=>	'Home',

	/*-------------------------------------*/

	'InternetConnectivity'	=>	'Internet Connectivity',
	'WiFiNetwork'			=>	'WiFi Network',
	'hiddenWiFiNetwork'		=>	'Add hidden network',
	'ConnectedWiFiNetwork'	=>	'Connected WiFi Network',
	'SSID'			=>	'SSID',
	
	'APSSIDNote'	=>	'You MUST reboot after submitting the command.',
	'Cellular'		=>	'Cellular',
	'CellularStatus'=>	'Current cellular configuration',
	'3G_boot'		=>	'Dongle on boot',
	'Loragna_boot'	=>	'Loranga on boot',
	'Loragna_2G'	=>	'Loranga 2G',
	'Loragna_3G'	=>	'Loragna 3G',
	'Documentations'=>	'Documentations',
	'APIDocs'		=>	'Gateway API Docs',
	'EdgeAPIDocs'	=>	'Edge API Docs',
	'WaziDocs'		=>	'Waziup Documentations',
	'Server'		=>	'Server',
	'Done'			=>	'Done',
	'NotRegistered'	=>	'Not Registered!',
	'time'			=>	'Time',
	'id'			=>	'ID',
	'Location'		=>	'Location',
	'Notes_Overview_Location'		=>	'This location calculated based on the IP of the gateway and so it may not be as accurate as the one measured by GPS. <br /> Please note that if you use VPN this service will show the location of your VPN server instead.',
	'msg'			=>	'Message',
	'ResourceUsage'	=>	'Resource Usage',
	'Resources'		=>	'Resources',
	'Logs'			=>	'Logs',
	'Containers'	=>	'Modules',
	'CreatedTime'	=>	'Created',
	'State'			=>	'State',
	'Status'		=>	'Status',
	'Actions'		=>	'Actions',
	'Success'		=>	'Done Successfully.',
	'Error'			=>	'Error! ',
	
	'Next'			=>	'Next',
	'Previous'		=>	'Previous',
	'Finish'		=>	'Finish',
	'Skip'			=>	'Skip',
	'Connect'		=>	'Connect',
	'Notes_Wizard_WiFi'		=>	'<b>Warning: activating the Wifi will disable the hotspot access point.</b><br />
	If the gateway cannot connect to the WiFi, it will switch back to the Access point.',
	'Notes_Wizard_Cloud'	=>	'<ul>
										<li>
											The <tt>Gateway Name</tt> is a custom user defined name for yourself to be able to identify this particular gateway on your waziup cloud dashboard. 
										</li>
										<li>
											The <tt>Email address</tt> is the one used as your WAZIUP username. <tt>password</tt> is your WAZIUP password. To create an account on the WAZIUP platform, go to <a href="https://dashboard.waziup.io">https://dashboard.waziup.io</a>. 
										</li>
									</ul>',
	'SaveLocation'		=>	'Save Location',
	'UpdateWaziupIO'	=>	'Update Offline Documentations',
	'UpdateGateway'		=>	'Update The Gateway Framework',
	
	'WiFiDongle'	=>	'WiFi Dongle',
	'NoDevice'		=>	'No Device Found',
	'Available'		=>	'Available',
	'Device'		=>	'Device',
	'ScanningWiFi'	=>	'Scanning for WiFi networks...',
	'Yes'			=>	'Yes',
	'No'			=>	'No',
	'Back'			=>	'Back',
	'gatewayReg'	=>	'Gateway Registration',
	'EmailLogin'	=>	'Email Address / Login',
	'GatewayName'	=>	'Gateway Name',
	'Loading'		=>	'Loading',
	'ConnectAndFinish'	=>	'Connect and Finish',
	'LoRa'			=>	'LoRa',
	'Skip'			=>	'Skip',
	'Help'			=>	'Help',
	'SysAPIDocs'	=>	'System API Docs',
	'UserManual'	=>	'User Manuals',
	'APMode'		=>	'Hotspot Mode',
	''		=>	'',
	''		=>	'',
	''		=>	'',
	''		=>	'',
	''		=>	'',
	''		=>	'',
	''		=>	'',
	''		=>	'',
	''		=>	'',
	''		=>	'',
	''		=>	'',
	''		=>	'',
	''		=>	'',
	''		=>	'',
	''		=>	'',
	''		=>	'',
	''		=>	'',
	''		=>	'',
	''		=>	'',
);

?>