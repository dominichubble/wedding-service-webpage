document.addEventListener("DOMContentLoaded", function () {
  var comparisonChartElement = document.getElementById("comparisonChart");
  if (comparisonChartElement) {
    var ctx = comparisonChartElement.getContext("2d");
    var comparisonChart = new Chart(ctx, {
      type: "bar",
      data: {
        labels: ["Weekday Price", "Weekend Price"],
        datasets: [
          {
            label: venue1Data["name"],
            data: [venue1Data["weekday_price"], venue1Data["weekend_price"]],
            backgroundColor: "rgba(75, 192, 192, 0.2)",
            borderColor: "#fff",
            borderWidth: 1,
          },
          {
            label: venue2Data["name"],
            data: [venue2Data["weekday_price"], venue2Data["weekend_price"]],
            backgroundColor: "rgba(54, 162, 235, 0.2)",
            borderColor: "rgba(54, 162, 235, 1)",
            borderWidth: 1,
          },
        ],
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true,

            ticks: {
              callback: function (value, index, values) {
                return "£" + value;
              },
            },
          },
        },
        tooltips: {
          callbacks: {
            label: function (tooltipItem, data) {
              return "£" + tooltipItem.yLabel;
            },
          },
        },
      },
    });
  } else {
  }
});
