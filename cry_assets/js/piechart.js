// PIE CHART


var pieData = [
  {
    value: 300,
    color: getRandomColor(),
    highlight: "#F7464A",
    label: "Sent"
  },
  {
    value: 50,
    color: getRandomColor(),
    highlight: "#F7464A",
    label: "Engaged"
  },
  {
    value: 100,
    color: getRandomColor(),
    highlight: "#F7464A",
    label: "Viewed"
  },
  {
    value: 40,
    color: getRandomColor(),
    highlight: "#F7464A",
    label: "Bounced"
  },
  {
    value: 120,
    color: getRandomColor(),
    highlight: "#F7464A",
    label: "Accepted"
  }

];
for (var i = 0; i < pieData.length ; i++) {
    var text = "#pie_chart .legend ul li:nth-child("+(i+1)+")";
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
jQuery(window).load(function(){
 
  var ctx3 = jQuery("#pieChart").getContext("2d");
  window.myPie = new Chart(ctx3).Pie(pieData, {
    animation: true,
    responsive: true
  });
})