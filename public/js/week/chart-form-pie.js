// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

function piechart(pay_methods, name) {

  var labels = pay_methods.reduce((acc, cur) => {
    acc = acc.concat(cur.Medio);
    return acc

  }, []);

  var data = pay_methods.reduce((acc, cur) => {
    acc = acc.concat(cur.count);
    return acc

  }, []);

  background = []
  var r = 241
  for (var i = 0; i < pay_methods.length; i++) {
    background.push("rgb("+r+", 112, 89)")
    r -= 30
  }

  backgroundH = []
  var r = 241
  var g = 112
  for (var i = 0; i < pay_methods.length; i++) {
    backgroundH.push("rgb("+r+", "+g+", 89)")
    r -= 30
    g += 10
  }

  // Pie Chart Example
  var ctx = document.getElementById(name);
  var myPieChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: labels,
      datasets: [{
        data: data,
        backgroundColor: background ,
        hoverBackgroundColor: backgroundH,
        hoverBorderColor: "rgba(234, 236, 244, 1)",
      }],
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        borderColor: '#dddfeb',
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        caretPadding: 10,
      },
      legend: {
        display: false
      },
      cutoutPercentage: 80,
    },
  });
}

piechart(pay_methods_week,'myPieChart')
