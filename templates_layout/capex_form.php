<?php
$titulo_pagina = "Ativos Físicos";
$timeline = 2;
require("settings.php");
include("head.php");
include("menu.php");
include("topo.php");
    ?>
    <div class="container-fluid">
        <?php
        include("timeline.php");
        ?>
        <form class="g-3" action="opex_form?disabled=<?=@$_GET['disabled']?>" method="post">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="">
                                <label for="xxxxxxx" class="form-label">Ano do estudo:</label>
                                <input type="number" class="form-control" id="xxxxxxx" name="xxxxxxx" value="<?=date("Y")?>" disabled>
                            </div>
                            <div class="">
                                <label for="xxxxxxx" class="form-label">Motivo da escolha do Ativo Físico:</label>
                                <textarea class="form-control" id="xxxxxxx" name="xxxxxxx" rows="6"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6 mt-sm-3">
                            <div class="card-form">
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
                                            <tr>
                                                <td class="text-center">#1</td>
                                                <td>
                                                    <input type="number" class="form-control" id="xxxxxxx" name="xxxxxxx" value="" maxlength="4" min="1900" max="<?=date("Y")?>">
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1">R$</span>
                                                        </div>
                                                        <input type="text" id="valor_de_aquisicao" name="valor_de_aquisicao" class="form-control capex_custos" aria-label="Username" aria-describedby="basic-addon1">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">#2</td>
                                                <td>
                                                    <input type="number" class="form-control" id="xxxxxxx" name="xxxxxxx" value="" maxlength="4" min="1900" max="<?=date("Y")?>">
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1">R$</span>
                                                        </div>
                                                        <input type="text" id="valor_de_aquisicao" name="valor_de_aquisicao" class="form-control capex_custos" aria-label="Username" aria-describedby="basic-addon1">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">#3</td>
                                                <td>
                                                    <input type="number" class="form-control" id="xxxxxxx" name="xxxxxxx" value="" maxlength="4" min="1900" max="<?=date("Y")?>">
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1">R$</span>
                                                        </div>
                                                        <input type="text" id="valor_de_aquisicao" name="valor_de_aquisicao" class="form-control capex_custos" aria-label="Username" aria-describedby="basic-addon1">
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-8">
                                    <h5 class="pt-2 font-weight-bold">Melhorias e reformas</h5>
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
                            <table class="table table-default">
                                <thead>
                                    <tr>
                                        <td style="width:20%" rowspan="2">Ano</td>
                                        <td style="width:20%" rowspan="2">Valor</td>
                                        <td style="width:20%" colspan="3">Percentual de redução de custos em:</td>
                                    </tr>
                                    <tr>
                                        <td style="width:20%">Operação</td>
                                        <td style="width:20%">Manut. planejada</td>
                                        <td style="width:20%">Manut. não planejada</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <input type="number" class="form-control" id="xxxxxxx" name="xxxxxxx" value="" maxlength="4" min="1900" max="<?=date("Y")?>">
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
                                                <input type="number" class="form-control" id="xxxxxxx" name="xxxxxxx" placeholder="" aria-label="" aria-describedby="basic-addon2" maxlength="3" min="0" max="100">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="basic-addon2">%</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="number" class="form-control" id="xxxxxxx" name="xxxxxxx" placeholder="" aria-label="" aria-describedby="basic-addon2" maxlength="3" min="0" max="100">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="basic-addon2">%</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="number" class="form-control" id="xxxxxxx" name="xxxxxxx" placeholder="" aria-label="" aria-describedby="basic-addon2" maxlength="3" min="0" max="100">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="basic-addon2">%</span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="number" class="form-control" id="xxxxxxx" name="xxxxxxx" value="" maxlength="4" min="1900" max="<?=date("Y")?>">
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
                                                <input type="number" class="form-control" id="xxxxxxx" name="xxxxxxx" placeholder="" aria-label="" aria-describedby="basic-addon2" maxlength="3" min="0" max="100">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="basic-addon2">%</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="number" class="form-control" id="xxxxxxx" name="xxxxxxx" placeholder="" aria-label="" aria-describedby="basic-addon2" maxlength="3" min="0" max="100">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="basic-addon2">%</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="number" class="form-control" id="xxxxxxx" name="xxxxxxx" placeholder="" aria-label="" aria-describedby="basic-addon2" maxlength="3" min="0" max="100">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="basic-addon2">%</span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="number" class="form-control" id="xxxxxxx" name="xxxxxxx" value="" maxlength="4" min="2008" max="<?=date("Y")?>">
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
                                                <input type="number" class="form-control" id="xxxxxxx" name="xxxxxxx" placeholder="" aria-label="" aria-describedby="basic-addon2" maxlength="3" min="0" max="100">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="basic-addon2">%</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="number" class="form-control" id="xxxxxxx" name="xxxxxxx" placeholder="" aria-label="" aria-describedby="basic-addon2" maxlength="3" min="0" max="100">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="basic-addon2">%</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="number" class="form-control" id="xxxxxxx" name="xxxxxxx" placeholder="" aria-label="" aria-describedby="basic-addon2" maxlength="3" min="0" max="100">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="basic-addon2">%</span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 pt-4">
                            <button type="button" class="btn btn-dark" onclick="window.location.href='ativos_fisicos_form'">Voltar</button>
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