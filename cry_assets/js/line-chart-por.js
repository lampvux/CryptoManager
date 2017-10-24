// line
var z = document.getElementsByClassName("invest_data_all");

var dat_por = [];
for (var i = 0; i < z.length;i++) {
    dat_por.push(z[i].getAttribute("id"));
}
var por_val = [];
for (var i = 0; i < z.length;i++) {
    por_val.push(z[i].innerHTML);
}
var lineChartData5 = {
  labels : dat_por,
  datasets : [
    {
      label: "My First dataset3",
      fillColor : "rgba(220,220,220,0.2)",
      strokeColor : "rgba(220,220,220,1)",
      pointColor : "rgba(14, 16, 109,1)",
      pointStrokeColor : "#fff",
      pointHighlightFill : "#fff",
      pointHighlightStroke : "rgba(220,220,220,1)",
      data : por_val
    }
  ]
}


//pie
var pi_dat = document.getElementsByClassName("heolo");

var dat_pie = [];
for (var i = 0; i < pi_dat.length;i++) {
    dat_pie.push(pi_dat[i].getAttribute("data-value"));
}
var val_pie = [];
for (var i = 0; i < pi_dat.length;i++) {
    val_pie.push(pi_dat[i].getAttribute("data-name"));
}
var pieData = [];
for (var i = 0; i <dat_pie.length; i++) {
  pieData.push({
    value: parseFloat(dat_pie[i]),
    color: getRandomColor(),
    highlight: "#F7464A",
    label: val_pie[i]}
    )
}


for (var i = 0; i < pieData.length ; i++) {
    var text = "#pie_chart .legend ul li:nth-child("+(i+1)+")";
    var percent = "#pie_chart .legend ul li:nth-child("+(i+1)+") b ";
    jQuery(percent).text();
    jQuery(text).css("background",pieData[i]['color']);
    jQuery(text).css("color","#000000");
}

function getRandomColor() {
    var letters = '0123456789ABCDEF';
    var color = '#';
    for (var i = 0; i < 6; i++ ) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

window.onload = function(){
  if (jQuery("#port_data").length>0){
    var ctx5 = document.getElementById("port_data").getContext("2d");
    window.myLine = new Chart(ctx5).Line(lineChartData5, {
      responsive: false
    });
  }
  if (jQuery("#pieChart").length>0){
    var ctx3 = document.getElementById("pieChart").getContext("2d");
    window.myPie = new Chart(ctx3).Pie(pieData, {
      animation: true,
      responsive: true,
      showTooltips: false,
      onAnimationProgress: drawSegmentValues
    });
    var canvas = document.getElementById("pieChart");
    var midX = canvas.width/2;
    var midY = canvas.height/2
    var radius = myPie.outerRadius;
    var totalValue = getTotalValue(pieData);
    function drawSegmentValues()
    {
        for(var i=0; i<myPie.segments.length; i++) 
        {
            ctx3.fillStyle="white";
            var textSize = canvas.width/15;
            ctx3.font= textSize+"px Verdana";
            // Get needed variables
            var value = myPie.segments[i].value;
            if(Math.round(value) !== value)
              value = (myPie.segments[i].value).toFixed(1);
            
            
            var startAngle = myPie.segments[i].startAngle;
            var endAngle = myPie.segments[i].endAngle;
            var middleAngle = startAngle + ((endAngle - startAngle)/2);

            // Compute text location
            var posX = (radius/2) * Math.cos(middleAngle) + midX;
            var posY = (radius/2) * Math.sin(middleAngle) + midY;

            // Text offside by middle
            var w_offset = ctx3.measureText(value).width/2;
            var h_offset = textSize/4;

            ctx3.fillText(value, posX - w_offset, posY + h_offset);
        }
    }

    function getTotalValue(arr) {
        var total = 0;
        for(var i=0; i<arr.length; i++)
            total += arr[i].value;
        return total;
    }

  }


}
