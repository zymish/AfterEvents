Highcharts.theme = {
	chart: {
		backgroundColor: {
			linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
			stops: [
				[0, 'rgba(96, 96, 96,0)'],
				[1, 'rgba(16, 16, 16,0)']
			]
		},
		borderWidth: 0,
		borderRadius: 15,
		plotShadow: false
	}
};

// Apply the theme
var highchartsOptions = Highcharts.setOptions(Highcharts.theme);
