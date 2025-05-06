

@extends('layouts.default')

@section('content')
<?php 
if(Auth::check()){
    echo "<script>window.location.href = '" . url('/ativos_fisicos') . "'</script>";
}
?>
<body style="background-image: url({{ asset('/img/fundo_login.jpg') }}); background-position: bottom;">
    <div class="container">
        <div class="d-flex justify-content-center h-100">
            <div class="card card-registro">
                <div class="card-header">
                    <h3>Radar LCC</h3>
                </div>
                <form class="user" action="{{ route('register.create') }}" method="POST">
                    @csrf

                    <div class="card-body">
                        @include('layouts.flash-message')

                        <p class="text-white">
                            Registre-se abaixo gratuitamente para ter acesso aos recursos do <b>Radar LCC</b>
                        </p>
                        <div class="row pt-2">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="nome">Nome completo</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="nome">Razão social</label>
                                    <input type="text" name="razao_social" class="form-control" value="{{ old('razao_social') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="nome">CNPJ</label>
                                    <input type="text" name="cnpj" class="form-control cnpj" id="cnpj" onchange="validarCNPJ(this.value)" value="{{ old('cnpj') }}" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="nome">E-mail</label>
                                    <input type="text" name="email" class="form-control" value="{{ old('email') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="nome">Senha 
                                        <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="Minímo 8 caracteres"></i>
                                    </label>
                                    <input type="password" name="password" class="form-control" value="" required>
                                </div>
                                <div class="form-group">
                                    <label for="nome">Confirme sua senha</label>
                                    <input type="password" name="password_confirmation" class="form-control" value="" required>
                                </div>
                            </div>
                            <div class="col pt-3">
                                <input type="checkbox" name="aceito_termos"> Lí e aceito os <span style="font-weight:bold;cursor: pointer;color:#ffc310;text-decoration: underline;" data-toggle="modal" data-target="#termosModal">termos de uso</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-8 pt-2">
                                <a href="{{ route('login') }}" style="color:white; text-decoration: none;">Já tenho cadastro</a>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <input type="submit" value="Cadastrar" class="btn float-right login_btn">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="termosModal" tabindex="-1" aria-labelledby="termosModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="termosModalLabel"><b>Termos de Uso para o Sistema “Radar LCC”</b></h5>
                </div>
                <div class="modal-body" style="margin:15px;height:380px;overflow:auto">
                    <h5>
                        <b>1. Aceitação dos Termos</b>
                    </h5>
                    <p style="text-align: justify;">
                        1.1. Ao se cadastrar neste sistema, você concorda em cumprir e respeitar os termos e
                        condições aqui descritos. Caso não concorde com algum termo, não prossiga com o
                        cadastro.
                    </p>
                    <h5>
                        <b>2. Cadastro e Segurança</b>
                    </h5>
                    <p style="text-align: justify;">
                        2.1. Você é responsável por fornecer informações verdadeiras, completas e atualizadas
                        durante o processo de cadastro. <br>
                        2.2. O uso de dados de terceiros sem autorização é estritamente proibido e pode
                        acarretar na suspensão ou exclusão do cadastro.<br>
                        2.3. É sua responsabilidade proteger suas credenciais de acesso ao sistema. Não
                        compartilhe sua senha com terceiros.
                    </p>
                    <h5>
                        <b>3. Uso do Sistema</b>
                    </h5>
                    <p style="text-align: justify;">
                        3.1. O sistema deve ser utilizado exclusivamente para finalidades relacionadas aos
                        estudos dos Custos do Ciclo de Vida dos Ativos Físicos, conforme suas funcionalidades
                        e regras estabelecidas. <br>
                        3.2. É proibido qualquer uso que viole leis, regulamentos ou direitos de terceiros.
                    </p>
                    <h5>
                        <b>4. Propriedade Intelectual</b>
                    </h5>
                    <p style="text-align: justify;">
                        4.1. Todo o conteúdo, design, código-fonte e funcionalidades do sistema são protegidos por
                        direitos autorais e pertencem exclusivamente ao proprietário do sistema. Qualquer uso
                        indevido ou reprodução não autorizada está sujeito a sanções legais.
                    </p>
                    <h5>
                        <b>5. Coleta e Uso de Dados</b>
                    </h5>
                    <p style="text-align: justify;">
                        5.1. Os dados fornecidos durante o cadastro serão utilizados exclusivamente para fins
                        de gerenciamento do sistema e comunicação com o usuário. <br>
                        5.2. A privacidade e a proteção dos dados seguem a legislação vigente sobre proteção
                        de dados pessoais (LGPD), através da lei 13.709 de 14 de agosto de 2018.
                    </p>
                    <h5>
                        <b>6. Limitação de Responsabilidade</b>
                    </h5>
                    <p style="text-align: justify;">
                        6.1. O sistema é fornecido "como está", e o proprietário não se responsabiliza por eventuais 
                        falhas, interrupções ou perdas de dados decorrentes do uso do sistema.
                    </p>
                    <h5>
                        <b>7. Cancelamento e Encerramento de Conta</b>
                    </h5>
                    <p style="text-align: justify;">
                        7.1. O sistema se reserva o direito de encerrar ou suspender o acesso de usuários que
                        violem os termos de uso, sem aviso prévio.
                    </p>
                    <h5>
                        <b>8. Foro e Legislação Aplicável</b>
                    </h5>
                    <p style="text-align: justify;">
                        8.1. Estes termos serão regidos e interpretados de acordo com as leis do Brasil. Quaisquer
                        disputas serão resolvidas no foro da comarca do proprietário do sistema, salvo
                        disposição em contrário na legislação aplicável.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
</body>
<script>    
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
    
    function validarCNPJ(cnpj) {
        cnpj = cnpj.replace(/[^\d]+/g, '');

        if (cnpj.length !== 14) {
            alert("CNPJ inválido");
            document.getElementById("cnpj").value = "";
            return;
        };

        if (/^(\d)\1+$/.test(cnpj)){
            alert("CNPJ inválido");
            document.getElementById("cnpj").value = "";
            return;
        };


        let tamanho = cnpj.length - 2;
        let numeros = cnpj.substring(0, tamanho);
        let digitos = cnpj.substring(tamanho);
        let soma = 0;
        let pos = tamanho - 7;
        
        for (let i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2) pos = 9;
        }
        
        let resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado !== parseInt(digitos.charAt(0))) {
            alert("CNPJ inválido");
            document.getElementById("cnpj").value = "";
            return;
        };

        tamanho = tamanho + 1;
        numeros = cnpj.substring(0, tamanho);
        soma = 0;
        pos = tamanho - 7;
        
        for (let i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2) pos = 9;
        }
        
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado !== parseInt(digitos.charAt(1))) {
            alert("CNPJ inválido");
            document.getElementById("cnpj").value = "";
            return;
        };


        return true;
    }
</script>

@endsection