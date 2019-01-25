// Function based on https://stackoverflow.com/questions/1484506/random-color-generator/1484514#1484514
function getRandomColor() {
    'use strict';
    var letters = '0123456789ABCDEF';
    var color = '#';
    for (var i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

var ctx = document.getElementById('chart').getContext('2d');

$.getJSON('stats.json', function (json) {
    'use strict';
    var datasets = [];
    $.each(json, function (key, value) {
        var data = [];
        var color = getRandomColor();
        $.each(value, function (key, value) {
            data.push({
                x: key,
                y: value
            });
        });
        datasets.push({
            label: key,
            backgroundColor: color,
            borderColor: color,
            data: data,
            fill: false
        });
    });
    var chart = new Chart(ctx, {
        type: 'line',
        data: {
            datasets: datasets
        },
        options: {
            responsive: true,
            scales: {
                xAxes: [{
                    type: 'time',
                    scaleLabel: {
                        display: true,
                        labelString: 'Date'
                    }
                    }],
                yAxes: [{
                    ticks: {
                        min: 0
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Request number'
                    }
                    }]
            }
        }
    });
});
