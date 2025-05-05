@extends('layouts.default')

@section('content-auth')
<div class="container-fluid">
    @include('layouts.time_line_estudos')

    <div class="card">
        <div class="card-body">
            <form class="g-3" action="{{ route('ativo_fisico.update', $ativo_fisico->id) }}" method="post">
                @csrf

                <input type="hidden" name="estudo_id" value="{{ $estudo->id }}">
                <input type="hidden" name="capex_id" value="{{ $capex->id }}">

                <div class="row">
                    <div class="col-md-12">
                        <label for="setor_tag" class="form-label">Setor/TAG (local de instalação):</label>
                        <input type="text" class="form-control" id="setor_tag" name="setor_tag" value="{{ $ativo_fisico->setor_tag }}" required {{ ($capex->estudo->custo_anual_equivalente != null) ? "disabled" : "" }}>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="nome_ativo" class="form-label">Nome do Ativo Físico:</label>
                        <input type="text" class="form-control" id="nome_ativo" name="nome_ativo" value="{{ $ativo_fisico->nome_ativo }}" maxlength="200" required {{ ($capex->estudo->custo_anual_equivalente != null) ? "disabled" : "" }}>
                    </div>
                    <div class="col-md-3">
                        <label for="cod_ativo_fisico" class="form-label">Código do Ativo Físico:</label>
                        <input type="text" class="form-control" id="cod_ativo_fisico" name="cod_ativo_fisico" value="{{ $ativo_fisico->cod_ativo_fisico }}" maxlength="18" required {{ ($capex->estudo->custo_anual_equivalente != null) ? "disabled" : "" }}>
                    </div>
                    <div class="col-md-3">
                        <label for="ano_inicio_operacao" class="form-label">Ano da aquisição:</label>
                        <input type="number" class="form-control" id="ano_inicio_operacao" name="ano_inicio_operacao" value="{{ $ativo_fisico->ano_inicio_operacao }}" maxlength="4" min="1900" max="<?= date("Y") ?>" required {{ ($capex->estudo->custo_anual_equivalente != null) ? "disabled" : "" }}>
                    </div>
                    <div class="col-md-4">
                        <label for="expectativa_vida" class="form-label">Expectativa de Vida Econômica (fabricante):</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="expectativa_vida" name="expectativa_vida" value="{{ $ativo_fisico->expectativa_vida }}" maxlength="3" min="0" max="999" {{ ($capex->estudo->custo_anual_equivalente != null) ? "disabled" : "" }}>
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">anos</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label for="regra_depreciacao" class="form-label">Taxa de depreciação:</label>
                        <div class="input-group">
                            <input type="number" class="form-control regra_taxa_depreciacao" id="regra_de_depreciacao" name="regra_depreciacao" value="{{ $ativo_fisico->regra_depreciacao }}" maxlength="3" min="0" max="100" required {{ ($capex->estudo->custo_anual_equivalente != null) ? "disabled" : "" }}>
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">%</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="anos_para_depreciar" class="form-label">Anos para depreciar:</label>
                        <input type="text" class="form-control" id="anos_para_depreciar" name="anos_depreciar" value="{{ $ativo_fisico->anos_depreciar }}" readonly>
                    </div>
                    <div class="col-md-3">
                        <label for="taxa_perda_ano" class="form-label">Taxa de perda de valor ao ano:</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="taxa_perda_ano" name="taxa_perda_ano" value="{{ $ativo_fisico->taxa_perda_ano }}" maxlength="3" min="0" max="100" required {{ ($capex->estudo->custo_anual_equivalente != null) ? "disabled" : "" }}>
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">%</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <hr class="hr">
                    </div>
                </div>    
                <div class="row">
                    <div class="col-md-3">
                        <label for="ano_aquisicao" class="form-label">Ano do Início da Operação:</label>
                        <input type="number" class="form-control" id="ano_aquisicao" name="ano_aquisicao" value="{{ $ativo_fisico->ano_aquisicao }}" maxlength="4" min="1900" max="<?= date("Y") ?>" required {{ ($capex->estudo->custo_anual_equivalente != null) ? "disabled" : "" }}>
                    </div>
                    <div class="col-md-3">
                        <label for="ano_estudo" class="form-label">Ano do estudo:</label>
                        <input type="number" class="form-control" id="ano_estudo" name="ano_estudo" value="{{ date("Y", strtotime($estudo->created_at)) }}" disabled {{ ($capex->estudo->custo_anual_equivalente != null) ? "disabled" : "" }}>
                    </div>
                    <div class="col-md-3">
                        <label for="tma" class="form-label">TMA - Taxa mínima de atratividade::</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="tma" name="tma" value="{{ $estudo->tma }}" step=".01" min="1" max="100" required {{ ($capex->estudo->custo_anual_equivalente != null) ? "disabled" : "" }}>
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">%</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="aliquota" class="form-label">Alíquota do Imposto de Renda:</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="aliquota" name="aliquota" value="{{ $aliquota_empresa }}" maxlength="3" min="0" max="100" required {{ ($capex->estudo->custo_anual_equivalente != null) ? "disabled" : "" }}>
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">%</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="motivo_escolha_ativo_fisico" class="form-label">Motivo da escolha do Ativo Físico:</label>
                        <input class="form-control" id="motivo_escolha_ativo_fisico" name="motivo_escolha_ativo_fisico" rows="6" value="{{ $capex->motivo_escolha_ativo_fisico }}" {{ ($capex->estudo->custo_anual_equivalente != null) ? "disabled" : "" }}>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 pt-4">
                        @if ($estudo->custo_anual_equivalente != null)
                            <a href="{{ route('capex.edit', $estudo->capex_id) }}" class="btn btn-primary">Avançar</a>

                        @else
                            <button type="submit" class="btn btn-primary">Salvar e avançar</button>

                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection