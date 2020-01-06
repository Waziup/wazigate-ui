<?php
// unplanned execution path
defined( 'IN_WAZIHUB') or die( 'e902!');

//$conf	=	callAPI( 'conf');
$hwStatus = callAPI( 'usage');

/*------------*/
/*
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
/**/

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
				array( showMemUsage( $hwStatus['mem_usage']['total'], $hwStatus['mem_usage']['used'], 'RAM')),
				array( showMemUsage( $hwStatus['disk']['size'], $hwStatus['disk']['used'], 'Disk')),
			),
		),
		
		
		/*-----------*/
	
		/*array(
			'title'		=>	'Memory',
			'active'	=>	false,
			'notes'		=>	'',
			'content'	=>	$tabsData['mem'],
		),
		
		/*-----------*/
		
		/*array(
			'title'		=>	'Clocks',
			'active'	=>	false,
			'notes'		=>	'',
			'content'	=>	$tabsData['clocks'],
		),
		
		/*-----------*/

		/*array(
			'title'		=>	'Voltages',
			'active'	=>	false,
			'notes'		=>	'',
			'content'	=>	$tabsData['volts'],
		),
		
		/*-----------*/
		
		/*array(
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

				mem_usage = parseInt(( res.mem_usage.used / res.mem_usage.total) * 100);

				cpuData.push( [ now, res.cpu_usage]);
				ramData.push( [ now, mem_usage]);
				tmpData.push( [ now, res.temp]);
				
				now += updateInterval;
				
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
	';
}

/*------------*/

function showMemUsage( $total, $used, $title = '')
{
    $usedFrm	= formatFileSize( $used);
    $totalFrm	= formatFileSize( $total);
    $usedPercent = sprintf( '%.2f',($used / $total) * 100);
    
    $bgColors = array( '#A7C6FF', '#B7C626', '#A7A600');
    static $bgIndx = 0;

    return"
    <div class='progress'>
		<div class='prgtext'>
			<p style='float: left;padding-left:10px;'><b>$title</b></p>
			<b>$usedFrm</b> of <b>$totalFrm</b> used
		</div>
		<div class='prgbar' style='width:{$usedPercent}%;background:{$bgColors[ $bgIndx++ ]};'></div>
		<div class='prginfo'>
		    <span style='float: left;'></span>
		    <span style='clear: both;'></span>
		</div>
    </div>";

}

/*------------*/

//printr( $hwStatus);

?>