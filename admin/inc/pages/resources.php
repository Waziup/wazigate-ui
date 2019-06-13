<?php
// unplanned execution path
defined( 'IN_WAZIHUB') or die( 'e902!');

//$conf	=	callAPI( 'system/conf');
$hwStatus = CallHost( 'hardware/status');

/*------------*/

$tabsData['clocks'] = array();
foreach( $hwStatus['clocks'] as $k => $v)
{
	$tabsData['clocks'][] = array( $k , $v .' MHz');
}

$tabsData['volts'] = array();
foreach( $hwStatus['volts'] as $k => $v)
{
	$tabsData['volts'][] = array( $k , $v .' V');
}

$tabsData['mem'] = array();
foreach( $hwStatus['mem_alloc'] as $k => $v)
{
	$tabsData['mem'][] = array( $k , $v);
}

unset( $hwStatus['mem_usage']['percent']);
$tabsData['mem'][] = array( '', '');
foreach( $hwStatus['mem_usage'] as $k => $v)
{
	$tabsData['mem'][] = array( $k , round($v/1000000) .' MB');
}

$tabsData['config'] = array();
foreach( explode( "\n", $hwStatus['config']) as $v)
{
	$tabsData['config'][] = array( $v);
}


/*------------*/

$templateData = array(

	'icon'	=>	$pageIcon,
	'title'	=>	$lang['Resources'],
	'msgDiv'=>	'msg',
	'tabs'	=>	array(
		
		/*-----------*/
		
		array(
			'title'		=>	$lang['ResourceUsage'],
			'active'	=>	true,
			'notes'		=>	'',
			'content'	=>	array(
				
				array( resUsage()),
			),
		),
		
		/*-----------*/
		
		array(
			'title'		=>	'Remote.it',
			'active'	=>	false,
			'notes'		=>	'',
			'content'	=>	array(
				
				array( 'Remote.it', remoteItStatus()),
			),
		),
		
		/*-----------*/
	
		array(
			'title'		=>	'Memory',
			'active'	=>	false,
			'notes'		=>	'',
			'content'	=>	$tabsData['mem'],
		),
		
		/*-----------*/
		
		array(
			'title'		=>	'Clocks',
			'active'	=>	false,
			'notes'		=>	'',
			'content'	=>	$tabsData['clocks'],
		),
		
		/*-----------*/

		array(
			'title'		=>	'Voltages',
			'active'	=>	false,
			'notes'		=>	'',
			'content'	=>	$tabsData['volts'],
		),
		
		/*-----------*/
		
		array(
			'title'		=>	'Config',
			'active'	=>	false,
			'notes'		=>	'',
			'content'	=>	$tabsData['config'],
		),
		
		/*-----------*/
		
	),
);

/*------------*/

require( './inc/template_admin.php');

/*------------*/


function remoteItStatus()
{
	$notRegistered = printEnabled( false, 'Done', 'NotRegistered');

	return '<div id="remoteSinkAjx"></div>
	  <script>
		  function loadRemoteStatus()
		  {
		  	$("#remoteSinkAjx").html( "<p align=\"center\"><img src=\"./style/img/loading.gif\" /></p>").fadeIn();
		  	$.get( "?get=remote.it", function( data){
				out = "";
				res = JSON.parse( data);
				if( res)
				{
					if( typeof res.msg != "undefined")
					{
						out = "<b>"+ res.msg +"</b>";
						setTimeout( loadRemoteStatus, 3000);

					}else{
						out = "<table cellpadding=\"10\">";
						for( var key in res)
						{
							out += "<tr><td style=\"padding: 5px;\">"+ key +" :</td><td><b>"+ res[key].replace(/\n/g, "<br />") +"</b></td></tr>";
						}
						out += "</table>";
					}
				}else{
					out = \''. $notRegistered .'\';
				}
				$("#remoteSinkAjx").html( out).fadeIn();
			});
			return true;
		  }
		  $(function(){ loadRemoteStatus();});
	 </script>';	
}

/*------------*/

function resUsage()
{
	return '<script>
		var cpuData = [];
		var ramData = [];
		var tmpData = [];
		var totalPoints = 100;
		var updateInterval = 2000;
		var now = new Date().getTime();

		/*-----------*/

		function ChartOptions()
		{
			this.options = {
				series: {
				    lines: {
				        show: true,
				        lineWidth: 1,
				        shadowSize: 0,
				        fill: false
				    }
				},
				xaxis: { show: false},
				yaxis: {
				    min: 0,
				    max: 100,
				    tickSize: 25,
				    axisLabelUseCanvas: true,
				    axisLabelFontSizePixels: 14,
				    axisLabel: "Title",
				    axisLabelFontFamily: "Verdana, Arial",
				    axisLabelPadding: 6
				},
				legend: {
				    labelBoxBorderColor: "#FFF"
				}
			};
		}
		
		/*-----------*/
		
	    cpuOptions = new ChartOptions(); 
	    cpuOptions.options.yaxis.axisLabel = "CPU Usage";
	    
	    ramOptions = new ChartOptions();
	    ramOptions.options.yaxis.axisLabel = "RAM Usage";
	    
	    tmpOptions = new ChartOptions();
	    tmpOptions.options.yaxis.axisLabel = "Temperature (C)";
	    tmpOptions.options.yaxis.tickFormatter = null;
	    
	    function updateCharts( cpuData, ramData, tmpData)
	    {
			$.plot($("#flot-cpu"), [{ label: "CPU ("+ parseInt( cpuData[cpuData.length - 1][1]) +"%)", data: cpuData, color: "#00FF00"}], cpuOptions.options);
			$.plot($("#flot-ram"), [{ label: "RAM ("+ parseInt( ramData[ramData.length - 1][1]) +"%)", data: ramData, color: "#0000FF"}], ramOptions.options);
			$.plot($("#flot-tmp"), [{ label: "TEMP ("+ parseInt( tmpData[tmpData.length - 1][1])  +")", data: tmpData, color: "#FF0000"}], tmpOptions.options);
	    }
	    
	    /*-----------*/
		
		function GetData() 
		{
		    if( cpuData.length > totalPoints) cpuData.shift();
		    if( ramData.length > totalPoints) ramData.shift();
		    if( tmpData.length > totalPoints) tmpData.shift();

		    $.get( "?get=hardware_status", function( data){
				res = JSON.parse( data);
				
				cpuData.push( [ now, res.cpu_usage]);
				ramData.push( [ now, res.mem_usage.percent]);
				tmpData.push( [ now, res.temp]);
				
				now += updateInterval;
				
				desc  = "Available RAM: <b>"+ parseInt( res.mem_usage.available / 1000000) + "</b>MB";
				desc += "<br /> Available Disk Space: <b>"+ res.disk.available + "</b>";
				$("#desc").html( desc);
				
				updateCharts( cpuData, ramData, tmpData);
				setTimeout( GetData, updateInterval);
			});
		}
		
		/*-----------*/

		$(function(){ GetData();});
	</script>
	<!-- HTML -->
	<div id="flot-cpu" style="width:100%;height:250px;margin:0 auto"></div><br />
	<div id="flot-tmp" style="width:100%;height:200px;margin:0 auto"></div><br />
	<div id="flot-ram" style="width:100%;height:200px;margin:0 auto"></div><br />
	<div id="desc" style="width:100%;margin:0 auto; padding:5px;text-align:center;"></div><br />';
}

/*------------*/

?>
