@extends('layouts.default')

@section('content-auth')
<style type="text/css">
    .single-pricing {
        background: #fff;
        padding: 40px 20px;
        border-radius: 5px;
        position: relative;
        z-index: 2;
        border: 1px solid #eee;
        box-shadow: 0 10px 40px -10px rgba(0, 64, 128, .09);
        transition: 0.3s;
        margin-bottom: 25px;
    }

    @media only screen and (max-width:480px) {
        .single-pricing {
            margin-bottom: 30px;
        }
    }

    .single-pricing:hover {
        box-shadow: 0px 60px 60px rgba(0, 0, 0, 0.1);
        z-index: 100;
        transform: translate(0, -10px);
    }

    .price-label {
        color: #fff;
        background: #efaa25;
        font-size: 16px;
        width: 100px;
        margin-bottom: 15px;
        display: block;
        -webkit-clip-path: polygon(100% 0%, 90% 50%, 100% 100%, 0% 100%, 0 50%, 0% 0%);
        clip-path: polygon(100% 0%, 90% 50%, 100% 100%, 0% 100%, 0 50%, 0% 0%);
        margin-left: -20px;
        position: absolute;
    }

    .price-head h2 {
        font-weight: 600;
        margin-bottom: 0px;
        text-transform: capitalize;
        font-size: 26px;
    }

    .price-head span {
        display: inline-block;
        background: #efaa25;
        width: 6px;
        height: 6px;
        border-radius: 30px;
        margin-bottom: 20px;
        margin-top: 15px;
    }

    .price {
        font-weight: 500;
        font-size: 35px;
        margin-bottom: 0px;
    }

    .single-pricing h5 {
        font-size: 14px;
        margin-bottom: 0px;
        text-transform: uppercase;
    }

    .single-pricing ul {
        list-style: none;
        margin-bottom: 20px;
        margin-top: 30px;
    }

    .single-pricing ul li {
        line-height: 35px;
    }

    .single-pricing a:hover,
    .single-pricing a:focus {
        background: #efaa25;
        color: #fff;
        border: 2px solid #efaa25;
    }

    .single-pricing-white {
        background: #232434
    }

    .single-pricing-white ul li {
        color: #fff;
    }

    .single-pricing-white h2 {
        color: #fff;
    }

    .single-pricing-white h1 {
        color: #fff;
    }

    .single-pricing-white h5 {
        color: #fff;
    }

</style>
<?php 
$creditos_disponiveis = Auth::user()->credito_empresa->last()->total_creditos_disponiveis ?? 0;

if($creditos_disponiveis == 0){
    $creditos_class = "alert-danger";
    $creditos_style = "border: 1px solid red; border-radius:5px;";
}else{
    $creditos_class = "alert-success";
    $creditos_style = "border: 1px solid green; border-radius:5px;";
}
?>
<div class="container-fluid">
    <div class="row">
        {{-- Area do adm --}}
        @if ($mode_view == 'adm')
            <div class="col-md-12">
                <div class="d-sm-flex mb-4">
                    <a href="{{ route('credito.create') }}" class="btn btn-sm btn-primary shadow-sm">
                        <i class="fas fa-plus fa-sm text-white-50"></i> Adicionar Créditos
                    </a>
                </div>
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Quantidade de estudo</th>
                                    <th>Valor</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($creditos as $credito)
                                    <tr>
                                        <td>{{ $credito->qtd_estudos }}</td>
                                        <td>{{ "R$ " . number_format($credito->valor, 2,",",".") }}</td>
                                        <td>
                                            <a href="{{ route("credito.edit", $credito->id) }}" class="btn btn-warning btn-circle btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- Paginação --}}
                        <div class="container text-center paginacao_espacamento">
                            <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
                                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                    <div>
                                        <p class="text-sm text-gray-700 leading-5">
                                            Total
                                            <span class="font-medium">{{ $creditos->total() }}</span>
                                            resultados
                                        </p>
                                    </div>
                                    @if ($creditos->hasPages())
                                        <div>
                                            <span class="relative z-0 inline-flex">
                                                @if ($creditos->lastPage() > 1)
                                                    <span aria-disabled="true" aria-label="&amp;laquo; Previous">
                                                        <a href="{{ $creditos->url($creditos->currentPage() - 1) }}" aria-hidden="true" class="paginacao_bt {{ ($creditos->currentPage() == 1) ? ' paginacao_bt_disabled' : '' }}">
                                                            <svg 0="" 10="" 25="" style="max-height:25px;" fill="currentColor" viewBox="5 0 10 22">
                                                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                            </svg>
                                                        </a>
                                                    </span>
                                                    @for ($i = 1; $i <= $creditos->lastPage(); $i++)
                                                        @if ($creditos->currentPage() == $i)
                                                            <span aria-current="page" class="paginacao_bt paginacao_bt_active">
                                                                <span class="">{{ $i }}</span>
                                                            </span>
                                                        @else
                                                            <a href="{{ $creditos->url($i) }}" aria-label="Go to page {{ $i }}" class="paginacao_bt">
                                                                {{ $i }}
                                                            </a>
                                                        @endif
                                                    @endfor
                                                    <a href="{{ ($creditos->currentPage() == $creditos->lastPage()) ? '' : $creditos->url($creditos->currentPage() + 1) }}"  rel="next" aria-label="Next &amp;raquo;" class="paginacao_bt {{ ($creditos->currentPage() == $creditos->lastPage()) ? ' paginacao_bt_disabled' : '' }}">
                                                        <svg 0="" 10="" 25="" style="max-height:25px;" fill="currentColor" viewBox="5 0 10 22">
                                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    </a>
                                                @endif                                       
                                            </span>
                                        </div>
                                    @endif    
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Area do usuario --}}
        @if ($mode_view == 'user')
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-body <?=$creditos_class?>" style="<?=$creditos_style?>">    
                        <h4>Créditos disponíveis para estudo: <b>{{ $creditos_disponiveis }}</b></h4>
                    </div>
                </div>
                <div class="card shadow mb-4">
                    <div class="card-body table-responsive">     
                        <div id="snippetContent">
                            <section id="pricing" class="pricing-content section-padding">
                                <div class="container">
                                    <div class="section-title text-center">
                                        <p>
                                            Escolha abaixo o pacote de estudos que mais lhe atenda.<br>
                                            O pacote escolhido será somado à quantidade de créditos atual.
                                        </p>
                                    </div>
                                    <div class="row text-center">
                                        @foreach ($creditos as $credito)
                                            <div class="col-lg-3 col-sm-4 col-xs-4 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.1s" data-wow-offset="0">
                                                <div class="single-pricing">
                                                    <div class="price-head">
                                                        <h2>
                                                            @if ($credito->qtd_estudos > 1)
                                                                {{ $credito->qtd_estudos . ' estudos' }}

                                                            @else
                                                                {{ $credito->qtd_estudos . ' estudo' }}

                                                            @endif
                                                        </h2>
                                                        <hr>
                                                    </div>
                                                    <h1 class="price">
                                                        {{ "R$ " . number_format($credito->valor, 2,",",".") }}
                                                    </h1>
                                                    <br>
                                                    <button onclick="validarCreditos({{ $credito->id }})" class="btn btn-primary">Adquirir</button>
                                                </div>
                                            </div>    
                                        @endforeach    
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>    
            <div class="modal fade" id="modalComprarCréditos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content" style="border-radius: 20px">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Compra de créditos</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                        <style>
                            .card-panel{
                                background-color: white;
                                box-shadow: 0px 1px 4px 0px rgba(0, 0, 0, 0.24), 0px 2px 8px 2px rgba(0, 0, 0, 0.08);
                                padding: 24px;
                                border-radius: 16px;
                                cursor: pointer;
                            }
                            .card-panel>span{
                                font-size: 16px
                            }
                            .m-l-15{
                                margin-left: 15px;
                            }
                            .m-r-15{
                                margin-right: 15px;
                            }
                            .m-b-15{
                                margin-bottom: 15px;
                            }
                            .icon-pagamentos{
                                padding: 10px;
                                border: 1px solid gainsboro;
                                border-radius: 100px;
                                margin-right: 15px;
                                font-size: 20px;
                            }
                            .error {
                                color: red;
                                margin-top: 10px;
                                display: none;
                            }
                            .success {
                                color: green;
                                margin-top: 10px;
                                display: none;
                            }
                            .error-2 {
                                color: red;
                                margin-top: 10px;
                                font-size: 12px!important;
                                display: none;
                            }
                            .success-2 {
                                color: green;
                                margin-top: 10px;
                                display: none;
                                font-size: 12px!important;
                            }
                            .m-b-10{
                                margin-bottom: 10px
                            }
                            .fas:hover{
                                background-color: #031831;
                                color: white!important
                            }
                        </style>
                      {{-- Div metodo de pagamento  --}}
                      <div class="row" id="divSelecaoPagamentos" style="display: none">
                        <div class="col-md-12 m-b-15">
                            <h5>
                                Selecione o meio de pagamento:
                            </h5>
                        </div>
                        <div class="col-md-4 card-panel m-l-15 m-r-15">
                            <input type="hidden" value="boleto">
                            <i class="fas fa-barcode icon-pagamentos"></i>
                            <span>Boleto</span>
                        </div>
                        <div class="col-md-4 card-panel">
                            <input type="hidden" value="credito">
                            <i class="fas fa-credit-card icon-pagamentos"></i>
                            <span>Cartão de crédito</span>
                        </div>
                      </div>

                      {{-- Div Dados cartão de credito --}}
                      <div class="row" id="divPagamentoCredito">
                        <div class="col-md-12" id="divErroPagamento" style="display:none">
                            <div class="alert alert-danger">
                                Não é possível dar continuidade com o pagamento, verifique os dados inserido e tente novamente!
                            </div>
                        </div>
                        <div class="col-md-12">
                            <i class="fas fa-arrow-left d-none" onclick="voltarPasso(1)" style="padding: 10px;border: 1px solid gainsboro;border-radius: 100px;margin-right: 5px;color: #031831;cursor:pointer"></i>
                            <h5 style="display: contents">
                                Preencha os dados do cartão de crédito:
                            </h5>
                            <hr>
                        </div>
                        <div class="col-md-6 m-b-10">
                            <label>Número do cartão</label>
                            <input type="text" class="form-control dados-cartao" id="numero-cartao-credito" maxlength="19" placeholder="0000 0000 0000 0000">
                        </div>
                        <div class="col-md-6 m-b-10">
                            <label>Nome completo</label>
                            <input type="text" class="form-control dados-cartao" id="nome-cartao-credito" placeholder="Conforme aparece no cartão">
                        </div>
                        <div class="col-md-4">
                            <label>Data de vencimento</label>
                            <input type="text" data-error="false" class="form-control dados-cartao" id="vencimento-cartao-credito" maxlength="5" placeholder="Mês/Ano">
                            <div class="error-2" id="error-msg">Data de vencimento inválida ou já expirada.</div>
                        </div>
                        <div class="col-md-4">
                            <label>Código de segurança</label>
                            <input type="text" class="form-control dados-cartao" id="codigo-cartao-credito" maxlength="3" placeholder="CVV">
                        </div>
                        <div class="col-md-4">
                            <label>CPF/CNPJ do titular</label>
                            <input type="text" data-error="false" class="form-control dados-cartao" id="cpf-cartao-credito" maxlength="18" placeholder="0000.0000.0000-00">
                            <div class="error-2" id="error-msg-cpf">CPF/CNPJ inválido.</div>
                        </div>
                        <div class="col-md-12">
                            <hr>
                            <button class="btn btn-success" onclick="efetuarPagamento()">Pagar</button>
                        </div>
                      </div>

                      {{-- Div Boleto --}}
                      <div class="row" id="divPagamentoBoleto" style="display:none">
                        <div class="col-md-12">

                        </div>
                        <div class="col-md-12">
                            <i class="fas fa-arrow-left" onclick="voltarPasso(1)" style="padding: 10px;border: 1px solid gainsboro;border-radius: 100px;margin-right: 5px;color: #031831;cursor:pointer"></i>
                            <h5 style="display: contents">
                                Pagamento por boleto:
                            </h5>
                            <hr>
                            <i><b>Metódo de pagamento não disponível...</b></i>
                        </div>
                      </div>

                      {{-- Div form pagamento --}}
                      <div class="row d-none">
                        <form action="{{ route('pedido.pagamento') }}" id="formHelper" method="post">
                            <input type="hidden" id="public-key" name='public-key' value={{ $key }}>
                            <input type="hidden" id="encrypted-card" name="encrypted-card">

                        </form>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                      <button type="button" class="btn btn-success d-none" id="btnContratacaoCreditos" onclick=contratacaoCreditosNovo(1) disabled>Continuar</button>
                    </div>
                  </div>
                </div>
            </div> 

            <div class="modal fade" id="modalCreditosExistentes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content" style="border-radius: 20px">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Atenção!</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" id="creditoIdHelper">

                            <div class="alert alert-warning">
                                Você possui um total de <b>{{ $creditos_disponiveis }}</b> créditos disponíveis para uso. <br>
                                <b>Deseja realmente adquirir novos créditos ?</b>
                            </div>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                      <button type="button" class="btn btn-success" onclick="continuarContratacaoCreditos()">Continuar</button>
                    </div>
                  </div>
                </div>
            </div>      
        @endif
    </div>
</div>
@endsection

@section("js")
    <script src="https://assets.pagseguro.com.br/checkout-sdk-js/rc/dist/browser/pagseguro.min.js"></script>

    <script>
        let creditosDisponiveis = {{ $creditos_disponiveis }};

        $(document).ready(function(){
            $('#numero-cartao-credito').on('input', function() {
                var input = $(this).val();
                
                input = input.replace(/\D/g, '');

                input = input.replace(/(\d{4})(?=\d)/g, '$1 ');

                $(this).val(input);
            });

            $('#vencimento-cartao-credito').on('input', function(e) {
                var input = $(this).val();
                
                input = input.replace(/\D/g, '');
                
                if (input.length >= 2) {
                    input = input.substring(0, 2) + '/' + input.substring(2, 4);
                }

                $(this).val(input);
            });

            $('#vencimento-cartao-credito').on('blur', function() {
                var validade = $(this).val();

                if (/^(0[1-9]|1[0-2])\/\d{2}$/.test(validade)) {
                    if (validarDataVencimento(validade)) {
                        $('#error-msg').hide();
                        $(this).attr('data-error', false);
                    } else {
                        $('#error-msg').text('Data de vencimento inválida ou já expirada.').show();
                        $('#success-msg').hide();
                        $(this).attr('data-error', true);
                    }
                } else {
                    $('#error-msg').text('Formato inválido. Use MM/AA.').show();
                    $('#success-msg').hide();
                    $(this).attr('data-error', true);
                }
            });

            $(".card-panel").on("click", function(){
                $(".card-panel").css({
                    "background-color" : "white",
                    "color": "black"
                });

                $(this).css({
                    "background-color" : "#031831",
                    "color": "white"
                })

                $(".metodo_pagamento").remove();

                $('<input>').attr({
                    class: "metodo_pagamento",
                    type: 'hidden',
                    name: 'forma_pagamento',
                    value: $(this).find("input").val()
                }).appendTo($("#formHelper"));


                $("#btnContratacaoCreditos").removeAttr("disabled");
            })

            $('#cpf-cartao-credito').on('input', function() {
                var input = $(this).val();

                input = input.replace(/\D/g, '');

                if (input.length <= 11) {
                    input = input.replace(/(\d{3})(\d)/, '$1.$2');
                    input = input.replace(/(\d{3})(\d)/, '$1.$2');
                    input = input.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
                } else {
                    input = input.replace(/^(\d{2})(\d)/, '$1.$2');
                    input = input.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
                    input = input.replace(/\.(\d{3})(\d)/, '.$1/$2');
                    input = input.replace(/(\d{4})(\d{1,2})$/, '$1-$2');
                }

                $(this).val(input);
            });

            $('#cpf-cartao-credito').on('blur', function() {
                var cpf = $(this).val();

                cpf = cpf.replace(/[^\d]+/g,'');

                if (!validarCPFouCNPJ(cpf)) {
                    $('#error-msg-cpf').show();
                    $(this).attr('data-error', true);

                }else{
                    $('#error-msg-cpf').hide();
                    $(this).attr('data-error', false);

                }
            });
        });

        function efetuarPagamento()
        {
            setTimeout(function() {
                $("#divErroPagamento").hide();
            }, 10000); 

            if($("#vencimento-cartao-credito").attr('data-error') == 'true' || $("#cpf-cartao-credito").attr('data-error') == 'true'){
                $("#divErroPagamento").show();
                return
            }

            $("#divErroPagamento").hide();

            var nomeCartao = $("#nome-cartao-credito").val();
            var numeroCartao = $("#numero-cartao-credito").val().replace(/\s+/g, '');
            var dataExpiracaoCartao = $("#vencimento-cartao-credito").val().split("/")[0];
            var anoExpiracaoCartao = 20 + $("#vencimento-cartao-credito").val().split("/")[1];
            var cvcCartao = $("#codigo-cartao-credito").val();
            var cpfCartao = $("#cpf-cartao-credito").val()

            let card = criptografarCartao(nomeCartao, numeroCartao, dataExpiracaoCartao, anoExpiracaoCartao, cvcCartao);

            if(card.hasErrors){
                $("#divErroPagamento").show();
                return
            }

            let encryptedCard = card.encryptedCard;

            $("#encrypted-card").val(encryptedCard);

            $('<input>').attr({type: 'hidden',name: 'nomeCartao',value: nomeCartao}).appendTo($("#formHelper"));
            $('<input>').attr({type: 'hidden',name: 'numeroCartao',value: numeroCartao}).appendTo($("#formHelper"));
            $('<input>').attr({type: 'hidden',name: 'dataExpiracaoCartao',value: dataExpiracaoCartao}).appendTo($("#formHelper"));
            $('<input>').attr({type: 'hidden',name: 'anoExpiracaoCartao',value: anoExpiracaoCartao}).appendTo($("#formHelper"));
            $('<input>').attr({type: 'hidden',name: 'cvcCartao',value: cvcCartao}).appendTo($("#formHelper"));
            $('<input>').attr({type: 'hidden',name: '_token',value: '{{ csrf_token() }}'}).appendTo($("#formHelper"));
            $('<input>').attr({type: 'hidden',name: 'cpfCartao',value: cpfCartao}).appendTo($("#formHelper"));
            $('<input>').attr({type: 'hidden',name: 'credito_id',value: $("#creditoIdHelper").val()}).appendTo($("#formHelper"));

            $("#formHelper").submit();
        }

        function criptografarCartao(nomeCartao, numeroCartao, dataExpiracaoCartao, anoExpiracaoCartao, cvcCartao)
        {
            const card = PagSeguro.encryptCard({
                publicKey: $("#public-key").val(),
                holder: nomeCartao,
                number: numeroCartao,
                expMonth: dataExpiracaoCartao,
                expYear: anoExpiracaoCartao,
                securityCode: cvcCartao
            });

            return card;
        }

        function voltarPasso(passo)
        {
            if(passo == 1){
                $(".dados-cartao").val('').trigger("change");

                $("#btnContratacaoCreditos").removeAttr("disabled");

                $("#btnContratacaoCreditos").attr({
                    "onclick": "contratacaoCreditosNovo(1)",
                });

                $("#divPagamentoBoleto").css("display", "none");

                $("#divPagamentoCredito").css("display", "none");

                $("#divSelecaoPagamentos").fadeIn();
            }
        }

        function validarCPFouCNPJ(valor) {
            valor = valor.replace(/[^\d]+/g, '');

            if (valor.length === 11) {
                // Validação de CPF
                if (
                    valor === "00000000000" || 
                    valor === "11111111111" || 
                    valor === "22222222222" || 
                    valor === "33333333333" || 
                    valor === "44444444444" || 
                    valor === "55555555555" || 
                    valor === "66666666666" || 
                    valor === "77777777777" || 
                    valor === "88888888888" || 
                    valor === "99999999999"
                ) {
                    return false;
                }

                var soma = 0;
                var resto;

                for (var i = 1; i <= 9; i++) {
                    soma += parseInt(valor.substring(i - 1, i)) * (11 - i);
                }
                resto = (soma * 10) % 11;

                if (resto === 10 || resto === 11) resto = 0;
                if (resto !== parseInt(valor.substring(9, 10))) return false;

                soma = 0;
                for (var i = 1; i <= 10; i++) {
                    soma += parseInt(valor.substring(i - 1, i)) * (12 - i);
                }
                resto = (soma * 10) % 11;

                if (resto === 10 || resto === 11) resto = 0;
                if (resto !== parseInt(valor.substring(10, 11))) return false;

                return true;

            } else if (valor.length === 14) {
                // Validação de CNPJ
                var tamanho = valor.length - 2;
                var numeros = valor.substring(0, tamanho);
                var digitos = valor.substring(tamanho);
                var soma = 0;
                var pos = tamanho - 7;

                for (var i = tamanho; i >= 1; i--) {
                    soma += numeros.charAt(tamanho - i) * pos--;
                    if (pos < 2) pos = 9;
                }

                var resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
                if (resultado !== parseInt(digitos.charAt(0))) return false;

                tamanho++;
                numeros = valor.substring(0, tamanho);
                soma = 0;
                pos = tamanho - 7;

                for (var i = tamanho; i >= 1; i--) {
                    soma += numeros.charAt(tamanho - i) * pos--;
                    if (pos < 2) pos = 9;
                }

                resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
                if (resultado !== parseInt(digitos.charAt(1))) return false;

                return true;
            }

            return false;
        }

        function validarDataVencimento(expiracao) {
            var dataAtual = new Date();
            var mesAtual = dataAtual.getMonth() + 1;
            var anoAtual = dataAtual.getFullYear() % 100;

            var partes = expiracao.split('/');
            var mes = parseInt(partes[0], 10);
            var ano = parseInt(partes[1], 10);

            if (isNaN(mes) || isNaN(ano) || mes < 1 || mes > 12 || partes[1].length !== 2) {
                return false;
            }

            if (ano > anoAtual || (ano === anoAtual && mes >= mesAtual)) {
                return true;
            } else {
                return false; 
            }
        }

        function contratacaoCreditosNovo(passos)
        {
            if(passos == 1){
                $("#btnContratacaoCreditos").attr({
                    "onclick": "contratacaoCreditosNovo(2)",
                    "disabled": "disabled"
                });

                $("#divSelecaoPagamentos").css("display", "none");

                if($(".metodo_pagamento").val() == 'credito'){
                    $("#divPagamentoCredito").fadeIn();

                }else{
                    $("#divPagamentoBoleto").fadeIn();

                }
            }
        }

        function continuarContratacaoCreditos()
        {
            $("#modalCreditosExistentes").modal("hide");
            $("#modalComprarCréditos").modal("show");
        }

        function validarCreditos(creditoID)
        {
            $("#creditoIdHelper").val(creditoID);

            if(creditosDisponiveis >= 1){
                $("#modalCreditosExistentes").modal("show");

            }else{
                // Abrir modal para pagamento do pagseguro
                $("#modalComprarCréditos").modal("show");
            }
        }
    </script>
@endsection
