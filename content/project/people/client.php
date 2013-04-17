<div class="row-fluid">
	<div class="span6" id='tickets-widget'>
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-bar-chart"></i>
                </span>
                <h5>Tickets Bought</h5>
				<span class='icon icon-pull-right' onclick='hideMetric("#tickets-widget")'>
					<i class='icon icon-remove'></i>
				</span>
				<span class='icon icon-pull-right' onclick='openMetricSettings()'>
					<i class='icon icon-cog'></i>
				</span>
            </div>
            <div class="widget-content">
                <div id="tickets-bought"></div>
            </div>
        </div>
    </div>
	<div class='span6' id='attendance-widget'>
		<div class='widget-box'>
			<div class='widget-title'>
				<span class='icon'>
					<i class='icon-bar-chart'></i>
				</span>
				<h5>Guest Attendance</h5>
				<span class='icon icon-pull-right' onclick='hideMetric("#attendance-widget")'>
					<i class='icon icon-remove'></i>
				</span>
				<span class='icon icon-pull-right' onclick='openMetricSettings()'>
					<i class='icon icon-cog'></i>
				</span>
			</div>
			<div class='widget-content'>
				<div id='guest-attendance'></div>
			</div>
		</div>
	</div>
</div>
<div class='row-fluid'>
	<div class='span6' id='random-widget'>
		<div class='widget-box'>
			<div class='widget-title'>
				<span class='icon'>
					<i class='icon-bar-chart'></i>
				</span>
				<h5>Live Random Data</h5>
				<span class='icon icon-pull-right' onclick='hideMetric("#random-widget")'>
					<i class='icon icon-remove'></i>
				</span>
				<span class='icon icon-pull-right' onclick='openMetricSettings()'>
					<i class='icon icon-cog'></i>
				</span>
			</div>
			<div class='widget-content'>
				<div id='live-chart'></div>
			</div>
		</div>
	</div>
</div>
<div id='metric-settings' class='modal hide fade'>
	<div class="modal-header">
    	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    	<h3>Settings</h3>
    </div>
    <div class="modal-body alert">You cannot yet edit settings for metric displays.</div>
    <div class="modal-footer"><button type="button" class="btn btn-success" onClick="$('#metric-settings').modal('hide')">OK</button></div>
</div>
<script>
function hideMetric(which){
	$(which).html("<div class='widget-box'><div class='widget-title'><h5>This will be hidden.</h5></div></div>");
}
function openMetricSettings(){
	$('#metric-settings').modal({});
}
$(document).ready(function(e) {
	Highcharts.setOptions({
		global: {
			useUTC: false
		}
	});
	var chart = new Highcharts.Chart({
		chart: {
			renderTo: 'live-chart',
			type: 'spline',
			marginRight: 10,
			events: {
				load: function() {

					// set up the updating of the chart each second
					var series = this.series[0];
					setInterval(function() {
						var x = (new Date()).getTime(), // current time
							y = Math.random();
						series.addPoint([x, y], true, true);
					}, 1000);
				}
			}
		},
		title: {
			text: 'Live random data'
		},
		xAxis: {
			type: 'datetime',
			tickPixelInterval: 150
		},
		yAxis: {
			title: {
				text: 'Value'
			},
			plotLines: [{
				value: 0,
				width: 1,
				color: '#808080'
			}]
		},
		tooltip: {
			formatter: function() {
					return '<b>'+ this.series.name +'</b><br/>'+
					Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) +'<br/>'+
					Highcharts.numberFormat(this.y, 2);
			}
		},
		colors: [
			'#D91426',
			'#8A8A8A',
			'#3F4042'
		],
		legend: {
			enabled: false
		},
		exporting: {
			enabled: false
		},
		series: [{
			name: 'Random data',
			data: (function() {
				// generate an array of random data
				var data = [],
					time = (new Date()).getTime(),
					i;

				for (i = -19; i <= 0; i++) {
					data.push({
						x: time + i * 1000,
						y: Math.random()
					});
				}
				return data;
			})()
		}]
	});
	var chart = new Highcharts.Chart({
		chart: {
			renderTo: 'tickets-bought',
			type: 'column'
		},
		title: {
			text: 'Tickets Bought'
		},
		subtitle: {
			text: '(only shows purchases, does not reflect attendance)'
		},
		xAxis: {
			categories: [
				'Day 1 (Friday)',
				'Day 2 (Saturday)',
				'Day 3 (Sunday)'
			]
		},
		yAxis: {
			min: 0,
			title: {
				text: 'Tickets'
			}
		},
		legend: {
			layout: 'vertical',
			backgroundColor: '#FFFFFF',
			align: 'left',
			verticalAlign: 'top',
			x: 100,
			y: 70,
			floating: true,
			shadow: true
		},
		colors: [
			'#D91426',
			'#8A8A8A',
			'#3F4042'
		],
		tooltip: {
			formatter: function() {
				return ''+
					this.x +': '+ this.y +' tickets';
			}
		},
		plotOptions: {
			column: {
				pointPadding: 0.2,
				borderWidth: 0
			}
		},
			series: [{
			name: 'Adults',
			data: [136, 225, 148]

		}, {
			name: 'Children',
			data: [84, 105, 104]

		}, {
			name: 'Seniors',
			data: [15, 27, 30]

		}]
	});
	var chart = new Highcharts.Chart({
		chart: {
			renderTo: 'guest-attendance',
			plotBackgroundColor: null,
			plotBorderWidth: null,
			plotShadow: false
		},
		colors: [
			'#D91426',
			'#8A8A8A',
			'#3F4042'
		],
		title: {
			text: 'Guest Attendance by Location'
		},
		tooltip: {
			pointFormat: '{series.name}: <b>{point.percentage}%</b>',
			percentageDecimals: 1
		},
		plotOptions: {
			pie: {
				allowPointSelect: true,
				cursor: 'pointer',
				dataLabels: {
					enabled: true,
					color: '#000000',
					connectorColor: '#000000',
					formatter: function() {
						return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
					}
				}
			}
		},
		series: [{
			type: 'pie',
			name: 'Guests',
			data: [
				['Los Angeles',   51.0],
				['San Francisco',       30.8],
				{
					name: 'San Diego',
					y: 18.2,
					sliced: true,
					selected: true
				}
			]
		}]
	});
});
</script>