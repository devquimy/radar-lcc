@extends('layouts.default')

@section('content-auth')

<div class="container-fluid">
    @include('layouts.time_line_estudos')

    <form class="g-3" action="{{ route('capex.update', $capex->id) }}" id="formCapex" method="post">
        @csrf
        <input type="hidden" name="ativo_fisico_id" value="{{ $capex->ativo_fisico_id }}">

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <label for="">
                            <b>Ativo Físico:</b> {{ $ativo_fisico->nome_ativo }}  {{ $ativo_fisico->cod_ativo_fisico }}
                        </label>
                        <hr>
                    </div>

                    {{-- Card Valores ativo_fisico --}}
                    <div class="col-md-6 mt-sm-3">
                        <div class="card-form" style="height:345px">
                            <div class="col-md-12">
                                <label for="valor_de_aquisicao" class="form-label">Valor de aquisição:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">R$</span>
                                    </div>
                                    <input type="text" id="valor_de_aquisicao" name="valor_ativo_original" value="{{ number_format($ativo_fisico->valor_ativo_original, 2,',', '.') }}" class="form-control regra_taxa_depreciacao valor_rs" required {{ ($capex->estudo->custo_anual_equivalente != null) ? "disabled" : "" }}>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="custo_de_instalacao" class="form-label">Custo de instalação:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">R$</span>
                                    </div>
                                    <input type="text" id="custo_de_instalacao" name="custo_instalacao" value="{{ number_format($ativo_fisico->custo_instalacao, 2,',', '.') }}" class="form-control valor_rs" {{ ($capex->estudo->custo_anual_equivalente != null) ? "disabled" : "" }}>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="custo_do_comissionamento" class="form-label">Custo do comissionamento:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">R$</span>
                                    </div>
                                    <input type="text" id="custo_do_comissionamento" name="custo_comissionamento" value="{{ number_format($ativo_fisico->custo_comissionamento, 2,',', '.') }}" class="form-control valor_rs" {{ ($capex->estudo->custo_anual_equivalente != null) ? "disabled" : "" }}>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="valor_da_depreciacao" class="form-label">Valor de depreciação:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">R$</span>
                                    </div>
                                    <input type="hidden" class="form-control regra_taxa_depreciacao" id="regra_de_depreciacao" name="regra_depreciacao" value="{{ $ativo_fisico->regra_depreciacao }}" aria-describedby="basic-addon2" maxlength="3" min="0" max="100">

                                    <input type="text" id="valor_da_depreciacao" name="valor_depreciacao" class="form-control" value="{{ $ativo_fisico->valor_depreciacao }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Card atualizacao patrimonial --}}
                    <div class="col-md-6 mt-sm-3">
                        <div class="card-form" style="height: 345px">
                            <div class="col">
                                <h5 class="pt-2 font-weight-bold">Atualização patrimonial</h5>
                            </div>
                            <div class="col-md-12">
                                <table class="table table-default">
                                    <thead>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>Ano</td>
                                            <td>Valor</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $atualizacao_patrimonial_ano = json_decode($capex->atualizacao_patrimonial)->atualizacao_patrimonial_ano ?? [];
                                            $atualizacao_patrimonial_valor = json_decode($capex->atualizacao_patrimonial)->atualizacao_patrimonial_valor ?? [];

                                            $arrayCheck = max([
                                                count(json_decode($capex->atualizacao_patrimonial)->atualizacao_patrimonial_ano ?? []),
                                                count(json_decode($capex->atualizacao_patrimonial)->atualizacao_patrimonial_valor ?? [])
                                            ]);
                                        @endphp

                                        @if (count($atualizacao_patrimonial_ano) == 0 && count($atualizacao_patrimonial_valor) == 0)
                                            @for ($i = 0; $i < 5; $i++)
                                                <tr>
                                                    <td class="text-center">{{ $i + 1}}</td>
                                                    <td>
                                                        <input type="number" class="form-control" id="atualizacao_patrimonial_ano" name="atualizacao_patrimonial_ano[]" value="" maxlength="4" onchange="validaAno(this)" max="">
                                                    </td>
                                                    <td>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon1">R$</span>
                                                            </div>
                                                            <input type="text" id="atualizacao_patrimonial_valor" name="atualizacao_patrimonial_valor[]" value="" class="form-control valor_rs">
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endfor
                                        @else
                                            @for ($i = 0; $i < 5; $i++)
                                                <tr>
                                                    <td class="text-center">{{ $i + 1 }}</td>
                                                    <td>
                                                        <input type="number" class="form-control" id="atualizacao_patrimonial_ano" name="atualizacao_patrimonial_ano[]" value="{{ $atualizacao_patrimonial_ano[$i] ?? null }}" maxlength="4" onchange="validaAno(this)" min="{{ $ativo_fisico->ano_aquisicao }}" max="{{ date("Y") }}">
                                                    </td>
                                                    <td>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon1">R$</span>
                                                            </div>
                                                            <input type="text" id="atualizacao_patrimonial_valor{{ $i }}" name="atualizacao_patrimonial_valor[]" value="{{ $atualizacao_patrimonial_valor[$i] ?? null }}" class="form-control valor_rs">
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endfor  
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Card melhorias e reformas --}}
        <div class="card mt-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12">
                                @if ($capex->estudo->status == 2)
                                    <div class="alert alert-warning">
                                        <b>Nota:</b> Para reprocessar o C.A.E com novas melhorias após a conclusão do estudo, é necessario ir em Opex e clicar na calculadora para atualização do Opex
                                    </div>
                                @endif
                            </div>
                            <div class="col-8">
                                <h5 class="pt-2 font-weight-bold">Melhorias e reformas</h5>
                            </div>
                            <div class="col-4 text-right">
                                <button class="btn btn-sm btn-primary shadow-sm" type="button" onclick="adicionarMelhoriasReformas()">
                                    <i class="fas fa-plus fa-sm text-white-50"></i> Adicionar
                                </button>
                            </div>
                        </div>
                        <table class="table table-default">
                            <thead>
                                <tr>
                                    <td style="width:20%" rowspan="2">Ano</td>
                                    <td style="width:20%" rowspan="2">Valor</td>
                                    <td style="width:20%" colspan="3">Percentual de redução de custos em:</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td style="width:20%">Operação</td>
                                    <td style="width:20%">Manut. planejada</td>
                                    <td style="width:20%">Manut. não planejada</td>
                                    <td>#</td>
                                </tr>
                            </thead>
                            <tbody id="tbodyMelhoriasReformas">
                                @php
                                    $melhorias_reformas = json_decode($capex->melhorias_reformas);
                                    
                                    $arrayCheck = max([
                                        count(json_decode($capex->melhorias_reformas)->melhorias_reformas_ano ?? []),
                                        count(json_decode($capex->melhorias_reformas)->melhorias_reformas_valor ?? []),
                                        count(json_decode($capex->melhorias_reformas)->melhorias_reformas_operacao ?? []),
                                        count(json_decode($capex->melhorias_reformas)->melhorias_reformas_man_n_planejada ?? []),
                                        count(json_decode($capex->melhorias_reformas)->melhorias_reformas_man_planejada ?? [])
                                    ]);
                                
                                @endphp
                                @if ($melhorias_reformas == null || $arrayCheck == 0)
                                    <tr class="trMelhoriasReformas">
                                        <td>
                                            <input type="number" class="form-control ano" id="melhorias_reformas_ano" name="melhorias_reformas_ano[]" value="" maxlength="4" onchange="validaAno(this)" min="{{ $ativo_fisico->ano_aquisicao }}">
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">R$</span>
                                                </div>
                                                <input type="text" id="melhorias_reformas_valor" name="melhorias_reformas_valor[]" class="form-control valor_rs" value="" onkeyup="atualizaValor(this)">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="number" class="form-control" id="melhorias_reformas_operacao" name="melhorias_reformas_operacao[]" value=""  maxlength="3" min="0" max="100">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="basic-addon2">%</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="number" class="form-control" id="melhorias_reformas_man_planejada" name="melhorias_reformas_man_planejada[]" value="" maxlength="3" min="0" max="100">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="basic-addon2">%</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="number" class="form-control" id="melhorias_reformas_man_n_planejada" name="melhorias_reformas_man_n_planejada[]" value="" maxlength="3" min="0" max="100">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="basic-addon2">%</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="col-md-2 removeColuna d-none text-center mt-2" data-toggle="tooltip" data-placement="top" title="Apagar Coluna" onclick="removerColuna(this)" style="cursor: pointer">
                                                <i class="fas fa-x text-danger"></i>
                                            </div>
                                            <div class="col-md-2 limparColuna d-none text-center mt-2" data-toggle="tooltip" data-placement="top" title="Limpar Coluna" onclick="limparColuna(this)" style="cursor: pointer">
                                                <i class="fas fa-eraser text-danger"></i>
                                            </div>
                                        </td> 
                                    </tr>
                                @else
                                    @for ($i = 0; $i < $arrayCheck; $i++)
                                        <tr class="trMelhoriasReformas">
                                            <td>
                                                <input type="number" class="form-control ano" id="melhorias_reformas_ano" name="melhorias_reformas_ano[]" value="{{ $melhorias_reformas->melhorias_reformas_ano[$i] ?? null }}" maxlength="4" onchange="validaAno(this)"  min="{{ $ativo_fisico->ano_aquisicao }}">
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">R$</span>
                                                    </div>
                                                    <input type="text" id="melhorias_reformas_valor{{ $i }}" name="melhorias_reformas_valor[]" class="form-control valor_rs" value="{{ $melhorias_reformas->melhorias_reformas_valor[$i] ?? null }}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" id="melhorias_reformas_operacao{{ $i }}" name="melhorias_reformas_operacao[]" value="{{ $melhorias_reformas->melhorias_reformas_operacao[$i] ?? null }}"  maxlength="3" min="0" max="100">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="basic-addon2">%</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" id="melhorias_reformas_man_planejada{{ $i }}" name="melhorias_reformas_man_planejada[]" value="{{ $melhorias_reformas->melhorias_reformas_man_planejada[$i] ?? null }}" maxlength="3" min="0" max="100">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="basic-addon2">%</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" id="melhorias_reformas_man_n_planejada{{ $i }}" name="melhorias_reformas_man_n_planejada[]" value="{{ $melhorias_reformas->melhorias_reformas_man_n_planejada[$i] ?? null }}" maxlength="3" min="0" max="100">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="basic-addon2">%</span>
                                                    </div>
                                                </div>
                                            </td>
                                            @if ($i == 0)
                                                <td>
                                                    <div class="col-md-2 removeColuna d-none text-center mt-2" data-toggle="tooltip" data-placement="top" title="Apagar Coluna" onclick="removerColuna(this)" style="cursor: pointer">
                                                        <i class="fas fa-x text-danger"></i>
                                                    </div>
                                                    <div class="col-md-2 limparColuna d-none text-center mt-2" data-toggle="tooltip" data-placement="top" title="Limpar Coluna" onclick="limparColuna(this)" style="cursor: pointer">
                                                        <i class="fas fa-eraser text-danger"></i>
                                                    </div>
                                                </td> 
                                            @else
                                                <td class="removeColuna" data-toggle="tooltip" data-placement="top" title="Apagar Coluna">
                                                    <div class="col-md-2 text-center mt-2" onclick="removerColuna(this)" style="cursor: pointer">
                                                        <i class="fas fa-x text-danger"></i>
                                                    </div>
                                                </td> 
                                                <td class="limparColuna d-none" data-toggle="tooltip" data-placement="top" title="Limpar Coluna">
                                                    <div class="col-md-2 text-center mt-2" onclick="limparColuna(this)" style="cursor: pointer">
                                                        <i class="fas fa-eraser text-danger"></i>
                                                    </div>
                                                </td> 
                                            @endif
                                        </tr>
                                    @endfor
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <hr>
                    </div>
                    <div class="col-6 pt-4">
                        <a type="button" class="btn btn-dark" href="{{ route('ativo_fisico.edit', [$capex->ativo_fisico_id, $capex->estudo_id]) }}">Voltar</a>
                        <button type="submit" class="btn btn-primary">Salvar e avançar</button>

                    </div>

                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section("js")
    <script>        
        $(document).ready(function() {
            var totalTr = $(".trMelhoriasReformas").length;

            if(totalTr == 1){
                $(".limparColuna").removeClass("d-none")
            }
        });

        function atualizarCAE()
        {
            var form = $('#formCapex');

            form.append('<input type="hidden" name="atualizar_cae" value="1">');
            
            form.submit();
        }

        function limparColuna(elemento)
        {
            $(elemento).closest('.trMelhoriasReformas').find('input').val('')
        }

        function validaAno(elemento)
        {
            var ano_aquisicao = {{ $ativo_fisico->ano_aquisicao }};
            var ano = $(elemento).val();

            if(ano < ano_aquisicao){
                dispararAlerta('Ano inserido menor que o ano da aquisição');
            }
        }

        function removerColuna(elemento)
        {
            $(elemento).closest('.trMelhoriasReformas').remove()

            if($('.trMelhoriasReformas').length == 1){
                $(".limparColuna:last").removeClass("d-none")

            }
        }

        function adicionarMelhoriasReformas()
        {
            if($('.trMelhoriasReformas:last').find('.valor_rs').val() == ""){
                dispararAlerta('Preencha o ano e o valor antes de adicionar novas linhas');
                return false;

            }else if($('.trMelhoriasReformas:last').find('.ano').val() == ""){
                dispararAlerta('Preencha o ano e o valor antes de adicionar novas linhas');
                return false;
            }
            
            $('.trMelhoriasReformas:last').clone().appendTo('#tbodyMelhoriasReformas');

            var inputs = $('.trMelhoriasReformas:last').find('input')
            $(inputs).each(function () {
                $(this).val('')
            })

            var input = $('.trMelhoriasReformas:last').find('.valor_rs');
            $(input).attr('onkeyup', 'atualizaValor(this)');
            $('.tdRemove:last').css("display", "")

            $('.trMelhoriasReformas:last').find('.ano').attr("required", "required")
            $('.trMelhoriasReformas:last').find('.valor_rs').attr("required", "required")

            if($('.trMelhoriasReformas').length >= 1){
                $(".removeColuna:last").removeClass("d-none")
                $(".limparColuna:last").addClass("d-none")
                $(".limparColuna:first").addClass("d-none")
            }
        }

        function atualizaValor(elemento)
        {            
            if($(elemento).val() != ''){
                var valorNovo = formata_moeda($(elemento).val(), 'pt-BR');

                $(elemento).val(valorNovo);

                console.log($(elemento).val());
            }            
        }
    </script>
@endsection