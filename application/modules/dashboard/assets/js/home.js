
"use strict";
var sales_label = $('#sales_label').val();
var purchase_label = $('#purchase_label').val();
var chartjs_labels = $('#chartjs_labels').val();
var chart_data1 = $('#chart_data1').val();
var chart_data2 = $('#chart_data2').val();
//line chart
var ctx = document.getElementById("lineChart");
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [chartjs_labels],
        datasets: [
            {
                label: sales_label,
                borderColor: "#2C3136",
                borderWidth: "1",
                backgroundColor: "rgba(247,218,38,0.51)",
                pointHighlightStroke: "rgba(26,179,148,1)",
                data: [chart_data1]
            },
            {
                label: purchase_label,
                borderColor: "#73BC4D",
                borderWidth: "1",
                backgroundColor: "#73BC4D",
                pointHighlightStroke: "rgba(26,179,148,1)",
                data: [chart_data2]
            }
        ]
    },
    options: {
        responsive: true,
        tooltips: {
            mode: 'index',
            intersect: false
        },
        hover: {
            mode: 'nearest',
            intersect: true
        }

    }
});
