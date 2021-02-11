var labels = categories.reduce((acc, cur) => {
  acc = acc.concat(cur.Categoria);
  return acc

}, []);

var data = categories.reduce((acc, cur) => {
  acc = acc.concat(cur.Cantidad);
  return acc

}, []);

background = []
var r = 241
for (var i = 0; i < categories.length; i++) {
  background.push("rgb("+r+", 112, 89)")
  r -= 30
}

backgroundH = []
var r = 241
var g = 112
for (var i = 0; i < categories.length; i++) {
  backgroundH.push("rgb("+r+", "+g+", 89)")
  r -= 30
  g += 10
}

console.log(labels)
console.log(data)
console.log(background)
console.log(backgroundH)

var ctx = document.getElementById("Categorias");
var Categorias = new Chart(ctx, {
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
      display: false,
    },
    cutoutPercentage: 80,
  },
});
