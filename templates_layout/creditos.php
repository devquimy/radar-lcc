<?php
$titulo_pagina = "Créditos para estudo";
require("settings.php");
include("head.php");
include("menu.php");
include("topo.php");

$creditos_para_estudo = 10;

if($creditos_para_estudo == 0){
    $creditos_class = "alert-danger";
    $creditos_style = "border: 1px solid red; border-radius:5px;";
}else{
    $creditos_class = "alert-success";
    $creditos_style = "border: 1px solid green; border-radius:5px;";
}
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-lg-12">

                <div class="card shadow mb-4">
                    <div class="card-body <?=$creditos_class?>" style="<?=$creditos_style?>">    
                        <h4>Créditos disponíveis para estudo: <b><?=$creditos_para_estudo?></b></h4>
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
                                <?php
                                $planos = array(
                                    ["nome" => "1 estudo", "valor" => "R$ 800,00"],
                                    ["nome" => "3 estudos", "valor" => "R$ 2.000,00"],
                                    ["nome" => "5 estudos", "valor" => "R$ 3.200,00"],
                                    ["nome" => "10 estudos", "valor" => "R$ 6.000,00"],
                                    ["nome" => "20 estudos", "valor" => "R$ 8.000,00"],
                                    ["nome" => "30 estudos", "valor" => "R$ 10.000,00"],
                                    ["nome" => "40 estudos", "valor" => "R$ 12.000,00"],
                                    ["nome" => "Estudos ilimitados", "valor" => "R$ 15.000,00"]
                                );
                                foreach($planos as $plano){
                                    $nome = $plano['nome'];
                                    $valor = $plano['valor'];
                                    ?>
                                    <div class="col-lg-3 col-sm-4 col-xs-4 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.1s" data-wow-offset="0">
                                        <div class="single-pricing">
                                            <div class="price-head">
                                                <h2><?=$nome?></h2>
                                                <span></span> <span></span> <span></span> <span></span> <span></span> <span></span>
                                            </div>
                                            <h1 class="price"><?=$valor?></h1>
                                            <br>
                                            <a href="#" class="btn btn-primary">Adquirir</a>
                                        </div>
                                    </div>        
                                    <?php
                                }
                                ?>
                            </div>
                        </section>
                        <style type="text/css">
                            /*body {
                            margin-top: 20px;
                            }*/

                            /*.pricing-content {}*/

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

                            /*.single-pricing {}*/

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

                            /*.single-pricing a {
                            background: none;
                            border: 2px solid #efaa25;
                            border-radius: 5000px;
                            color: #efaa25;
                            display: inline-block;
                            font-size: 16px;
                            overflow: hidden;
                            padding: 10px 45px;
                            text-transform: capitalize;
                            transition: all 0.3s ease 0s;
                            }*/

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
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include("footer.php");
?>