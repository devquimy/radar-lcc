$(document).ready(function(){

	setTimeout(
		function(){
			$(".data").mask("99/99/9999");
			$(".cep").mask("99999-999");
			$('.cnpj').mask('99.999.999/9999-99');
			$(".data_mes_ano").mask("99/9999");
			$(".hora").mask("99:99");

			$('.cpf').mask('999.999.999-99');
			$('.fabricacao_modelo').mask('9999/9999');
			$('.celular').mask('(99) 99999-9999');
			$('.telefone').mask('(99) 9999-9999');
			
			$('telefone_fixo_ou_celular').on( 'input', function() {
				var number = $(this).val().replace(/[^\d]/g, '');
				if (number.length <= 8) {
					number = number.replace(/(\d{4})(\d{4})/, '$1-$2');
				} else {
					number = number.replace(/(\d{5})(\d{4})/, '$1-$2');
				}
				$(this).val(number);
			});

			$(function() {
				$(".data").datepicker({
					dateFormat: 'dd/mm/yy',
					dayNames: ['Domingo','Segunda','Ter&ccedila','Quarta','Quinta','Sexta','S&aacute;bado'],
					dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
					dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','S&aacute;b','Dom'],
					monthNames: ['Janeiro','Fevereiro','Mar&ccedilo','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
					monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
					nextText: 'Pr&oacute;ximo',
					prevText: 'Anterior'
				});
			});
		}
	, 500);
    
});
