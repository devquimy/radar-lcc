<?php
$titulo_pagina = "Ativos Físicos";
$timeline = 3;
require("settings.php");
include("head.php");
include("menu.php");
include("topo.php");
    ?>
    <div class="container-fluid">
        <?php
        include("timeline.php");
        ?>
        <form class="g-3" action="curva_lcc?disabled=<?=@$_GET['disabled']?>" method="post">
            <div class="card mt-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="row mb-3">
                                <div class="col-8">
                                    &nbsp;
                                </div>
                                <div class="col-4 text-right">
                                    <?php
                                    if(@$_GET['disabled'] != 1){
                                        ?>
                                        <a href="#" class="btn btn-sm btn-primary shadow-sm">
                                            <i class="fas fa-plus fa-sm text-white-50"></i> Adicionar
                                        </a>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <table class="table table-default table-default-sm table-responsive">
                                <thead>
                                    <tr>
                                        <td style="width:8%" rowspan="2">Ano</td>
                                        <td style="width:8%" colspan="3">Operação</td>
                                        <td style="width:8%" colspan="3">Manutenção planejada</td>
                                        <td style="width:8%" colspan="3">Manutenção não planejada</td>
                                        <td style="width:8%" rowspan="2">Taxa inflação sugerida</td>
                                        <td style="width:8%" rowspan="2">Fator Multiplicador Sugerido</td>
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
                                    for($i=2008; $i<=2038; $i++){
                                        ?>
                                        <tr>
                                            <td>
                                                <input type="number" class="form-control" id="xxxxxxx" name="xxxxxxx" value="<?=$i?>" maxlength="4" min="2008">
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">R$</span>
                                                    </div>
                                                    <input type="text" id="xxxxxxx" name="xxxxxxx" class="form-control capex_custos" aria-label="Username" aria-describedby="basic-addon1">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">R$</span>
                                                    </div>
                                                    <input type="text" id="xxxxxxx" name="xxxxxxx" class="form-control capex_custos" aria-label="Username" aria-describedby="basic-addon1">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">R$</span>
                                                    </div>
                                                    <input type="text" id="xxxxxxx" name="xxxxxxx" class="form-control capex_custos" aria-label="Username" aria-describedby="basic-addon1" disabled>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">R$</span>
                                                    </div>
                                                    <input type="text" id="xxxxxxx" name="xxxxxxx" class="form-control capex_custos" aria-label="Username" aria-describedby="basic-addon1">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">R$</span>
                                                    </div>
                                                    <input type="text" id="xxxxxxx" name="xxxxxxx" class="form-control capex_custos" aria-label="Username" aria-describedby="basic-addon1">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">R$</span>
                                                    </div>
                                                    <input type="text" id="xxxxxxx" name="xxxxxxx" class="form-control capex_custos" aria-label="Username" aria-describedby="basic-addon1" disabled>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">R$</span>
                                                    </div>
                                                    <input type="text" id="xxxxxxx" name="xxxxxxx" class="form-control capex_custos" aria-label="Username" aria-describedby="basic-addon1">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">R$</span>
                                                    </div>
                                                    <input type="text" id="xxxxxxx" name="xxxxxxx" class="form-control capex_custos" aria-label="Username" aria-describedby="basic-addon1">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">R$</span>
                                                    </div>
                                                    <input type="text" id="xxxxxxx" name="xxxxxxx" class="form-control capex_custos" aria-label="Username" aria-describedby="basic-addon1" disabled>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">R$</span>
                                                    </div>
                                                    <input type="text" id="xxxxxxx" name="xxxxxxx" class="form-control capex_custos" aria-label="Username" aria-describedby="basic-addon1" disabled>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">R$</span>
                                                    </div>
                                                    <input type="text" id="xxxxxxx" name="xxxxxxx" class="form-control capex_custos" aria-label="Username" aria-describedby="basic-addon1" disabled>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 pt-4">
                            <button type="button" class="btn btn-dark" onclick="window.location.href='capex_form'">Voltar</button>
                            <button type="submit" class="btn btn-primary">Avançar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?php
include("footer.php");
?>