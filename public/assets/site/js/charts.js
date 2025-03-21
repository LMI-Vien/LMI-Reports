/* global Chart:false */

function getRandomDate() {
  const current = new Date().getTime();
  const start = Math.floor(Math.random() * current);
  const end = Math.floor(Math.random() * (current + 1));

  const randomTimestamp = Math.floor(Math.random() * (end - start + 1)) + start;

  return new Date(randomTimestamp);
}

function formatReadableDate(dateStr, datetime) {
  const date = new Date(dateStr);
  if (datetime) {
    return date.toLocaleDateString("en-US", { 
      year: "numeric", 
      month: "short", 
      day: "numeric",
      hour: "2-digit",
      minute: "2-digit",
      second: "2-digit",
      hour12: true
    });
  } else {
    return date.toLocaleDateString("en-US", { 
      year: "numeric", 
      month: "short", 
      day: "numeric",
    });
  }
}

function get_random() {
  var random =  Math.floor(Math.random() * 1000);
  return random
}

const randomDate = getRandomDate();
let visitor_label = [formatReadableDate(randomDate, false)]; 
for (let index = 0; index < 6; index++) {
  randomDate.setDate(randomDate.getDate() + 1);
  const formattedDate = formatReadableDate(randomDate, false);
  
  visitor_label.push(formattedDate);
}

let this_week_visitor_data = [];
let last_week_visitor_data = [];
for (let index = 0; index < 7; index++) {
  const randomData = get_random();
  this_week_visitor_data.push(randomData);
}
for (let index = 0; index < 7; index++) {
  const randomData = get_random();
  last_week_visitor_data.push(randomData);
}

$(function () {
    'use strict'
  
    var ticksStyle = {
      fontColor: '#495057',
      fontStyle: 'bold'
    }
  
    var mode = 'index'
    var intersect = true
  
    var $salesChart = $('#sales-chart')
    // eslint-disable-next-line no-unused-vars
    var salesChart = new Chart($salesChart, {
      type: 'bar',
      data: {
        labels: visitor_label,
        datasets: [
          {
            backgroundColor: '#007bff',
            borderColor: '#007bff',
            data: this_week_visitor_data
          },
          {
            backgroundColor: '#ced4da',
            borderColor: '#ced4da',
            data: last_week_visitor_data
          }
        ]
      },
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
  
              // Include a dollar sign in the ticks
              callback: function (value) {
                if (value >= 1000) {
                  value /= 1000
                  value += 'k'
                }
  
                return '$' + value
              }
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
  
    var $visitorsChart = $('#visitors-chart')
    // eslint-disable-next-line no-unused-vars
    var visitorsChart = new Chart($visitorsChart, {
      data: {
        labels: visitor_label,
        datasets: [{
          type: 'line',
          data: this_week_visitor_data,
          backgroundColor: 'transparent',
          borderColor: '#007bff',
          pointBorderColor: '#007bff',
          pointBackgroundColor: '#007bff',
          fill: false
          // pointHoverBackgroundColor: '#007bff',
          // pointHoverBorderColor    : '#007bff'
        },
        {
          type: 'line',
          data: last_week_visitor_data,
          backgroundColor: 'tansparent',
          borderColor: '#ced4da',
          pointBorderColor: '#ced4da',
          pointBackgroundColor: '#ced4da',
          fill: false
          // pointHoverBackgroundColor: '#ced4da',
          // pointHoverBorderColor    : '#ced4da'
        }]
      },
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
  })
  
  // lgtm [js/unused-local-variable]