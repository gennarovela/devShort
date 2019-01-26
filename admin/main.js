var currentDate = new Date();
var startDate = new Date(new Date().setFullYear(currentDate.getFullYear() - 1));

$.getJSON('stats.json', function (json) {
    'use strict';
    $.each(json, function (name, data) {
        $('div#charts').append('<div class="card mb-3"><div class="card-body"><div id="heatmap-' + name + '" class="heatmap"></div></div><div class="card-footer text-center text-muted"><a id="export-' + name + '" href="#download" class="card-link">Download chart</a><a id="delete-' + name + '" href="#delete" class="card-link">Delete shortlink and dataset</a></div></div>');
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
        $('a#export-' + name).click(function () {
            heatmap.export();
        });
        $('a#delete-' + name).click(function () {
            $.post('index.php', {
                delete: name
            });
            location.reload();
        });
    });
});
