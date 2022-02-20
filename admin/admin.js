function showNewsblogDashboard() {
  var content = document.getElementById("mainContent");
  var headline = document.getElementById("headlineDashboardContent");
  headline.innerHTML = "Newsblog";

  /* TODO:
  ** Content austauschen. Der innere Teil soll erstezt werden durch eine Ansicht aller bisherigen Artikel (Ordnerinhalt auflisten)
  ** Diese Artikel sollen bearbeitet werden können.
  ** Buttons erstellen für: Neuen Artikel schreiben, Bearbeiten, Löschen usw.
  ** Gerne weitere Ideen sammeln und erstmal hier aufschreiben!
  */
}


/* globals Chart:false, feather:false */

(function () {
  'use strict'

  feather.replace({ 'aria-hidden': 'true' })

  // Graphs
  var ctx = document.getElementById('myChart')
  // eslint-disable-next-line no-unused-vars
  var myChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: [
        'Sunday',
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday'
      ],
      datasets: [{
        data: [
          15339,
          21345,
          18483,
          24003,
          23489,
          24092,
          12034
        ],
        lineTension: 0,
        backgroundColor: 'transparent',
        borderColor: '#007bff',
        borderWidth: 4,
        pointBackgroundColor: '#007bff'
      }]
    },
    options: {
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: false
          }
        }]
      },
      legend: {
        display: false
      }
    }
  })
})()
