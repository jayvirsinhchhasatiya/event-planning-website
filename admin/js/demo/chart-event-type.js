// Retrieve data from the server
$.ajax({
    url: 'get_event_type.php',
    type: 'GET',
    dataType: 'json',
    success: function(data) {
        // console.log(data);
        // Process data and generate the chart
        generateChartEventType(data);
    },
    error: function() {
        alert('Error occurred while retrieving data.');
    }
});

function generateChartEventType(data) {
    var ctx = document.getElementById("eventTypeChart");
    var myPieChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ["Competitive", "Non-Competitive"],
            datasets: [{
                data: [data.CompetitiveCount, data.nonCompetitiveCount], // Corrected order
                backgroundColor: ['#4e73df', '#1cc88a'],
                hoverBackgroundColor: ['#2e59d9', '#17a673'],
                hoverBorderColor: "rgba(234, 236, 244, 1)"
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
                caretPadding: 10
            },
            legend: {
                display: true
            },
            cutoutPercentage: 80,
        },
    });
}
