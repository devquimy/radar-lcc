<?php
$titulo_pagina = "Ativos Físicos";
$timeline = 4;
require("settings.php");
include("head.php");
include("menu.php");
include("topo.php");
    ?>
    <div class="container-fluid">
        <?php
        include("timeline.php");
        ?>
        <form class="g-3" action="estudos_lista" method="post">
            <div class="card mt-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="chart-area">
                                <div class="chartjs-size-monitor">
                                    <div class="chartjs-size-monitor-expand">
                                        <div class=""></div>
                                    </div>
                                    <div class="chartjs-size-monitor-shrink">
                                        <div class=""></div>
                                    </div>
                                </div>
                                <canvas id="grafico_curva_lcc" width="950" height="675" style="display: block; height: 600px; width: 760px;" class="chartjs-render-monitor"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 pt-4">
                        <button type="button" class="btn btn-dark" onclick="window.location.href='opex_form'">Voltar</button>
                            <button type="submit" class="btn btn-primary">Concluir</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?php
include("footer.php");
?>

<script>
    $(document).ready(function() {
        var ctx = document.getElementById("grafico_curva_lcc");
        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [
                    "2008", 
                    "2009", 
                    "2010", 
                    "2011", 
                    "2012", 
                    "2013", 
                    "2014", 
                    "2015", 
                    "2016", 
                    "2017", 
                    "2018", 
                    "2019", 
                    "2020", 
                    "2021", 
                    "2022", 
                    "2023", 
                    "2024", 
                    "2025", 
                    "2026", 
                    "2027", 
                    "2028", 
                    "2029", 
                    "2030", 
                    "2031", 
                    "2032", 
                    "2033", 
                    "2034", 
                    "2035", 
                    "2036", 
                    "2037", 
                    "2038", 
                    "2039", 
                    "2040"
                ],
                datasets: [
                    {
                        label: "CAPEX",
                        lineTension: 0.3,
                        /*backgroundColor: "rgba(239, 125, 0, 0.20)",*/
                        backgroundColor: "rgba(239, 125, 0, 0)",
                        borderColor: "rgba(239, 125, 0, 1)",
                        pointRadius: 3,
                        pointBackgroundColor: "rgba(239, 125, 0, 1)",
                        pointBorderColor: "rgba(239, 125, 0, 1)",
                        pointHoverRadius: 3,
                        pointHoverBackgroundColor: "rgba(239, 125, 0, 1)",
                        pointHoverBorderColor: "rgba(239, 125, 0, 1)",
                        pointHitRadius: 10,
                        pointBorderWidth: 2,
                        data: [
                            2500000,
                            2000000,
                            1600000,
                            1200000,
                            1000000,
                            850000,
                            750000,
                            650000,
                            600000,
                            550000,
                            500000,
                            450000,
                            420000,
                            400000,
                            380000,
                            360000,
                            340000,
                            330000,
                            320000,
                            310000,
                            300000,
                            295000,
                            290000,
                            285000,
                            280000,
                            275000,
                            270000,
                            265000,
                            260000,
                            255000,
                            250000,
                            245000,
                            240000,
                        ],
                    },
                    {
                        label: "OPEX",
                        lineTension: 0.3,
                        /*backgroundColor: "rgba(118, 184, 42, 0.20)",*/
                        backgroundColor: "rgba(118, 184, 42, 0)",
                        borderColor: "rgba(118, 184, 42, 1)",
                        pointRadius: 3,
                        pointBackgroundColor: "rgba(118, 184, 42, 1)",
                        pointBorderColor: "rgba(118, 184, 42, 1)",
                        pointHoverRadius: 3,
                        pointHoverBackgroundColor: "rgba(118, 184, 42, 1)",
                        pointHoverBorderColor: "rgba(118, 184, 42, 1)",
                        pointHitRadius: 10,
                        pointBorderWidth: 2,
                        data: [
                            170000,
                            175000,
                            180000,
                            185000,
                            190000,
                            195000,
                            200000,
                            210000,
                            220000,
                            230000,
                            240000,
                            260000,
                            280000,
                            300000,
                            330000,
                            360000,
                            390000,
                            420000,
                            450000,
                            500000,
                            550000,
                            600000,
                            700000,
                            800000,
                            900000,
                            1000000,
                            1100000,
                            1200000,
                            1300000,
                            1400000,
                            1500000,
                            1600000,
                            1700000,
                        ],
                    },
                    {
                        label: "C.A.E",
                        lineTension: 0.3,
                        /*backgroundColor: "rgba(49, 81, 95, 0.20)",*/
                        backgroundColor: "rgba(49, 81, 95, 0)",
                        borderColor: "rgba(49, 81, 95, 1)",
                        pointRadius: 3,
                        pointBackgroundColor: "rgba(49, 81, 95, 1)",
                        pointBorderColor: "rgba(49, 81, 95, 1)",
                        pointHoverRadius: 3,
                        pointHoverBackgroundColor: "rgba(49, 81, 95, 1)",
                        pointHoverBorderColor: "rgba(49, 81, 95, 1)",
                        pointHitRadius: 10,
                        pointBorderWidth: 2,
                        data: [
                            2000000,
                            1800000,
                            1600000,
                            1450000,
                            1300000,
                            1200000,
                            1100000,
                            1000000,
                            900000,
                            880000,
                            830000,
                            750000,
                            700000,
                            680000,
                            690000,
                            700000,
                            710000,
                            730000,
                            750000,
                            770000,
                            790000,
                            810000,
                            830000,
                            870000,
                            900000,
                            940000,
                            980000,
                            1100000,
                            1200000,
                            1300000,
                            1400000,
                            1500000,
                            1600000,
                        ],
                    },
                ],
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
                        time: {
                            unit: 'date'
                        },
                        gridLines: {
                            display: true,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 100      //LIMITE DE ITENS NA PARTE INFERIOR DO GRÁFICO 
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            maxTicksLimit: 10,
                            padding: 10,
                            // Include a dollar sign in the ticks
                            callback: function(value, index, values) {
                                return '$' + number_format(value);
                            }
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
                    display: true
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
                    caretPadding: 10,
                    callbacks: {
                        label: function(tooltipItem, chart) {
                            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                            return datasetLabel + ': R$ ' + number_format(tooltipItem.yLabel, 2, ",", ".");
                        }
                    }
                }
            }
        });

        //AUMENTANDO A ALTURA DO GRÁFICO
        $("#grafico_vendas").css("height", "300px");
    });
</script>