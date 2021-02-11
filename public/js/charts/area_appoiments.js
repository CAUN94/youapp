// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

function number_format(number, decimals, dec_point, thousands_sep) {
  // *     example: number_format(1234.56, 2, ',', ' ');
  // *     return: '1 234,56'
  number = (number + '').replace(',', '').replace(' ', '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}

function area(atenciones,convenio,sinconvenio,embajador,name){
  var ctx = document.getElementById(name);
  var myLineChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
      datasets: [{
        label: "Atenciones",
        lineTension: 0.3,
        backgroundColor: "rgba(2, 117, 216, 0.05)",
        borderColor: "rgba(2, 117, 216, 1)",
        pointRadius: 3,
        pointBackgroundColor: "rgba(2, 117, 216, 1)",
        pointBorderColor: "rgba(2, 117, 216, 1)",
        pointHoverRadius: 3,
        pointHoverBackgroundColor: "rgba(2, 117, 216, 1)",
        pointHoverBorderColor: "rgba(2, 117, 216, 1)",
        pointHitRadius: 10,
        pointBorderWidth: 2,
        data: atenciones,
      },
      {
        label: "Convenio",
        lineTension: 0.3,
        backgroundColor: "rgba(92, 184, 92, 0.05)",
        borderColor: "rgba(92, 184, 92, 1)",
        pointRadius: 3,
        pointBackgroundColor: "rgba(92, 184, 92, 1)",
        pointBorderColor: "rgba(92, 184, 92, 1)",
        pointHoverRadius: 3,
        pointHoverBackgroundColor: "rgba(92, 184, 92, 1)",
        pointHoverBorderColor: "rgba(92, 184, 92, 1)",
        pointHitRadius: 10,
        pointBorderWidth: 2,
        data: convenio,
      },{
        label: "Sin Convenio",
        lineTension: 0.3,
        backgroundColor: "rgba(240, 173, 78, 0.05)",
        borderColor: "rgba(240, 173, 78,1)",
        pointRadius: 3,
        pointBackgroundColor: "rgba(240, 173, 78,1)",
        pointBorderColor: "rgba(240, 173, 78,1)",
        pointHoverRadius: 3,
        pointHoverBackgroundColor: "rgba(240, 173, 78,1)",
        pointHoverBorderColor: "rgba(240, 173, 78,1)",
        pointHitRadius: 10,
        pointBorderWidth: 2,
        data: sinconvenio,
      },{
        label: "Embajador",
        lineTension: 0.3,
        backgroundColor: "rgba(217, 83, 79, 0.05)",
        borderColor: "rgba(217, 83, 79, 1)",
        pointRadius: 3,
        pointBackgroundColor: "rgba(217, 83, 79, 1)",
        pointBorderColor: "rgba(217, 83, 79, 1)",
        pointHoverRadius: 3,
        pointHoverBackgroundColor: "rgba(217, 83, 79, 1)",
        pointHoverBorderColor: "rgba(217, 83, 79, 1)",
        pointHitRadius: 10,
        pointBorderWidth: 2,
        data: embajador,
      }
      ],
    },
    options: {
      maintainAspectRatio: false,
      layout: {
        padding: {
          left: 10,
          right: 25,
          top: 25,
          bottom: 0
        }
      },
      scales: {
        xAxes: [{
          display: true,
          time: {
            unit: 'date'
          },
          gridLines: {
            display: false,
            drawBorder: false
          },
          ticks: {
            maxTicksLimit: 7
          }
        }],
        yAxes: [{
          ticks: {
            maxTicksLimit: 5,
            padding: 10,
            // Include a dollar sign in the ticks

          },
          gridLines: {
            color: "rgb(234, 236, 244)",
            zeroLineColor: "rgb(234, 236, 244)",
            drawBorder: false,
            borderDash: [2],
            zeroLineBorderDash: [2]
          }
        }],
      },
      legend: {
        display: true
      },
      tooltips: {
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        titleMarginBottom: 10,
        titleFontColor: '#6e707e',
        titleFontSize: 14,
        borderColor: '#dddfeb',
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        intersect: false,
        mode: 'index',
        caretPadding: 10,

      }
    }
  });
}

var atenciones = new Array(12).fill(0)
var convenio = new Array(12).fill(0)
var sinconvenio = new Array(12).fill(0)
var embajador = new Array(12).fill(0)

for (var i = 0; i < conveniosActual.length; i++) {
  atenciones[i] = conveniosActual[i].Atenciones
  convenio[i] = conveniosActual[i].Convenio
  sinconvenio[i] = conveniosActual[i].Sin_Convenio
  embajador[i] = conveniosActual[i].Embajador
}

area(atenciones,convenio,sinconvenio,embajador,"conveniosActual")

var atenciones = new Array(12).fill(0)
var convenio = new Array(12).fill(0)
var sinconvenio = new Array(12).fill(0)
var embajador = new Array(12).fill(0)

for (var i = 0; i < conveniosLast.length; i++) {
  atenciones[i] = conveniosLast[i].Atenciones
  convenio[i] = conveniosLast[i].Convenio
  sinconvenio[i] = conveniosLast[i].Sin_Convenio
  embajador[i] = conveniosLast[i].Embajador
}


area(atenciones,convenio,sinconvenio,embajador,"conveniosLast")
