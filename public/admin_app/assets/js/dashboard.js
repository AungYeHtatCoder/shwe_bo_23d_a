var ctx1 = document.getElementById("chart-line").getContext("2d");
var ctx2 = document.getElementById("chart-pie").getContext("2d");
//var ctx3 = document.getElementById("chart-bar").getContext("2d");

// Fetch monthly totals
async function fetchMonthlyTotals() {
  const response = await fetch("/admin/month-with-name-income-json");
  const data = await response.json();
  return data.monthlyTotals;
}

// Render monthly chart
async function renderMonthlyChart() {
  const monthlyTotalsData = await fetchMonthlyTotals();

  const monthNames = [
    "Jan",
    "Feb",
    "Mar",
    "Apr",
    "May",
    "Jun",
    "Jul",
    "Aug",
    "Sep",
    "Oct",
    "Nov",
    "Dec",
  ];
  let labels = monthNames;
  let amounts = [];

  // Fill data for all months of the year
  for (let month of monthNames) {
    amounts.push(monthlyTotalsData[month] || 0);
  }

  var ctx1 = document.getElementById("chart-line").getContext("2d");

  new Chart(ctx1, {
    type: "line",
    data: {
      labels: labels,
      datasets: [
        {
          label: "Monthly Totals",
          tension: 0,
          pointRadius: 5,
          pointBackgroundColor: "#e91e63",
          pointBorderColor: "transparent",
          borderColor: "#e91e63",
          borderWidth: 4,
          backgroundColor: "transparent",
          fill: true,
          data: amounts,
          maxBarThickness: 6,
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false,
        },
      },
      interaction: {
        intersect: false,
        mode: "index",
      },
      scales: {
        y: {
          grid: {
            drawBorder: false,
            display: true,
            drawOnChartArea: true,
            drawTicks: false,
            borderDash: [5, 5],
            color: "#c1c4ce5c",
          },
          ticks: {
            display: true,
            padding: 10,
            color: "#9ca2b7",
            font: {
              size: 14,
              weight: 300,
              family: "Roboto",
              style: "normal",
              lineHeight: 2,
            },
          },
        },
        x: {
          grid: {
            drawBorder: false,
            display: true,
            drawOnChartArea: true,
            drawTicks: true,
            borderDash: [5, 5],
            color: "#c1c4ce5c",
          },
          ticks: {
            display: true,
            color: "#9ca2b7",
            padding: 10,
            font: {
              size: 14,
              weight: 300,
              family: "Roboto",
              style: "normal",
              lineHeight: 2,
            },
          },
        },
      },
    },
  });
}

// Call the render function when the page loads
renderMonthlyChart();

// Pie chart
$(document).ready(function () {
  // Make an AJAX call to get the data
  $.get("/admin/daily-income-json", function (response) {
    // The JSON data: response
    var dailyTotal = response.dailyTotal;
    var weeklyTotal = response.weeklyTotal;
    var monthlyTotal = response.monthlyTotal;
    var yearlyTotal = response.yearlyTotal;

    // Initiate the pie chart with fetched data
    var ctx2 = document.getElementById("chart-pie").getContext("2d");

    new Chart(ctx2, {
      type: "pie",
      data: {
        labels: ["DailyIncome", "WeeklyIncome", "MonthlyIncome", "YearlyIncome"],
        datasets: [
          {
            label: "Income",
            backgroundColor: ["#17c1e8", "#e91e63", "#3A416F", "#a8b8d8"],
            data: [dailyTotal, weeklyTotal, monthlyTotal, yearlyTotal],
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          },
        },
        interaction: {
          intersect: false,
          mode: "index",
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              color: "#c1c4ce5c",
            },
            ticks: {
              display: false,
            },
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              color: "#c1c4ce5c",
            },
            ticks: {
              display: false,
            },
          },
        },
      },
    });
  });
});

async function fetchDailyTotals() {
  const response = await fetch("/admin/daily-with-name-income-json");
  const data = await response.json();
  return data.dailyTotals;
}

async function renderChart() {
  const dailyTotalsData = await fetchDailyTotals();

  // Map numbers to day names
  const dayNames = ["S", "M", "T", "W", "T", "F", "S"];
  let labels = [];
  let amounts = [];

  // Fill data for entire week ensuring order from Sunday to Saturday
  for (let i = 1; i <= 7; i++) {
    labels.push(dayNames[i - 1]);
    amounts.push(dailyTotalsData[i] || 0); // If there's no data for a day, default to 0
  }

  var ctx = document.getElementById("chart-bars").getContext("2d");

  new Chart(ctx, {
    type: "bar",
    data: {
      labels: labels,
      datasets: [
        {
          label: "Sales",
          tension: 0.4,
          borderWidth: 0,
          borderRadius: 4,
          borderSkipped: false,
          backgroundColor: "rgba(255, 255, 255, .8)",
          data: amounts,
          maxBarThickness: 6,
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false,
        },
      },
      interaction: {
        intersect: false,
        mode: "index",
      },
      scales: {
        y: {
          grid: {
            drawBorder: false,
            display: true,
            drawOnChartArea: true,
            drawTicks: false,
            borderDash: [5, 5],
            color: "rgba(255, 255, 255, .2)",
          },
          ticks: {
            suggestedMin: 0,
            suggestedMax: 500,
            beginAtZero: true,
            padding: 10,
            font: {
              size: 14,
              weight: 300,
              family: "Roboto",
              style: "normal",
              lineHeight: 2,
            },
            color: "#fff",
          },
        },
        x: {
          grid: {
            drawBorder: false,
            display: true,
            drawOnChartArea: true,
            drawTicks: false,
            borderDash: [5, 5],
            color: "rgba(255, 255, 255, .2)",
          },
          ticks: {
            display: true,
            color: "#f8f9fa",
            padding: 10,
            font: {
              size: 14,
              weight: 300,
              family: "Roboto",
              style: "normal",
              lineHeight: 2,
            },
          },
        },
      },
    },
  });
}

// Call the render function when the page loads
renderChart();
