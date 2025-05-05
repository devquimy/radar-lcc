<?php
$titulo_pagina = "Ativos Físicos";
$timeline = 1;
require("settings.php");
include("head.php");
include("menu.php");
include("topo.php");
    ?>
    <div class="container-fluid">
        <?php
        include("timeline.php");
        ?>
        <div class="card">
            <div class="card-body">
                <form class="g-3" action="capex_form" method="post">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="xxxxxxx" class="form-label">Setor/TAG (local de instalação):</label>
                            <input type="text" class="form-control" id="xxxxxxx" name="xxxxxxx" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="xxxxxxx" class="form-label">Nome do Ativo Físico:</label>
                            <input type="text" class="form-control" id="xxxxxxx" name="xxxxxxx" value="" maxlength="18">
                        </div>
                        <div class="col-md-3">
                            <label for="xxxxxxx" class="form-label">ID do Ativo Físico:</label>
                            <input type="text" class="form-control" id="xxxxxxx" name="xxxxxxx" value="" maxlength="18">
                        </div>
                        <div class="col-md-3">
                            <label for="xxxxxxx" class="form-label">Ano da aquisição:</label>
                            <input type="number" class="form-control" id="xxxxxxx" name="xxxxxxx" value="" maxlength="4" min="1900" max="<?=date("Y")?>">
                        </div>
                        <div class="col-md-3">
                            <label for="xxxxxxx" class="form-label">Expectativa de vida (fabricante):</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="xxxxxxx" name="xxxxxxx" placeholder="" aria-label="" aria-describedby="basic-addon2" maxlength="3" min="0" max="999">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">anos</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="regra_de_depreciacao" class="form-label">Regra de depreciação:</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="regra_de_depreciacao" name="regra_de_depreciacao" aria-describedby="basic-addon2" maxlength="3" min="0" max="100">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="anos_para_depreciar" class="form-label">Anos para depreciar:</label>
                            <input type="text" class="form-control" id="anos_para_depreciar" name="anos_para_depreciar" value="" disabled>
                        </div>
                        <div class="col-md-3">
                            <label for="xxxxxxx" class="form-label">Taxa de perda de valor ao ano:</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="xxxxxxx" name="xxxxxxx" placeholder="" aria-label="" aria-describedby="basic-addon2" maxlength="3" min="0" max="100">
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
                            <label for="valor_de_aquisicao" class="form-label">Valor de aquisição:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">R$</span>
                                </div>
                                <input type="text" id="valor_de_aquisicao" name="valor_de_aquisicao" class="form-control capex_custos" aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="custo_de_instalacao" class="form-label">Custo de instalação:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">R$</span>
                                </div>
                                <input type="text" id="custo_de_instalacao" name="custo_de_instalacao" class="form-control capex_custos" aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="custo_do_comissionamento" class="form-label">Custo do comissionamento:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">R$</span>
                                </div>
                                <input type="text" id="custo_do_comissionamento" name="custo_do_comissionamento" class="form-control capex_custos" aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="valor_da_depreciacao" class="form-label">Valor da depreciação:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">R$</span>
                                </div>
                                <input type="text" id="valor_da_depreciacao" name="valor_da_depreciacao" class="form-control" aria-label="Username" aria-describedby="basic-addon1" value="0,00" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 pt-4">
                            <button type="submit" class="btn btn-primary">Avançar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
include("footer.php");
?>