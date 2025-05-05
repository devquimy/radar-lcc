<?php
$titulo_pagina = "Usuários";
require("settings.php");
include("head.php");
include("menu.php");
include("topo.php");
    ?>
    <div class="container-fluid">
        <div class="row mb-2 pt-2">
            <div class="col-6">
                <h4>Cadastro/Edição</h4>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form class="row g-3" action="#" method="post">
                    <div class="col-md-4">
                        <label for="nivel" class="form-label">Nivel:</label>
                        <select class="custom-select" aria-label="Default select example" button="" name="nivel" id="nivel">
                            <option value=""></option>
                            <option value="1">Administrador</option>
                            <option value="2">Cliente (ADM)</option>
                            <option value="3">Cliente (Usuário)</option>
                        </select>
                    </div>
                    <div class="col-md-8 div_empresa" style="display: none;">
                        <label for="name" class="form-label">Empresa:</label>
                        <select class="custom-select" aria-label="Default select example" button="" name="empresa" id="empresa">
                            <option value=""></option>
                            <option value="1">Empresa 1</option>
                            <option value="2">Empresa 2</option>
                            <option value="3">Empresa 3</option>
                            <option value="4">Empresa 4</option>
                            <option value="5">Empresa 5</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label for="name" class="form-label">Nome:</label>
                        <input type="text" class="form-control " id="name" name="name" value="">
                    </div>
                    <div class="col-md-3">
                        <label for="email" class="form-label">E-mail (login):</label>
                        <input type="text" class="form-control " id="email" name="email" value="">
                    </div>
                    <div class="col-md-3">
                        <label for="senha" class="form-label">Senha:</label>
                        <div class="input-group">
                            <input type="password" class="form-control float-left" id="senha" name="senha" value="">
                            <div class="input-group-append">
                                <span class="input-group-text mostra_senha" id="basic-addon2"><i class="fas fa-eye verSenha float-right" width="10%"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status:</label>
                        <select class="custom-select" aria-label="Default select example" button="" name="status">
                            <option value="1" selected="">Ativo</option>
                            <option value="2">Inativo</option>
                        </select>
                    </div>
                    <div class="col-12 pt-4">
                        <button type="submit" class="btn btn-primary">Concluir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
include("footer.php");
?>