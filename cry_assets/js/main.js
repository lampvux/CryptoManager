document.addEventListener('DOMContentLoaded', function() {
	// START AREA CHART
	google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawAreaChart);

    function drawAreaChart() {
        var data = google.visualization.arrayToDataTable([
          ['Year', 'Sales', 'Expenses'],
          ['2013',  1000,      400],
          ['2014',  1170,      460],
          ['2015',  660,       1120],
          ['2016',  1030,      540]
        ]);

        var options = {
          title: 'Company Performance',
          hAxis: {title: 'Year',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }
    // END AREA CHART


    // START BIG PIE CHART
	google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawPieChart);

    function drawPieChart() {
    	var data = new google.visualization.DataTable();
		data.addColumn('string', 'Task');
		data.addColumn('number', 100);
		data.addRows([
  			['Work', 22],
  			['Eat', 22],
  			['Commute', 22],
  			['Watch TV', 22],
  			['Sleep', 12]
		]);

        var options = {
          title: 'My All Wallets'
        };

        var chart = new google.visualization.PieChart(document.getElementById('big-piechart'));

        chart.draw(data, options);
    }
    // END BIG PIE CHART


    // START SMALL PIE CHART

    // chart 1
	var chart = window.chart = new EasyPieChart(document.querySelector('.chart'), {
		easing: 'easeOutElastic',
		delay: 3000,
		barColor: '#69c',
		trackColor: '#ace',
		scaleColor: false,
		lineWidth: 20,
		trackWidth: 16,
		lineCap: 'butt',
		onStep: function(percent) {
			this.el.children[0].innerHTML = Math.round(percent);
		}
	});

	// chart2
	var chart = window.chart = new EasyPieChart(document.querySelector('.chart2'), {
		easing: 'easeOutElastic',
		delay: 3000,
		barColor: '#69c',
		trackColor: '#ace',
		scaleColor: false,
		lineWidth: 20,
		trackWidth: 16,
		lineCap: 'butt',
		onStep: function(percent) {
			this.el.children[0].innerHTML = Math.round(percent);
		}
	});

	// chart3
	var chart = window.chart = new EasyPieChart(document.querySelector('.chart3'), {
		easing: 'easeOutElastic',
		delay: 3000,
		barColor: '#69c',
		trackColor: '#ace',
		scaleColor: false,
		lineWidth: 20,
		trackWidth: 16,
		lineCap: 'butt',
		onStep: function(percent) {
			this.el.children[0].innerHTML = Math.round(percent);
		}
	});

	// END SMALL PIE CHART

});

$(function(){
	$('#myTable').DataTable();
});