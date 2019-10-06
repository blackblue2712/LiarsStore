<!DOCTYPE HTML>
<html>
<head>
<script type="text/javascript">

window.onload = function () {
	var chart = new CanvasJS.Chart("chartContainer", {
        animationEnabled: true,
	    exportEnabled: true,
        theme: "dark",
        height:260,
		title:{
			text: "My First Chart in CanvasJS"              
        },
        axisY: {
            labelFontSize: 20,
            labelFontColor: "dimGrey",
            labelMaxWidth: 100,
            prefix: "%"
		},
		data: [              
		{
			// Change type to "doughnut", "line", "splineArea", etc.
			type: "column",
			dataPoints: [
				{ label: "apple", y: 95},
				{ label: "orange", y: 15  },
				{ label: "banana", y: 25  },
				{ label: "mango",  y: 30  },
				{ label: "grape",  y: 28  }
			]
		}
		]
	});
	chart.render();
}
</script>
</head>
<body>
<div id="chartContainer" style="height: 300px; width: 60%;"></div>
</body>
</html>