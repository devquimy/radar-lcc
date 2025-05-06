<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Desenvolvido por <a href="https://www.bmasolucoesdigitais.com.br" target="_blank">BMA Soluções Digitais</a></span>
        </div>
    </div>
</footer>
<script src="{{ asset('./js/jquery.min.js') }}"></script>
<script src="{{ asset('./js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('./js/jquery.easing.min.js') }}"></script>
<script src="{{ asset('./js/sb-admin-2.min.js') }}"></script>
<script src="{{ asset('./js/Chart.min.js') }}"></script>
<script src="{{ asset('./js/chart-area-demo.js') }}"></script>
<script src="{{ asset('./js/chart-pie-demo.js') }}"></script>
<script src="{{ asset('./js/jquery.maskedinput.min.js') }}"></script>
<script src="{{ asset('./js/jquery.mask.min.js') }}"></script>
<script src="{{ asset('./js/mask.js') }}"></script>
<script src="{{ asset('./js/custom.js') }}"></script>
<script src="{{ asset('./js/flash.min.js') }}"></script>

<script>
    // Adiciona a classe "toggled" antes do DOM ser completamente carregado
    if (window.innerWidth <= 769) {
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('.navbar-nav').classList.add('toggled');
        });
    }

    $(function () {
        $('[data-toggle="tooltip"]').tooltip();

        $("#btnCardCurva").on('click', function (){
           if($(this).attr("href") == "#"){
                dispararAlerta("Não é possível acessar o C.A.E sem definir os valores de Capex e Opex");
           }
        })

        $("#btnCardRelatorio").on('click', function (){
           if($(this).attr("href") == "#"){
                dispararAlerta('Relatório ainda não gerado. Favor concluir o estudo e clicar em "Gerar Relatório" ');
           }
        })
    })

    function dispararAlerta(msg)
    {
        return window.FlashMessage.info(msg, {
            progress: true,
            interactive: true,
            timeout: 5000,
            appear_delay: 200,
            container: '.flash-container',
            theme: 'default',
            classes: {
                container: 'flash-container',
                flash: 'flash-message',
                visible: 'is-visible',
                progress: 'flash-progress',
                progress_hidden: 'is-hidden'
            }
        });
    }
</script>

@hasSection('content-auth')
    @yield('js')
@endif