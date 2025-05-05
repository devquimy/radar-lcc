@extends('layouts.default')

@section('content-auth')
<style>
    /* Estilos do botão flutuante */
    .chat-button {
        position: fixed;
        bottom: 20px; /* Distância do botão do fundo da página */
        right: 20px;  /* Distância do botão da direita da página */
        z-index: 100; /* Garante que o botão fique sempre no topo */
    }

    .chat-link {
        display: inline-block;
        background-color: #003262ba; /* Cor de fundo do botão */
        border-radius: 50%; /* Faz o botão ser circular */
        width: 60px;
        height: 60px;
        text-align: center;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transition: background-color 0.3s ease;
        cursor: pointer;
    }

    .chat-link i {
        width: 30px;
        height: 30px;
        margin-top: 20px; /* Centraliza o ícone verticalmente */
        color: white;
        font-size: 20px;
    }

    .chat-link:hover {
        background-color: #003262/* Cor de fundo ao passar o mouse */
    }
    .flash-info{
        padding: 20px!important
    }
</style>
<div class="container-fluid">
    @include('layouts.time_line_estudos')

    <form class="g-3" action="{{ route('opex.store') }}" id="formOpex" method="post">
        @csrf

        @php
            $dados_preenchidos_cliente = json_decode($opex->dados_preenchidos_cliente);

            if($dados_preenchidos_cliente) :
                foreach ($dados_preenchidos_cliente as $key => $dados_preenchido) : 
        @endphp
                    <?= (isset($dados_preenchido->operadores)) ? "<input type='hidden' name='dados[$key][operadores]' class='dadosoperadores$key' value='$dados_preenchido->operadores'>" : ''; ?>
                    <?= (isset($dados_preenchido->energia)) ? "<input type='hidden' name='dados[$key][energia]' class='dadosenergia$key' value='$dados_preenchido->energia'>" : ''; ?>
                    <?= (isset($dados_preenchido->mantenedores_manutencao_planejada)) ? "<input type='hidden' name='dados[$key][mantenedores_manutencao_planejada]' class='dadosmantenedores_manutencao_planejada$key' value='$dados_preenchido->mantenedores_manutencao_planejada'>" : ''; ?>
                    <?= (isset($dados_preenchido->materiais_servicos_manutencao_planejada)) ? "<input type='hidden' name='dados[$key][materiais_servicos_manutencao_planejada]' class='dadosmateriais_servicos_manutencao_planejada$key' value='$dados_preenchido->materiais_servicos_manutencao_planejada'>" : ''; ?>
                    <?= (isset($dados_preenchido->mantenedores_manutencao_n_planejada)) ? "<input type='hidden' name='dados[$key][mantenedores_manutencao_n_planejada]' class='dadosmantenedores_manutencao_n_planejada$key' value='$dados_preenchido->mantenedores_manutencao_n_planejada'>" : ''; ?>
                    <?= (isset($dados_preenchido->materiais_servicos_manutencao_n_planejada)) ? "<input type='hidden' name='dados[$key][materiais_servicos_manutencao_n_planejada]' class='dadosmateriais_servicos_manutencao_n_planejada$key' value='$dados_preenchido->materiais_servicos_manutencao_n_planejada'>" : ''; ?>
                @endforeach
            @endif
                
        <input type="hidden" name="opex_id" value="{{ $opex->id }}">
        <input type="hidden" name="ano_aquisicao" id="ano_aquisicao" value="{{ $ativo_fisico->ano_aquisicao }}">

        <div class="card mt-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="row mb-3">
                            <div class="col-12 text-right">
                                <a href="#" class="btn btn-sm btn-primary shadow-sm d-none">
                                    <i class="fas fa-plus fa-sm text-white-50"></i> Adicionar
                                </a>
                            </div>
                            <div class="col-md-6">
                                <label>
                                    <b>Ativo Físico:</b> {{ $ativo_fisico->nome_ativo }}  {{ $ativo_fisico->cod_ativo_fisico }}
                                </label>
                            </div>
                            @if (Auth::user()->nivel_acesso->nome == 'Master' || Auth::user()->nivel_acesso->nome == 'Administrador')
                                <div class="col-md-6">
                                    <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modalDados" style="float:right">Dados reais inseridos</button>
                                </div>
                            @endif
                            <div class="col-md-12" style="margin-bottom: 15px">
                                <hr>
                            </div>
                            <div class="col-md-12">
                                <div class="alert alert-warning">
                                    <b>Nota:</b> É necessário preencher pelo menos um ano completo para realizar os cálculos
                                </div>
                            </div>
                        </div>
                        <table class="table table-default table-default-sm table-responsive">
                            <thead>
                                <tr>
                                    <td style="width:8%" rowspan="2">Ano</td>
                                    <td style="width:8%" colspan="3">Operação</td>
                                    <td style="width:8%" colspan="3">Manutenção planejada</td>
                                    <td style="width:8%" colspan="3">Manutenção não planejada</td>
                                    <td style="width:8%" rowspan="2">Taxa de inflação</td>
                                    <td style="width:8%" rowspan="2" class="d-none">Fator Multiplicador Sugerido</td>
                                </tr>
                                <tr>
                                    <td style="width:8%">Operadores</td>
                                    <td style="width:8%">Energia</td>
                                    <td style="width:8%">Total</td>
                                    <td style="width:8%">Mantenedores</td>
                                    <td style="width:8%">Materiais/ Serviços</td>
                                    <td style="width:8%">Total</td>
                                    <td style="width:8%">Mantenedores</td>
                                    <td style="width:8%">Materiais/ Serviços</td>
                                    <td style="width:8%">Total</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $cont = 0;

                                // Voltar mais 40 anos
                                for($i=$ativo_fisico->ano_aquisicao; $i <= $ativo_fisico->ano_aquisicao + 40; $i++){
                                    $ano = json_decode($opex->ano);
                                    $operadores = json_decode($opex->operadores);

                                    $array[$i] = [
                                        'ano' => json_decode($opex->ano)[$cont] ?? "",
                                        'operadores' => json_decode($opex->operadores)[$cont] ?? "",
                                        'energia' => json_decode($opex->energia)[$cont] ?? "",
                                        'total_operacao' => json_decode($opex->total_operacao)[$cont] ?? "",
                                        'mantenedores_manutencao_planejada' => json_decode($opex->mantenedores_manutencao_planejada)[$cont] ?? "",
                                        'materiais_servicos_manutencao_planejada' => json_decode($opex->materiais_servicos_manutencao_planejada)[$cont] ?? "",
                                        'total_manutencao_planejada' => json_decode($opex->total_manutencao_planejada)[$cont] ?? "",
                                        'mantenedores_manutencao_n_planejada' => json_decode($opex->mantenedores_manutencao_n_planejada)[$cont] ?? "",
                                        'materiais_servicos_manutencao_n_planejada' => json_decode($opex->materiais_servicos_manutencao_n_planejada)[$cont] ?? "",
                                        'total_manutencao_n_planejada' => json_decode($opex->total_manutencao_n_planejada)[$cont] ?? "",
                                        'taxa_inflacao' => json_decode($opex->taxa_inflacao)[$cont] ?? "",
                                        'fator_multiplicador_sugerido' => json_decode($opex->fator_multiplicador_sugerido)[$cont] ?? ""
                                    ];
                                    ?>
                                    <tr class="trAno" id="trAno{{ $i }}">
                                        <td>
                                            <input type="number" class="form-control" id="ano{{$i}}" name="ano[]" value="<?= $i ?>" maxlength="4" readonly>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">R$</span>
                                                </div>
                                                <input type="text" id="operadores{{ $i }}" name="operadores[]" data-ano="{{ $i }}" data-tipo="operadores" value="<?= $array[$i]['operadores'] ?? null ?>" onkeyup="calculaTotal('operacao', this, {{ $i }})" class="form-control valor{{ $i }} valor_rs" <?= ($i > date('Y') ? 'readonly' : '') ?> {{ ($opex->estudo->status == 2) ? "readonly" : "" }}>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">R$</span>
                                                </div>
                                                <input type="text" id="energia{{ $i }}" name="energia[]" data-ano="{{ $i }}" data-tipo="energia" value="<?= $array[$i]['energia'] ?? null ?>" onkeyup="calculaTotal('operacao', this, {{ $i }})" class="form-control valor{{ $i }} valor_rs" <?= ($i > date('Y') ? 'readonly' : '') ?> {{ ($opex->estudo->status == 2) ? "readonly" : "" }}>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">R$</span>
                                                </div>
                                                <input type="text" id="total_operacao{{ $i }}" data-ano="{{ $i }}" name="total_operacao[]" value="<?= $array[$i]['total_operacao'] ?? null ?>" class="form-control valor{{ $i }} valor_rs total_operacao" readonly {{ ($opex->estudo->status == 2) ? "readonly" : "" }}>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">R$</span>
                                                </div>
                                                <input type="text" id="mantenedores_manutencao_planejada{{ $i }}" data-ano="{{ $i }}" data-tipo="mantenedores_manutencao_planejada" name="mantenedores_manutencao_planejada[]" value="<?= $array[$i]['mantenedores_manutencao_planejada'] ?? null ?>" onkeyup="calculaTotal('manutencao_planejada', this, {{ $i }})" class="form-control valor{{ $i }} valor_rs" <?= ($i > date('Y') ? 'readonly' : '') ?> {{ ($opex->estudo->status == 2) ? "readonly" : "" }}>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">R$</span>
                                                </div>
                                                <input type="text" id="materiais_servicos_manutencao_planejada{{ $i }}" data-ano="{{ $i }}" data-tipo="materiais_servicos_manutencao_planejada" name="materiais_servicos_manutencao_planejada[]" value="<?= $array[$i]['materiais_servicos_manutencao_planejada'] ?? null ?>" onkeyup="calculaTotal('manutencao_planejada', this, {{ $i }})" class="form-control valor{{ $i }} valor_rs" <?= ($i > date('Y') ? 'readonly' : '') ?> {{ ($opex->estudo->status == 2) ? "readonly" : "" }}>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">R$</span>
                                                </div>
                                                <input type="text" id="total_manutencao_planejada{{ $i }}" data-ano="{{ $i }}" name="total_manutencao_planejada[]" value="<?= $array[$i]['total_manutencao_planejada'] ?? null ?>" class="form-control valor{{ $i }} valor_rs total_manutencao_planejada" readonly {{ ($opex->estudo->status == 2) ? "readonly" : "" }}>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">R$</span>
                                                </div>
                                                <input type="text" id="mantenedores_manutencao_n_planejada{{ $i }}" data-ano="{{ $i }}" data-tipo="mantenedores_manutencao_n_planejada" name="mantenedores_manutencao_n_planejada[]" value="<?= $array[$i]['mantenedores_manutencao_n_planejada'] ?? null ?>" onkeyup="calculaTotal('manutencao_n_planejada', this, {{ $i }})" class="form-control valor{{ $i }} valor_rs" <?= ($i > date('Y') ? 'readonly' : '') ?> {{ ($opex->estudo->status == 2) ? "readonly" : "" }}>  
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">R$</span>
                                                </div>
                                                <input type="text" id="materiais_servicos_manutencao_n_planejada{{ $i }}" data-ano="{{ $i }}" data-tipo="materiais_servicos_manutencao_n_planejada" name="materiais_servicos_manutencao_n_planejada[]" value="<?= $array[$i]['materiais_servicos_manutencao_n_planejada'] ?? null ?>" onkeyup="calculaTotal('manutencao_n_planejada', this, {{ $i }})" class="form-control valor{{ $i }} valor_rs" <?= ($i > date('Y') ? 'readonly' : '') ?> {{ ($opex->estudo->status == 2) ? "readonly" : "" }}>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">R$</span>
                                                </div>
                                                <input type="text" id="total_manutencao_n_planejada{{ $i }}" data-ano="{{ $i }}" name="total_manutencao_n_planejada[]" value="<?= $array[$i]['total_manutencao_n_planejada'] ?? null ?>" class="form-control valor{{ $i }} valor_rs total_manutencao_n_planejada" readonly {{ ($opex->estudo->status == 2) ? "readonly" : "" }}>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" id="taxa_inflacao{{ $i }}" name="taxa_inflacao[]" class="form-control text-center" value="<?= $inflacoes[$i]['inflacao'] ?? $array[$i]['taxa_inflacao'] ?? null ?>" readonly>
                                            </div>
                                        </td>
                                        <td class="d-none">
                                            <div class="input-group">
                                                <input type="text" id="fator_multiplicador_sugerido{{ $i }}" name="fator_multiplicador_sugerido[]" class="form-control text-center" value="<?= floatval($inflacoes[$i]['inflacao']) + 100 ?? $array[$i]['fator_multiplicador_sugerido'] ?? null ?>%"  readonly {{ ($opex->estudo->status == 2) ? "readonly" : "" }}>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                    $cont++;
                                }
                                ?>
                            </tbody>
                        </table>
                        <div class="chat-button d-none" id="btnCalcula" data-ano="00" data-toggle="tooltip" data-placement="top" title="Calcular os demais valores">
                            <span class="chat-link">
                                <i class="fa-solid fa-calculator"></i>
                            </span>
                        </div>
                        <div class="modal fade" id="modalSelecionarAnoCalculo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content" style="border-radius: 20px">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Selecione o ano</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <div class="row">
                                    <div class="col-md-12">
                                        <div class="alert alert-warning">
                                            @if ($opex->estudo->status == 2)
                                                Para atualizar o C.A.E selecione um ano de referência e clique no botão abaixo para recalcular os valores e gerar um novo gráfico
        
                                            @else
                                                Existem mais de um ano preenchido por completo, selecione o ano de referência que deseja realizar os cálculos
        
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label"><b>Ano:</b></label>
                                        <select name="ano" id="ano" class="form-control select2">
                                            <option value="">Selecione...</option>
                                            {{-- Voltar + 40 --}}
                                            @for($i = $ativo_fisico->ano_aquisicao; $i <= ($ativo_fisico->ano_aquisicao + 40); $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                                  <input type="hidden" name="ano_referencia_anterior" id="anoReferenciaAnterior" value="{{ $opex->ano_referencia_anterior ?? null }}">
                                  @if($opex->estudo->custo_anual_equivalente != null && $opex->ano_referencia_anterior != null)
                                    <button class="btn btn-primary" id="btnCalculaAnoReferenciaAnterior" type="button">Usar ano referência anterior</button>
                                  @endif
                                  @if ($opex->estudo->status == 2)
                                      <button type="button" class="btn btn-success" id="btnCalcularModal" data-tipo="atualizarCAE">Atualizar C.A.E</button>

                                  @else
                                      <button type="button" class="btn btn-success" id="btnCalcularModal">Calcular</button>

                                  @endif
                                </div>
                              </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modalConfirmaDebitoCreditos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content" style="border-radius: 20px">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Confirmar ação</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <div class="row">
                                    <div class="col-md-12">
                                        <div class="alert alert-warning">
                                            <p>
                                                <b>Você tem certeza que todas as informações preenchidas estão corretas?</b>
                                            </p>
                                            <span>
                                                Ao concluir, será debitado 1 crédito de estudo da sua conta
                                            </span>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-danger" data-dismiss="modal">Conferir informações</button>
                                  <button type="button" class="btn btn-success" id="btnConfirmarDebito">Concluir o estudo</button>
                                </div>
                              </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modalDados" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Dados reais inseridos</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <div class="row">
                                    <div class="col-md-12" style="height: 500px;overflow:auto">
                                        <table class="table table-default table-hover table-responsive">
                                            <thead>
                                                <tr>
                                                    <td style="width:8%" rowspan="2">Ano</td>
                                                    <td style="width:8%" colspan="2">Operação</td>
                                                    <td style="width:8%" colspan="2">Manutenção planejada</td>
                                                    <td style="width:8%" colspan="2">Manutenção não planejada</td>
                                                </tr>
                                                <tr>
                                                    <td style="width:8%">Operadores</td>
                                                    <td style="width:8%">Energia</td>
                                                    <td style="width:8%">Mantenedores</td>
                                                    <td style="width:8%">Materiais/ Serviços</td>
                                                    <td style="width:8%">Mantenedores</td>
                                                    <td style="width:8%">Materiais/ Serviços</td>
                                                </tr>
                                            </thead>
                                            <tbody style="text-align:center">
                                                @if ($opex->dados_preenchidos_cliente)
                                                    @php
                                                        $dados = json_decode($opex->dados_preenchidos_cliente, true);
                                                        ksort($dados);
                                                    @endphp
                                                    @foreach ($dados as $ano => $dados_preenchido) 
                                                        <tr>
                                                            <td>{{ $ano }}</td>
                                                            <td>{{ $dados_preenchido['operadores'] ?? null }}</td>
                                                            <td>{{ $dados_preenchido['energia'] ?? null }}</td>
                                                            <td>{{ $dados_preenchido['mantenedores_manutencao_planejada'] ?? null }}</td>
                                                            <td>{{ $dados_preenchido['materiais_servicos_manutencao_planejada'] ?? null }}</td>
                                                            <td>{{ $dados_preenchido['mantenedores_manutencao_n_planejada'] ?? null }}</td>
                                                            <td>{{ $dados_preenchido['materiais_servicos_manutencao_n_planejada'] ?? null }}</td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                  </div>
                                </div>
                             </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 pt-4">
                        <a type="button" class="btn btn-dark" href="{{ route('capex.edit', $opex->estudo->capex_id) }}">Voltar</a>
                        @if ($opex->estudo->status == 2)
                            <button type="button" data-toggle="modal" data-target="#modalSelecionarAnoCalculo" class="btn btn-primary">Atualizar C.A.E</button>

                        @elseif($opex->estudo->custo_anual_equivalente == null)
                            <button type="button" data-toggle="modal" data-target="#modalConfirmaDebitoCreditos" class="btn btn-primary" id="btnSalvar" disabled>Salvar e avançar</button>

                        @else
                            <button type="submit" class="btn btn-primary">Salvar e avançar</button>

                        @endif

                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section("js")
    <script>
        const melhoriasReformas = <?php echo json_encode($melhorias_reformas ?? []); ?>;

        const dadosInseridosClientes = <?php echo json_encode($opex->dados_preenchidos_cliente ?? []); ?>;

        document.getElementById('btnConfirmarDebito').addEventListener('click', function() {
            document.getElementById('formOpex').submit();
        });

        $(document).ready(function(){
            $(".valor_rs").on("change", function (){
                var valor = this.value;
                var ano = $(this).attr("data-ano");
                var tipo = $(this).attr("data-tipo");

                var existingInput = $("form#formOpex").find(`input[name='dados[${ano}][${tipo}]']`);

                if (valor === "0,00" || valor === "0") {
                    $("form#formOpex").find(`input[name='dados[${ano}][${tipo}]']`).remove();

                } else {
                    if (existingInput.length > 0) {
                        existingInput.val(valor);

                    } else {
                        var inputHidden = $("<input>", {
                            type: "hidden",
                            name: `dados[${ano}][${tipo}]`,
                            class: `dados${tipo}${ano}`,
                            value: valor
                        });

                        $("form#formOpex").append(inputHidden);
                    }
                }
            })

            $("#btnCalcula").on("click", function(){
                var ano = $(this).attr("data-ano");
                var anoAquisicao = parseInt($("#ano_aquisicao").val());
                var anoFinalCalculo = (anoAquisicao + 40);

                $("#anoReferenciaAnterior").val(ano);

                var array = $('.total_operacao').serializeArray();

                var cont = 0;

                $(array).each(function (){
                    if(this.value != '0,00'){
                        cont++
                    }
                })
                
                if(cont > 1){
                    $("#modalSelecionarAnoCalculo").modal('show')

                }else{
                    calculaPraTras(anoAquisicao, parseInt(ano));
                    calculaPraFrente(anoFinalCalculo, parseInt(ano));

                    $(`.trAno`).css("background-color", "white");
                    $(`#trAno${ano}`).css("background-color", "#00326259");

                    dispararAlerta('Ano referência calculado com sucesso <hr> Vá para o final da tela e clique em "Salvar e avançar" para continuar ');

                    $("#btnSalvar").removeAttr("disabled");
                }
            });

            $("#btnCalculaAnoReferenciaAnterior").on("click",function (){
                $("#ano").val($("#anoReferenciaAnterior").val()).trigger("change");

                $("#btnCalcularModal").click()
            });

            $("#btnCalcularModal").on("click", function(){
                $(`.trAno`).css("background-color", "white");
                $(`#trAno${$("#ano").val()}`).css("background-color", "#00326259");
                var anoAquisicao = parseInt($("#ano_aquisicao").val());
                var anoFinalCalculo = (anoAquisicao + 40);

                $("#anoReferenciaAnterior").val($("#ano").val());

                calculaPraFrente(anoFinalCalculo, parseInt($("#ano").val()));
                calculaPraTras(anoAquisicao, parseInt($("#ano").val()));

                $("#modalSelecionarAnoCalculo").modal('hide');

                if($(this).attr("data-tipo") == "atualizarCAE"){
                    $("#formOpex").submit();

                }else{
                    dispararAlerta('Ano referência calculado com sucesso <hr> Vá para o final da tela e clique em "Salvar e avançar" para continuar ');

                    $("#btnSalvar").removeAttr("disabled");
                }
            })
        });

        
        function calculaPraTras(anoAquisicao, ano)
        {
            var anos = [];

            for (let anoAtual = anoAquisicao; anoAtual < ano; anoAtual++) {
                anos.push(anoAtual);
            }

            var anosInvertido = anos.reverse();

            anosInvertido.forEach(anoAtual => {
                var fatorMultiplicadorAnterior = $(`#fator_multiplicador_sugerido${anoAtual}`).val().replace("%", "");
                var valorAtualOperadores = $(`#operadores${anoAtual + 1}`).val();
                var valorAtualEnergia = $(`#energia${anoAtual + 1}`).val();
                var valorAtualMantenedores = $(`#mantenedores_manutencao_planejada${anoAtual + 1}`).val();
                var valorAtualMateriaisServicos = $(`#materiais_servicos_manutencao_planejada${anoAtual + 1}`).val();
                var valorAtualMantenedores2 = $(`#mantenedores_manutencao_n_planejada${anoAtual + 1}`).val();
                var valorAtualMateriaisServicos2 = $(`#materiais_servicos_manutencao_n_planejada${anoAtual + 1}`).val();
                
                setOperadoresAnterior(valorAtualOperadores, fatorMultiplicadorAnterior, anoAtual);
                setEnergiaAnterior(valorAtualEnergia, fatorMultiplicadorAnterior, anoAtual);
                setMantenedoresAnterior(valorAtualMantenedores, fatorMultiplicadorAnterior, anoAtual);
                setMateriaisServicosAnterior(valorAtualMateriaisServicos, fatorMultiplicadorAnterior, anoAtual);
                setMantenedoresManutencaoNaoPlanejadaAnterior(valorAtualMantenedores2, fatorMultiplicadorAnterior, anoAtual);
                setMateriaisServicosManutencaoNaoPlanejadaAnterior(valorAtualMateriaisServicos2, fatorMultiplicadorAnterior, anoAtual);

            });
        }

        function setMateriaisServicosManutencaoNaoPlanejadaAnterior(valorAtualMateriaisServicos2, fatorMultiplicadorAnterior, anoAtual)
        {
            if($(`#materiais_servicos_manutencao_n_planejada${anoAtual}`).val() != "0,00"){
                return;
            }

            var valorNovo = divisao(fatorMultiplicadorAnterior, valorAtualMateriaisServicos2, true);

            $(`#materiais_servicos_manutencao_n_planejada${anoAtual}`).val(valorNovo);

            $(`#materiais_servicos_manutencao_n_planejada${anoAtual}`).trigger("keyup");
        }

        function setMantenedoresManutencaoNaoPlanejadaAnterior(valorAtualMantenedores2, fatorMultiplicadorAnterior, anoAtual)
        {
            if($(`#mantenedores_manutencao_n_planejada${anoAtual}`).val() != "0,00"){
                return;
            }

            var valorNovo = divisao(fatorMultiplicadorAnterior, valorAtualMantenedores2, true);

            $(`#mantenedores_manutencao_n_planejada${anoAtual}`).val(valorNovo);

            $(`#mantenedores_manutencao_n_planejada${anoAtual}`).trigger("keyup");
        }

        function setMateriaisServicosAnterior(valorAtualMateriaisServicos, fatorMultiplicadorAnterior, anoAtual)
        {
            if($(`#materiais_servicos_manutencao_planejada${anoAtual}`).val() != "0,00"){
                return;
            }

            var valorNovo = divisao(fatorMultiplicadorAnterior, valorAtualMateriaisServicos, true);

            $(`#materiais_servicos_manutencao_planejada${anoAtual}`).val(valorNovo);

            $(`#materiais_servicos_manutencao_planejada${anoAtual}`).trigger("keyup");
        }

        function setMantenedoresAnterior(valorAtualMantenedores, fatorMultiplicadorAnterior, anoAtual)
        {
            if($(`#mantenedores_manutencao_planejada${anoAtual}`).val() != "0,00"){
                return;
            }

            var valorNovo = divisao(fatorMultiplicadorAnterior, valorAtualMantenedores, true);

            $(`#mantenedores_manutencao_planejada${anoAtual}`).val(valorNovo);

            $(`#mantenedores_manutencao_planejada${anoAtual}`).trigger("keyup");
        }

        function setEnergiaAnterior(valorAtualEnergia, fatorMultiplicadorAnterior, anoAtual)
        {
            if($(`#energia${anoAtual}`).val() != "0,00"){
                return;
            }

            var valorNovo = divisao(fatorMultiplicadorAnterior, valorAtualEnergia, true);

            $(`#energia${anoAtual}`).val(valorNovo);

            $(`#energia${anoAtual}`).trigger("keyup");
        }

        function setOperadoresAnterior(valorAtualOperadores, fatorMultiplicadorAnterior, anoAtual)
        {
            if($(`#operadores${anoAtual}`).val() != "0,00"){
                return;
            }

            var valorNovo = divisao(fatorMultiplicadorAnterior, valorAtualOperadores);

            $(`#operadores${anoAtual}`).val(valorNovo);

            $(`#operadores${anoAtual}`).trigger("keyup");
        }

        function divisao(fatorMulplicador, valor, novaRegra = false)
        {
            var valorFormatado = formata_moeda(valor, 'en-US');
            var valorFloat = parseFloat(valorFormatado.replace(/[$,]/g, ''));

            if(novaRegra == true){
                var divisao =  (valorFloat / (fatorMulplicador / 100)) / 1.05;

            }else{
                var divisao =  (valorFloat / (fatorMulplicador / 100));

            }

            var resultado_formatado = divisao.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

            return resultado_formatado.replace("R$", "").trim();
        }

        function calculaPraFrente(anoFinalCalculo, anoAtualCalculo)
        {
            var proximoAno = anoAtualCalculo + 1;
            var valorAtualOperadores = $(`#operadores${anoAtualCalculo}`).val();

            for (let ano = anoAtualCalculo; ano <= anoFinalCalculo; ano++) {   
                var valorAtualOperadores = $(`#operadores${ano}`).val();
                var valorAtualEnergia = $(`#energia${ano}`).val();
                var valorAtualMantenedores = $(`#mantenedores_manutencao_planejada${ano}`).val();
                var valorAtualMateriaisServicos = $(`#materiais_servicos_manutencao_planejada${ano}`).val();
                var valorAtualMantenedores2 = $(`#mantenedores_manutencao_n_planejada${ano}`).val();
                var valorAtualMateriaisServicos2 = $(`#materiais_servicos_manutencao_n_planejada${ano}`).val();
                var taxaInflacao = $(`#taxa_inflacao${ano}`).val().replace("%", "")
                
                setOperadores(valorAtualOperadores, ano, taxaInflacao);
                setEnergias(valorAtualEnergia, ano, taxaInflacao);
                setMantenedores(valorAtualMantenedores, ano, taxaInflacao);
                setMateriaisServicos(valorAtualMateriaisServicos, ano, taxaInflacao);
                setMantenedoresManutencaoNaoPlanejada(valorAtualMantenedores2, ano, taxaInflacao);
                setMateriaisServicosManutencaoNaoPlanejada(valorAtualMateriaisServicos2, ano, taxaInflacao);
            }
        }

        function setMateriaisServicosManutencaoNaoPlanejada(valor, ano, taxaInflacao)
        {
            var melhoria_reformas = verificaMelhoriaReformasManNaoPlanejada(valor, ano, "materiais_servicos_manutencao_n_planejada");

            if(melhoria_reformas != null){
                $(`#materiais_servicos_manutencao_n_planejada${ano}`).val(melhoria_reformas);
                $(`#materiais_servicos_manutencao_n_planejada${ano}`).trigger("keyup");
                valor = melhoria_reformas;
            }

            if(dadosInseridosClientes.length != 0 && typeof JSON.parse(dadosInseridosClientes)[ano + 1] != "undefined" && typeof JSON.parse(dadosInseridosClientes)[ano + 1]['materiais_servicos_manutencao_n_planejada'] != "undefined"){
                return;
            }

            if(dadosInseridosClientes.length == 0){
                if($("#ano").val() != ano && $(`#materiais_servicos_manutencao_n_planejada${ano + 1}`).val() != "0,00"){
                    return;
                }else if(typeof $(`.dadosmateriais_servicos_manutencao_n_planejada${ano + 1}`).val() != "undefined" && $(`#materiais_servicos_manutencao_n_planejada${ano + 1}`).val() != "0,00"){
                    return;
                }
            }else{
                if(typeof $(`.dadosmateriais_servicos_manutencao_n_planejada${ano + 1}`).val() != "undefined"){
                    return;
                }
            }

            var novoValor = porcentagem(taxaInflacao, valor);
            var novoValorCombinado = porcentagem(5, novoValor);


            $(`#materiais_servicos_manutencao_n_planejada${ano + 1}`).val(novoValorCombinado);
            $(`#materiais_servicos_manutencao_n_planejada${ano + 1}`).trigger("keyup");
        }

        function setMantenedoresManutencaoNaoPlanejada(valor, ano, taxaInflacao)
        {
            var melhoria_reformas = verificaMelhoriaReformasManNaoPlanejada(valor, ano, "mantenedores_manutencao_n_planejada");

            if(melhoria_reformas != null){
                $(`#mantenedores_manutencao_n_planejada${ano}`).val(melhoria_reformas);
                $(`#mantenedores_manutencao_n_planejada${ano}`).trigger("keyup");
                valor = melhoria_reformas;
            }

            if(dadosInseridosClientes.length != 0 && typeof JSON.parse(dadosInseridosClientes)[ano + 1] != "undefined" && typeof JSON.parse(dadosInseridosClientes)[ano + 1]['mantenedores_manutencao_n_planejada'] != "undefined"){
                return;
            }

            if(dadosInseridosClientes.length == 0){
                if($("#ano").val() != ano && $(`#mantenedores_manutencao_n_planejada${ano + 1}`).val() != "0,00"){
                    return;
                }else if(typeof $(`.dadosmantenedores_manutencao_n_planejada${ano + 1}`).val() != "undefined" && $(`#mantenedores_manutencao_n_planejada${ano + 1}`).val() != "0,00"){
                    return;
                }
            }else{
                if(typeof $(`.dadosmantenedores_manutencao_n_planejada${ano + 1}`).val() != "undefined"){
                    return;
                }
            }

            var novoValor = porcentagem(taxaInflacao, valor);
            var novoValorCombinado = porcentagem(5, novoValor);

            $(`#mantenedores_manutencao_n_planejada${ano + 1}`).val(novoValorCombinado);
            $(`#mantenedores_manutencao_n_planejada${ano + 1}`).trigger("keyup");
        }

        function verificaMelhoriaReformasManNaoPlanejada(valor, ano, tipo)
        {
            if(typeof melhoriasReformas === "undefined") {
                return null;
            }
            
            if(melhoriasReformas.length === 0){
                return null;
            }

            indexAno = melhoriasReformas.melhorias_reformas_ano.indexOf(ano);

            if(melhoriasReformas.melhorias_reformas_ano.indexOf(ano) < 0){
                return null;
            }

            if(melhoriasReformas.melhorias_reformas_man_n_planejada[indexAno] == null){
                return null;
            }

            if(tipo == "mantenedores_manutencao_n_planejada" && typeof $(`.dadosmantenedores_manutencao_n_planejada${ano}`).val() != "undefined"){
                return null;
            }

            if(tipo == "materiais_servicos_manutencao_n_planejada" && typeof $(`.dadosmateriais_servicos_manutencao_n_planejada${ano}`).val() != "undefined"){
                return null;
            }

            var porcentagem = melhoriasReformas.melhorias_reformas_man_n_planejada[indexAno];

            valorOriginal = valor.replace(/\./g, "").replace(",", ".");

            let numero = parseFloat(valorOriginal);

            let percentual = porcentagem / 100;

            let diminuicao = numero * percentual;

            let total = numero - diminuicao;

            let valorFormatado = new Intl.NumberFormat("pt-BR", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            }).format(total);

            return valorFormatado;
        }

        function setMateriaisServicos(valor, ano, taxaInflacao)
        {
            var melhoria_reformas = verificaMelhoriaReformasManPlanejada(valor, ano, "materiais_servicos_manutencao_planejada");

            if(melhoria_reformas != null){
                $(`#materiais_servicos_manutencao_planejada${ano}`).val(melhoria_reformas);
                $(`#materiais_servicos_manutencao_planejada${ano}`).trigger("keyup");
                valor = melhoria_reformas;
            }

            if(dadosInseridosClientes.length != 0 && typeof JSON.parse(dadosInseridosClientes)[ano + 1] != "undefined" && typeof JSON.parse(dadosInseridosClientes)[ano + 1]['materiais_servicos_manutencao_planejada'] != "undefined"){
                return;
            }

            if(dadosInseridosClientes.length == 0){
                if($("#ano").val() != ano && $(`#materiais_servicos_manutencao_planejada${ano + 1}`).val() != "0,00"){
                    return;
                }else if(typeof $(`.dadosmateriais_servicos_manutencao_planejada${ano + 1}`).val() != "undefined" && $(`#materiais_servicos_manutencao_planejada${ano + 1}`).val() != "0,00"){
                    return;
                }
            }else{
                if(typeof $(`.dadosmateriais_servicos_manutencao_planejada${ano + 1}`).val() != "undefined"){
                    return;
                }
            }

            var novoValor = porcentagem(taxaInflacao, valor);
            var novoValorCombinado = porcentagem(5, novoValor);

            $(`#materiais_servicos_manutencao_planejada${ano + 1}`).val(novoValorCombinado);
            $(`#materiais_servicos_manutencao_planejada${ano + 1}`).trigger("keyup");
        }

        function setMantenedores(valor, ano, taxaInflacao)
        {
            var melhoria_reformas = verificaMelhoriaReformasManPlanejada(valor, ano, "mantenedores_manutencao_planejada");

            if(melhoria_reformas != null){
                $(`#mantenedores_manutencao_planejada${ano}`).val(melhoria_reformas);
                $(`#mantenedores_manutencao_planejada${ano}`).trigger("keyup");
                valor = melhoria_reformas;
            }

            if(dadosInseridosClientes.length != 0 && typeof JSON.parse(dadosInseridosClientes)[ano + 1] != "undefined" && typeof JSON.parse(dadosInseridosClientes)[ano + 1]['mantenedores_manutencao_planejada'] != "undefined"){
                return;
            }

            if(dadosInseridosClientes.length == 0){
                if($("#ano").val() != ano && $(`#mantenedores_manutencao_planejada${ano + 1}`).val() != "0,00"){
                    return;
                }else if(typeof $(`.dadosmantenedores_manutencao_planejada${ano + 1}`).val() != "undefined" && $(`#mantenedores_manutencao_planejada${ano + 1}`).val() != "0,00"){
                    return;
                }
            }else{
                if(typeof $(`.dadosmantenedores_manutencao_planejada${ano + 1}`).val() != "undefined"){
                    return;
                }
            }

            var novoValor = porcentagem(taxaInflacao, valor);
            var novoValorCombinado = porcentagem(5, novoValor);

            $(`#mantenedores_manutencao_planejada${ano + 1}`).val(novoValorCombinado);
            $(`#mantenedores_manutencao_planejada${ano + 1}`).trigger("keyup");
        }

        function verificaMelhoriaReformasManPlanejada(valor, ano, tipo)
        {
            if(typeof melhoriasReformas === "undefined") {
                return null;
            }

            if(melhoriasReformas.length === 0){
                return null;
            }

            indexAno = melhoriasReformas.melhorias_reformas_ano.indexOf(ano);

            if(melhoriasReformas.melhorias_reformas_ano.indexOf(ano) < 0){
                return null;
            }

            if(melhoriasReformas.melhorias_reformas_man_planejada[indexAno] == null){
                return null;
            }

            if(tipo == "mantenedores_manutencao_planejada" && typeof $(`.dadosmantenedores_manutencao_planejada${ano}`).val() != "undefined"){
                return null;
            }

            if(tipo == "materiais_servicos_manutencao_planejada" && typeof $(`.dadosmateriais_servicos_manutencao_planejada${ano}`).val() != "undefined"){
                return null;
            }

            var porcentagem = melhoriasReformas.melhorias_reformas_man_planejada[indexAno];

            valorOriginal = valor.replace(/\./g, "").replace(",", ".");

            let numero = parseFloat(valorOriginal);

            let percentual = porcentagem / 100;

            let diminuicao = numero * percentual;

            let total = numero - diminuicao;

            let valorFormatado = new Intl.NumberFormat("pt-BR", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            }).format(total);

            return valorFormatado;
        }

        function setEnergias(valor, ano, taxaInflacao)
        {
            var melhoria_reformas = verificaMelhoriaReformasOperacao(valor, ano, 'energia');

            if(melhoria_reformas != null){
                $(`#energia${ano}`).val(melhoria_reformas);
                $(`#energia${ano }`).trigger("keyup");
                valor = melhoria_reformas;
            }

            if(dadosInseridosClientes.length != 0 && typeof JSON.parse(dadosInseridosClientes)[ano + 1] != "undefined" && typeof JSON.parse(dadosInseridosClientes)[ano + 1]['energia'] != "undefined"){
                return;
            }

            if(dadosInseridosClientes.length == 0){
                if($("#ano").val() != ano && $(`#energia${ano + 1}`).val() != "0,00"){
                    return;
                }else if(typeof $(`.dadosenergia${ano + 1}`).val() != "undefined" && $(`#energia${ano + 1}`).val() != "0,00"){
                    return;
                }
            }else{
                if(typeof $(`.dadosenergia${ano + 1}`).val() != "undefined"){
                    return;
                }
            }

            var novoValor = porcentagem(taxaInflacao, valor);
            var novoValorCombinado = porcentagem(5, novoValor);

            $(`#energia${ano + 1}`).val(novoValorCombinado);
            $(`#energia${ano + 1}`).trigger("keyup");
        }

        function setOperadores(valor, ano, taxaInflacao)
        {            
            melhoria_reformas = verificaMelhoriaReformasOperacao(valor, ano, 'operadores');

            if(melhoria_reformas != null){
                $(`#operadores${ano}`).val(melhoria_reformas);
                $(`#operadores${ano}`).trigger("keyup");
                valor = melhoria_reformas;
            }
                    
            if(dadosInseridosClientes.length != 0 && typeof JSON.parse(dadosInseridosClientes)[ano + 1] != "undefined" && typeof JSON.parse(dadosInseridosClientes)[ano + 1]['operadores'] != "undefined"){
                return;
            }

            if(dadosInseridosClientes.length == 0){
                if($("#ano").val() != ano && $(`#operadores${ano + 1}`).val() != "0,00"){
                    return;
                }else if(typeof $(`.dadosoperadores${ano + 1}`).val() != "undefined" && $(`#operadores${ano + 1}`).val() != "0,00"){
                    return;
                }
            }else{
                if(typeof $(`.dadosoperadores${ano + 1}`).val() != "undefined"){
                    return;
                }
            }

            var novoValor = porcentagem(taxaInflacao, valor);

            $(`#operadores${ano + 1}`).val(novoValor);
            $(`#operadores${ano + 1}`).trigger("keyup");
        }

        function verificaMelhoriaReformasOperacao(valor, ano, tipo)
        {            
            if(typeof melhoriasReformas === "undefined") {
                return null;
            }

            if(melhoriasReformas.length === 0){
                return null;
            }

            indexAno = melhoriasReformas.melhorias_reformas_ano.indexOf(ano);

            if(melhoriasReformas.melhorias_reformas_ano.indexOf(ano) < 0){
                return null;
            }

            if(melhoriasReformas.melhorias_reformas_operacao[indexAno] == null){
                return null;
            }

            if(tipo == "energia" && typeof $(`.dadosenergia${ano}`).val() != "undefined"){
                return null;
            }

            if(tipo == "operadores" && typeof $(`.dadosoperadores${ano}`).val() != "undefined"){
                return null;
            }

            var porcentagem = melhoriasReformas.melhorias_reformas_operacao[indexAno];

            valorOriginal = valor.replace(/\./g, "").replace(",", ".");

            let numero = parseFloat(valorOriginal);

            let percentual = porcentagem / 100;

            let diminuicao = numero * percentual;

            let total = numero - diminuicao;

            let valorFormatado = new Intl.NumberFormat("pt-BR", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            }).format(total);

            return valorFormatado;
        }

        function calculaTotal(tipo, elemento, ano)
        {
            var valor = $(elemento).val();

            if(tipo == 'operacao'){
                var energia = ($(`#energia${ano}`).val() == "") ? '0' : $(`#energia${ano}`).val();
                var operadores = ($(`#operadores${ano}`).val() == "") ? "0" : $(`#operadores${ano}`).val();
                
                var novoValor1 = formata_moeda(energia, 'en-US');
                var novoValor1Formatado = parseFloat(novoValor1.replace(/[$,]/g, ''));

                var novoValor2 = formata_moeda(operadores, 'en-US');
                var novoValor2Formatado = parseFloat(novoValor2.replace(/[$,]/g, ''));
            
                setTotal(novoValor1Formatado, novoValor2Formatado, `#total_operacao${ano}`)

            }else if(tipo == 'manutencao_planejada'){
                var mantenedores = ($(`#mantenedores_manutencao_planejada${ano}`).val()  == "") ? "0" : $(`#mantenedores_manutencao_planejada${ano}`).val();
                var materiais = ($(`#materiais_servicos_manutencao_planejada${ano}`).val() == "") ? "0" : $(`#materiais_servicos_manutencao_planejada${ano}`).val();

                var novoValor1 = formata_moeda(mantenedores, 'en-US');
                var novoValor1Formatado = parseFloat(novoValor1.replace(/[$,]/g, ''));

                var novoValor2 = formata_moeda(materiais, 'en-US');
                var novoValor2Formatado = parseFloat(novoValor2.replace(/[$,]/g, ''));
            
                setTotal(novoValor1Formatado, novoValor2Formatado, `#total_manutencao_planejada${ano}`)

            }else if(tipo == 'manutencao_n_planejada'){
                var mantenedores = ($(`#mantenedores_manutencao_n_planejada${ano}`).val()  == "") ? "0" : $(`#mantenedores_manutencao_n_planejada${ano}`).val();
                var materiais = ($(`#materiais_servicos_manutencao_n_planejada${ano}`).val() == "") ? "0" : $(`#materiais_servicos_manutencao_n_planejada${ano}`).val();

                var novoValor1 = formata_moeda(mantenedores, 'en-US');
                var novoValor1Formatado = parseFloat(novoValor1.replace(/[$,]/g, ''));

                var novoValor2 = formata_moeda(materiais, 'en-US');
                var novoValor2Formatado = parseFloat(novoValor2.replace(/[$,]/g, ''));
            
                setTotal(novoValor1Formatado, novoValor2Formatado, `#total_manutencao_n_planejada${ano}`)
            }

            verificaTotal();
        }

        function setTotal(valor1, valor2, elementoTotal)
        {
            var resultadoSoma = valor1 + valor2;

            var resultado_formatado = resultadoSoma.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
            var resultado_formatado = resultado_formatado.replace("R$", "").trim();

            $(`${elementoTotal}`).val(resultado_formatado);
        }

        function verificaTotal()
        {

            var anoAquisicao = parseInt($("#ano_aquisicao").val());
            var anoFinal = anoAquisicao + 40;

            for (let index = anoAquisicao; index <= anoFinal; index++) {
                var valores = $(`.valor${index}`);

                var cont = 0;

                $(valores).each(function (){
                    if(this.value == '0,00' || this.value == "0,0" || this.value == '0,000' || this.value == ""){
                        cont++;
                    }
                })

                if(cont == 0){
                    $("#btnCalcula").attr("data-ano", index);
                    $("#btnCalcula").attr("class", 'chat-button')

                    return;

                }else{
                    $("#btnCalcula").attr('class', 'chat-button d-none')

                }
            }
        }

        function porcentagem(porcentagem, valor) {
            var valorFormatado = formata_moeda(valor, 'en-US');
            var valorFloat = parseFloat(valorFormatado.replace(/[$,]/g, ''));

            var porcentagem =  (porcentagem / 100) * valorFloat;

            var novoValor =  valorFloat + porcentagem;

            var resultado_formatado = novoValor.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

            return resultado_formatado.replace("R$", "").trim();
        } 
    </script>
@endsection