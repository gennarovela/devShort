var currentDate = new Date();
var startDate = new Date(new Date().setFullYear(currentDate.getFullYear() - 1));

$('button#add-shortlink').click(function (event) {
    event.preventDefault();
    $('div#spinner').show();
    $.post('index.php?add', {
        name: $('input#name').val(),
        link: $('input#link').val()
    }, function () {
        $('input#name').val('');
        $('input#link').val('');
        getCharts();
    });
});
$('a#refresh').click(function (event) {
    event.preventDefault();
    getCharts();
});

function getCharts() {
    'use strict';
    $('div#spinner').show();
    $('div#charts').empty();
    $.getJSON('stats.json', function (json) {
        $.each(json, function (name, data) {
            $('div#charts').append('<div id="card-' + name + '" class="card mb-3"><div class="card-body"><div id="heatmap-' + name + '" class="heatmap"></div></div><div class="card-footer text-center text-muted"><a id="export-' + name + '" href="#download" class="card-link">Download chart</a><a id="delete-' + name + '" href="#delete" class="card-link">Delete shortlink and dataset</a></div></div>');
            let heatmap = new frappe.Chart('div#heatmap-' + name, {
                type: 'heatmap',
                title: 'Access statistics for ' + name,
                data: {
                    dataPoints: data,
                    start: startDate,
                    end: currentDate
                },
                countLabel: 'Access(es)'
            });
            $('a#export-' + name).click(function (event) {
                event.preventDefault();
                heatmap.export();
            });
            $('a#delete-' + name).click(function (event) {
                event.preventDefault();
                $.post('index.php?delete', {
                    name: name
                });
                $('div#card-' + name).remove();
            });
        });
        $('div#spinner').hide();
    });
}

getCharts();
