// LINE GRAPH
var x = document.getElementsByClassName("invest_data");

  var dat_inv = [];
  for (var i = 0; i < x.length;i++) {
      dat_inv.push(x[i].getAttribute("id"));
  }
  var inv_val = [];
  for (var i = 0; i < x.length;i++) {
      inv_val.push(x[i].innerHTML);
  }
var lineChartData = {
  labels : dat_inv,
  datasets : [
    {
      label: "My First dataset",
      fillColor : "rgba(220,220,220,0.2)",
      strokeColor : "rgba(220,220,220,1)",
      pointColor : "rgba(14, 16, 109,1)",
      pointStrokeColor : "#fff",
      pointHighlightFill : "#fff",
      pointHighlightStroke : "rgba(220,220,220,1)",
      data : inv_val
    }
  ]
}

// LINE GRAPH
var y = document.getElementsByClassName("yield_data");

  var dat_yie = [];
  for (var i = 0; i < y.length;i++) {
      dat_yie.push(y[i].getAttribute("id"));
  }
  var yie_val = [];
  for (var i = 0; i < y.length;i++) {
      yie_val.push(y[i].innerHTML);
  }
var lineChartData2 = {
  labels : dat_yie,
  datasets : [
    {
      label: "My First dataset2",
      fillColor : "rgba(220,220,220,0.2)",
      strokeColor : "rgba(220,220,220,1)",
      pointColor : "rgba(14, 16, 109,1)",
      pointStrokeColor : "#fff",
      pointHighlightFill : "#fff",
      pointHighlightStroke : "rgba(220,220,220,1)",
      data : yie_val
    }
  ]
}

window.onload = function(){
  console.log("dmm");
  var ctx = document.getElementById("insvest").getContext("2d");
  window.myLine = new Chart(ctx).Line(lineChartData, {
    responsive: false
  });
  var ctx2 = document.getElementById("yield").getContext("2d");
  window.myLine = new Chart(ctx2).Line(lineChartData2, {
    responsive: false
  });

  
}
