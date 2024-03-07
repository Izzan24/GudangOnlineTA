const loadDataDashboard = () => {
    $.get(`${base_url}/api/dashboard/`).then(res => {
        renderBoxData(res.box);
        renderChartData(res.transaction);
    });
}

const renderBoxData = (data) => {
    data.forEach(box => {
        $(`${box.class} h3`).html(`${box.value}<sup class="prefix" style="font-size: 20px">${box.prefix}</sup>`);
        $(`${box.class} a`).attr('href',`/${box.path}`);
    });
}

const renderChartData = (chartData) => {

  var ticksStyle = {
    fontColor: '#495057',
    fontStyle: 'normal'
  }

  var mode = 'index'
  var intersect = true

  var $visitorsChart = $('#visitors-chart')
  // eslint-disable-next-line no-unused-vars
  var visitorsChart = new Chart($visitorsChart, {
    data: chartData,
    options: {
      maintainAspectRatio: false,
      tooltips: {
        mode: mode,
        intersect: intersect
      },
      hover: {
        mode: mode,
        intersect: intersect
      },
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          // display: false,
          gridLines: {
            display: true,
            lineWidth: '4px',
            color: 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks: $.extend({
            beginAtZero: true,
            suggestedMax: 200
          }, ticksStyle)
        }],
        xAxes: [{
          display: true,
          gridLines: {
            display: false
          },
          ticks: ticksStyle
        }]
      }
    }
  })
}
