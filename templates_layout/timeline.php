<?php
    $timeline_card_style_1      = "timeline-card-off";
    $timeline_bottom_style_1    = "timeline-bottom-off";
    $timeline_card_style_2      = "timeline-card-off";
    $timeline_bottom_style_2    = "timeline-bottom-off";
    $timeline_card_style_3      = "timeline-card-off";
    $timeline_bottom_style_3    = "timeline-bottom-off";
    $timeline_card_style_4      = "timeline-card-off";
    $timeline_bottom_style_4    = "timeline-bottom-off";

    if($timeline == 1){
        $timeline_card_style_1      = "timeline-card-1";
        $timeline_bottom_style_1    = "timeline-bottom-1";
    }
    if($timeline == 2){
        $timeline_card_style_2      = "timeline-card-2";
        $timeline_bottom_style_2    = "timeline-bottom-2";
    }
    if($timeline == 3){
        $timeline_card_style_3      = "timeline-card-3";
        $timeline_bottom_style_3    = "timeline-bottom-3";
    }
    if($timeline == 4){
        $timeline_card_style_4      = "timeline-card-4";
        $timeline_bottom_style_4    = "timeline-bottom-4";
    }
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="timeline-container">
                <ul class="timeline timeline-horizontal">
                    <li class="timeline-item">
                        <div class="timeline-badge <?=$timeline_bottom_style_1?>">1</div>
                        <div class="timeline-panel <?=$timeline_card_style_1?>">
                            <div class="timeline-heading">
                                <h4 class="timeline-title">Cadastro do Ativos Físico</h4>
                                <p><small class="text-muted">Informações fixas do ativo</small></p>
                            </div>
                        </div>
                    </li>
                    <li class="timeline-item">
                        <div class="timeline-badge <?=$timeline_bottom_style_2?>">2</div>
                        <div class="timeline-panel <?=$timeline_card_style_2?>">
                            <div class="timeline-heading">
                                <h4 class="timeline-title">Investimentos de Capex</h4>
                                <p><small class="text-muted">Despesas de Capital</small></p>
                            </div>
                        </div>
                    </li>
                    <li class="timeline-item">
                        <div class="timeline-badge <?=$timeline_bottom_style_3?>">3</div>
                        <div class="timeline-panel <?=$timeline_card_style_3?>">
                            <div class="timeline-heading">
                                <h4 class="timeline-title">OPEX</h4>
                                <p><small class="text-muted">Despesas Operacionais</small></p>
                            </div>
                        </div>
                    </li>
                    <li class="timeline-item">
                        <div class="timeline-badge <?=$timeline_bottom_style_4?>">4</div>
                        <div class="timeline-panel <?=$timeline_card_style_4?>">
                            <div class="timeline-heading">
                                <h4 class="timeline-title">Curva do Custo Anual Equivalente (CAE)</h4>
                                <p><small class="text-muted">Resultado final do estudo</small></p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>