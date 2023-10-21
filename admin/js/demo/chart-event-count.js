// Assume that the response data contains objects with "month" and "count" properties
$.ajax({
  url: 'get_event_detail.php',
  type: 'GET',
  dataType: 'json',
  success: function (data) {
    // console.log(data);
    // Process data and generate the chart
    generateChart(data);
  },
  error: function () {
    alert('Error occurred while retrieving data.');
  }
});

function generateChart(data) {
  var labels = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
  var countData = Array(12).fill(0); // Initialize an array for count data

  data.forEach(function (item) {
    // Assuming month values are 1-based (e.g., 1 for January, 2 for February)
    // Subtract 1 to match the 0-based array index
    var index = item.month - 1;
    countData[index] = item.count;
  });

  var ctx = document.getElementById("eventCountChart");
  var myLineChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: labels,
      datasets: [{
        label: "Number of Events",
        lineTension: 0.3,
        backgroundColor: "rgba(78, 115, 223, 0.05)",
        borderColor: "rgba(78, 115, 223, 1)",
        pointRadius: 3,
        pointBackgroundColor: "rgba(78, 115, 223, 1)",
        pointBorderColor: "rgba(78, 115, 223, 1)",
        pointHoverRadius: 3,
        pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
        pointHoverBorderColor: "rgba(78, 115, 223, 1)",
        pointHitRadius: 10,
        pointBorderWidth: 2,
        data: countData,
      }],
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
          gridLines: {
            display: false,
            drawBorder: false
          },
          ticks: {
            maxTicksLimit: 12
          }
        }],
        yAxes: [{
          ticks: {
            maxTicksLimit: 5,
            beginAtZero: true, // Start the y-axis at 0
            precision: 0, // Set the number of decimal places to 0
            stepSize: 1, // Define the step size as 1 to display whole numbers
            padding: 10
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
        display: false
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
        caretPadding: 10
      }
    }
  });
}
