$(document).ready(function(){
    //ABRINDO BUSCA
    $('.busca_bt').on("click", function(){
        $('.busca_box').fadeToggle("fast");
    });

    //MOSTRA/ESCONDE SENHA
    $(".mostra_senha").click(function(){
        if($("#senha").attr("type") == "password"){
            $("#senha").prop("type","text")
        }else{
            $("#senha").prop("type","password")
        }
    })

    //FAZER SUMIR ALERT APÓS X SEGUNDOS
    //PARA MOSTRAR O ALERTA E NÃO SUMIR UTILIZE A CLASS ".errors_alert_fixed"
    function topShowAlerts(){
        $('.errors_alert').fadeOut("slow")
    }
    setTimeout(topShowAlerts, 5000);


    //VERIFICA SE HÁ ALGUM CAMPO PREENCHIDO PARA MOSTRAR UM CIRCULO VERDE NO BOTÃO DE BUSCA
    var campo_preenchido = false;
    $(".form-control").each(function() {
        if ($(this).val() !== "") {
            campo_preenchido = true;
            return false; // Se encontrar um campo preenchido, podemos sair do loop each
        }
    });
    if(campo_preenchido == true){
        $('.busca_realizada').fadeIn("fast");
    }
    

    //SHOW/HIDE LISTA EMPRESAS
    $("#nivel").on("change", function(){
        var nivel = $(this).children("option:selected").val();
        if(nivel == 2 || nivel == 3){
            $(".div_empresa").show();
        }else{
            $(".div_empresa").hide();
        }
    }).change();

    $("#regra_de_depreciacao").on("keyup", function(){
        var regra_de_depreciacao = $(this).val();
        var fator = 100;
        var resultado = 0;
        if(regra_de_depreciacao > 0){
            resultado = fator / $(this).val();
        }else{
            resultado = "";
        }
        resultado = formatarNumero(resultado);
        $("#anos_para_depreciar").val(resultado);
    });

    //CALCULO "VALOR DA DEPRECIAÇÃO" USADO
    $(".regra_taxa_depreciacao").on("keyup", function(){
        var valor_de_aquisicao = $("#valor_de_aquisicao").val();
        var regra_de_depreciacao = $("#regra_de_depreciacao").val();

        if(valor_de_aquisicao == 0 ||regra_de_depreciacao == ''){
            return $("#valor_da_depreciacao").val(0);
        }

        var novoValor = formata_moeda(valor_de_aquisicao, 'en-US');
        var valorAquisicaoFormatado = parseFloat(novoValor.replace(/[$,]/g, ''));

        var resultado = (parseInt(regra_de_depreciacao) / 100) * valorAquisicaoFormatado;
        
        var resultado_formatado = resultado.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
        resultado_formatado = resultado_formatado.replace("R$", "").trim();

        $("#valor_da_depreciacao").val(resultado_formatado);
    });

	$(".valor_rs").on("keyup", function(){
        if(this.value == ""){
            this.value = formata_moeda('0', 'pt-BR');

        }else{
            this.value = formata_moeda(this.value, 'pt-BR');

        }
	}).keyup();
});

//CALCULO "ANOS A DEPRECIAR" USADO EM CAPEX
function formatarNumero(numero) {
    if(numero == ""){
        return;
    }
    let numeroFormatado = numero.toFixed(2);
    return parseFloat(numeroFormatado).toString();
}

function formata_moeda(value, padrao) {
    value = value.replace('.', '').replace(',', '').replace(/\D/g, '')

    const options = { minimumFractionDigits: 2 }
    const result = new Intl.NumberFormat(padrao, options).format(
        parseFloat(value) / 100
    )

    return result;
}