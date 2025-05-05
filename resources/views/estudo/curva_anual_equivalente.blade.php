@extends('layouts.default')

@section('content-auth')
    <style>
        @media (max-width: 600px) {
            .chart-area{
                width: 800px!important
            }
        }
    </style>
    <div class="container-fluid">
        @include('layouts.time_line_estudos')

        <div class="card shadow mt-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <label>
                            <b>Ativo Físico:</b> {{ $estudo->ativo_fisico->nome_ativo }}  {{ $estudo->ativo_fisico->cod_ativo_fisico }}
                        </label>
                    </div>
                    @if (Auth::user()->nivel_acesso->nome == 'Master')
                        <div class="col-md-6">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#modalCustoAnual">Ver Custos Anuais</button>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#modalValorPresente">Ver Valor Presente</button>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#modalCustoAnualEquivalente">Ver Custo Anual Equivalente</button>
                        </div>
                    @endif
                    <div class="col-md-12" style="margin-bottom: 15px">
                        <hr>
                    </div>
                    <div class="col-md-12" style="text-align: center">
                        @php
                            $menorValorCae = json_decode($estudo->custo_anual_equivalente->menor_valor_cae);
                            $primeiraChave = array_key_first((array)$menorValorCae); // Pega a primeira chave
                            $primeiroItem = $menorValorCae->$primeiraChave;
                        @endphp
                        <h3> 
                            Custo Anual Equivalente (CAE)
                        </h3>
                        <h5>
                            Ano de Geração do Maior Valor: <b><?=  $primeiraChave ?> </b>
                        </h5>
                    </div>
                    <div class="col-12" style="overflow: auto">
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
                        <a  class="btn btn-dark" href="{{ route('opex.edit', $estudo->opex_id) }}">Voltar</a>
                        <a href="{{ route('estudo.gerar_relatorio', $estudo->id) }}" onclick="refreshPageAfterDelay()" target="_blank"  type="button" class="btn btn-primary">Gerar Relátorio</a>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modalCustoAnual" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Valor Presente</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="row">
                        <div class="col-md-12" style="height: 500px;overflow:auto">
                            <table class="table table-default table-hover table-responsive" style="font-size: 11px">
                                <thead>
                                    <tr>
                                        <th rowspan="2">Ano</th>
                                        <th colspan="8">Capex</th>
                                        <th colspan="4">Opex</th>
                                        <th rowspan="2">Capex + Opex</th>
                                    </tr>
                                    <tr>
                                        <th>Compra</th>
                                        <th>Montagem</th>
                                        <th>Benefício Fiscal da Depreciação</th>
                                        <th>Melhoria</th>
                                        <th>Valor de Revenda</th>
                                        <th>Custo da Perda de Valor</th>
                                        <th>Custo de Oportunidade</th>
                                        <th>Total do Ano (Custo de Capital)</th>
                                        <th>Operação</th>
                                        <th>Manutenção Planejada</th>
                                        <th>Manutenção não Planejada</th>
                                        <th>Total do Ano (Custo Operacional)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (json_decode($estudo->custo_anual->calculos) as $ano => $calculos) 
                                    <tr>
                                        <td>{{ $ano }}</td>
                                        <td>
                                            @if($ano == $estudo->ativo_fisico->ano_aquisicao)
                                                {{ "R$ " . number_format($estudo->ativo_fisico->valor_ativo, 2,",",".") }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($ano == $estudo->ativo_fisico->ano_aquisicao)
                                                {{ "R$ " . number_format($estudo->ativo_fisico->custo_comissionamento + $estudo->ativo_fisico->custo_instalacao, 2,",",".") }}
                                            @endif
                                        </td>
                                        <td>{{ "R$ " . number_format($calculos->capex->beneficio_fiscal_despreciacao, 2,",",".") }}</td>
                                        <td>{{ "R$ " . number_format($calculos->capex->melhoria, 2,",",".") }}</td>
                                        <td>{{ "R$ " . number_format($calculos->capex->valor_revenda, 2,",",".") }}</td>
                                        <td>{{ "R$ " . number_format($calculos->capex->custo_perda_valor, 2,",",".") }}</td>
                                        <td>{{ "R$ " . number_format($calculos->capex->custo_oportunidade, 2,",",".") }}</td>
                                        <td>{{ "R$ " . number_format($calculos->capex->total_ano_custo_capital, 2,",",".") }}</td>
                                        <td>{{ "R$ " . number_format($calculos->opex->operacao, 2,",",".") }}</td>
                                        <td>{{ "R$ " . number_format($calculos->opex->manutencao_planejada, 2,",",".") }}</td>
                                        <td>{{ "R$ " . number_format($calculos->opex->manutencao_n_planejada, 2,",",".") }}</td>
                                        <td>{{ "R$ " . number_format($calculos->opex->total_ano_custo_operacional, 2,",",".") }}</td>
                                        <td>{{ "R$ " . number_format($calculos->total_capex_opex, 2,",",".") }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                      </div>
                    </div>
                 </div>
                </div>
            </div>

            <div class="modal fade" id="modalCustoAnualEquivalente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Valor Presente</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-10" style="height: 500px;overflow:auto">
                            <table class="table table-default table-hover table-responsive">
                                <thead>
                                    <tr>
                                        <th rowspan="2">Ano</th>
                                        <th colspan="2">Capex</th>
                                        <th colspan="2">Opex</th>
                                        <th colspan="1">Capex + Opex</th>
                                        <th rowspan="2">C.A.E</th>
                                    </tr>
                                    <tr>
                                        <th>VPL</th>
                                        <th>V.A.E(Capex)</th>
                                        <th>VPL</th>
                                        <th>V.A.E(Capex)</th>
                                        <th>VPL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (json_decode($estudo->custo_anual_equivalente->calculos) as $ano => $calculos)      
                                        <tr>
                                            <td>{{ $ano }}</td>
                                            <td>{{ "R$ " . number_format($calculos->capex->vpl, 2,",",".") }}</td>
                                            <td>{{ "R$ " . number_format($calculos->capex->valor_anual_equivalente_capex, 2,",",".") }}</td>
                                            <td>{{ "R$ " . number_format($calculos->opex->vpl, 2,",",".") }}</td>
                                            <td>{{ "R$ " . number_format($calculos->opex->valor_anual_equivalente_opex, 2,",",".") }}</td>
                                            <td>{{ "R$ " . number_format($calculos->vpl_capex_opex, 2,",",".") }}</td>
                                            <td>{{ "R$ " . number_format($calculos->custo_anual_equivalente, 2,",",".") }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>

            <div class="modal fade" id="modalValorPresente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Valor Presente</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-11" style="height: 500px;overflow:auto">
                            <table class="table table-default table-hover table-responsive">
                                <thead>
                                    <tr>
                                        <th rowspan="2">Ano</th>
                                        <th colspan="3">Capex</th>
                                        <th colspan="3">Opex</th>
                                        <th colspan="1">Capex + Opex</th>
                                    </tr>
                                    <tr>
                                        <th>Total do Ano</th>
                                        <th>Acumulado</th>
                                        <th>VPL</th>
                                        <th>Total do Ano</th>
                                        <th>Acumulado</th>
                                        <th>VPL</th>
                                        <th>Total do Ano</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (json_decode($estudo->valor_presente->calculos) as $ano => $calculos)
                                        <tr>
                                            <td>{{ $ano }}</td>
                                            <td>{{ "R$ " . number_format($calculos->capex->total_ano_custo_capital, 2,",",".") }}</td>
                                            <td>{{ "R$ " . number_format($calculos->capex->acumulado, 2,",",".") }}</td>
                                            <td>{{ "R$ " . number_format($calculos->capex->valor_presente_capex, 2,",",".") }}</td>
                                            <td>{{ "R$ " . number_format($calculos->opex->total_ano_custo_operacao, 2,",",".") }}</td>
                                            <td>{{ "R$ " . number_format($calculos->opex->acumulado, 2,",",".") }}</td>
                                            <td>{{ "R$ " . number_format($calculos->opex->valor_presente_opex, 2,",",".") }}</td>
                                            <td>{{ "R$ " . number_format($calculos->total_capex_opex, 2,",",".") }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("js")
    <script>
        let calculos = <?php echo $estudo->custo_anual_equivalente->calculos ?>;
        let ano_aquisicao_valida = <?php echo $estudo->ativo_fisico->ano_aquisicao ?>;

        function formataAnos()
        {
            let arrayAnos = [];

            for (let chave in calculos) {
                if(chave > (ano_aquisicao_valida)){
                    arrayAnos.push(chave); 

                }
            }

            return arrayAnos;
        }

        function formataValoresCapex()
        {
            let arrayCapex = []; 

            for (let chave in calculos) {
                if(chave > (ano_aquisicao_valida)){
                    arrayCapex.push(calculos[chave]['capex']['valor_anual_equivalente_capex']); 

                }
            }

            return arrayCapex
        }

        function formataValoresOpex()
        {            
            let arrayOpex = []; 

            for (let chave in calculos) {
                if(chave > (ano_aquisicao_valida)){
                    arrayOpex.push(calculos[chave]['opex']['valor_anual_equivalente_opex']); 

                }
            }

            return arrayOpex
        }

        function formataCustoAnualEquivalente()
        {
            let arrayCustoAnualEquivalente = []; 

            for (let chave in calculos) {
                if(chave > (ano_aquisicao_valida )){
                    arrayCustoAnualEquivalente.push(calculos[chave]['custo_anual_equivalente']); 

                }
            }

            return arrayCustoAnualEquivalente
        }

        function refreshPageAfterDelay() {
            setTimeout(function() {
                location.reload();
            }, 4000); // 4000ms = 4 seconds
        }

        $(document).ready(function() {
            var ano_aquisicao = <?= $estudo->ativo_fisico->ano_aquisicao ?>;

            arrayAnos = formataAnos();
            arrayCapex = formataValoresCapex();
            arrayOpex = formataValoresOpex();
            arrayCustoAnualEquivalente = formataCustoAnualEquivalente();
            anoOportunidade = "<?=  $primeiraChave ?>";

            console.log(arrayAnos);
            
            var ctx = document.getElementById("grafico_curva_lcc");
            var myLineChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: arrayAnos,
                    datasets: [
                        {
                            label: "C.A.E",
                            lineTension: 0.3,
                            backgroundColor: "rgba(49, 81, 95, 0)",
                            borderColor: "rgba(49, 81, 95, 1)",
                            pointRadius: arrayAnos.map(year => year === anoOportunidade ? 7 : 3),
                            pointBackgroundColor: arrayAnos.map(year => year === anoOportunidade ? "rgb(242 142 42)" : "rgba(49, 81, 95, 1)"),
                            pointBorderColor: arrayAnos.map(year => year === anoOportunidade ? "rgb(242 142 42)" : "rgba(49, 81, 95, 1)"),
                            pointHoverRadius: 3,
                            pointHoverBackgroundColor: arrayAnos.map(year => year === anoOportunidade ? "rgb(242 142 42)" : "rgba(49, 81, 95, 1)"),
                            pointHoverBorderColor: arrayAnos.map(year => year === anoOportunidade ? "rgb(242 142 42)" : "rgba(49, 81, 95, 1)"),
                            pointHitRadius: 10,
                            pointBorderWidth: 2,
                            data: arrayCustoAnualEquivalente
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
                                maxTicksLimit: 100,
                                callback: function(value, index, values) {
                                    return value;
                                }
                            },
                        }],
                        yAxes: [{
                            ticks: {
                                maxTicksLimit: 10,
                                padding: 10,
                                callback: function(value, index, values) {
                                    return 'R$ ' + number_format(value);
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
                        display: true,
                        labels: {
                            // Customizar a legenda
                            generateLabels: function(chart) {
                                var original = Chart.defaults.global.legend.labels.generateLabels(chart);

                                var opportunityLabel = {
                                    text: 'Ano de Geração do Maior Valor',
                                    fillStyle: 'white',
                                    strokeStyle: 'rgb(242 142 42)',
                                    lineWidth: 2,
                                    hidden: false,
                                    index: original.length
                                };
                                return original.concat(opportunityLabel);
                            }
                        }
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
@endsection