<?php
$titulo_pagina = "Inflação";
require("settings.php");
include("head.php");
include("menu.php");
include("topo.php");
    ?>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form class="g-3" action="#" method="post">
                    <div class="row">
                        <div class="col-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="razao_social" class="form-label">Ano:</label>
                                </div>
                                <div class="col-md-6">
                                    <label for="razao_social" class="form-label">Inflação:</label>
                                </div>
                            </div>
                            <?php
                            for($i=1996; $i<=date("Y"); $i++){
                                ?>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control " id="razao_social" name="razao_social" value="<?=$i?>">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control " id="razao_social" name="razao_social" value="">
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="col" style="padding-top:2.2rem;">
                            <button type="submit" class="btn btn-primary">Atualizar</button>
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