<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="timeline-container">
                <ul class="timeline timeline-horizontal" style="margin-bottom:0px">
                    <a href='<?= (isset($estudo)) ? route('ativo_fisico.edit', [$estudo->ativo_fisico_id, $estudo->id]) : '#' ?>' class="timeline-item">
                        <div class="timeline-badge <?= $timeline_bottom_style_1 ?? 'timeline-bottom-off' ?>">1</div>
                        <div class="timeline-panel <?= $timeline_card_style_1 ?? 'timeline-card-off' ?>">
                            <div class="timeline-heading">
                                <h5 class="timeline-title" style="color:black">Cadastro do Ativo Físico</h4>
                                <p><small class="text-muted">Informações do ativo</small></p>
                            </div>
                        </div>
                    </a>
                    <a href="<?= (isset($estudo)) ? route('capex.edit', $estudo->capex->id) : "#" ?>" class="timeline-item">
                        <div class="timeline-badge <?= $timeline_bottom_style_2 ?? 'timeline-bottom-off' ?>">2</div>
                        <div class="timeline-panel <?= $timeline_card_style_2 ?? 'timeline-card-off' ?>">
                            <div class="timeline-heading">
                                <h5 class="timeline-title" style="color:black">Investimento Fase Capex</h4>
                                <p><small class="text-muted">Despesas de Capital</small></p>
                            </div>
                        </div>
                    </a>
                    <a href="<?= (isset($estudo)) ?  route('opex.edit', $estudo->opex->id) : "#" ?>" class="timeline-item">
                        <div class="timeline-badge <?= $timeline_bottom_style_3 ?? 'timeline-bottom-off' ?>">3</div>
                        <div class="timeline-panel <?= $timeline_card_style_3 ?? 'timeline-card-off' ?>">
                            <div class="timeline-heading">
                                <h5 class="timeline-title" style="color:black">Despesas Fase Opex</h4>
                                    <p><small class="text-muted">Despesas Operacionais</small></p>
                                </div>
                        </div>
                    </a>
                    <?php 
                        if((isset($estudo))){
                            if($estudo->nome_relatorio != null){
                                $route2 = route('estudo.visualizar_relatorio', $estudo->id);

                            }else{
                                $route2 = "#";

                            }
                            if($estudo->custo_anual_equivalente != null){
                                $route = route('estudo.curva_anual_equivalente', $estudo->id);

                            }else{
                                $route = "#";

                            }
                        }else{
                            $route = "#";
                            $route2 = "#";
                        }
                    ?>
                    <a id="btnCardCurva" href="<?= $route ?>" class="timeline-item">
                        <div class="timeline-badge <?= $timeline_bottom_style_4 ?? 'timeline-bottom-off' ?>">4</div>
                        <div class="timeline-panel <?= $timeline_card_style_4  ?? 'timeline-card-off' ?>">
                            <div class="timeline-heading">
                                <h5 class="timeline-title" style="color:black">Curva Custo Anual Equivalente (CAE)</h4>
                                <p><small class="text-muted">Resultado gráfico do estudo</small></p>
                            </div>
                        </div>
                    </a>
                    <a id="btnCardRelatorio" href="<?= $route2 ?>" class="timeline-item">
                        <div class="timeline-badge <?= $timeline_bottom_style_5 ?? 'timeline-bottom-off' ?>">5</div>
                        <div class="timeline-panel <?= $timeline_card_style_5  ?? 'timeline-card-off' ?>">
                            <div class="timeline-heading">
                                <h5 class="timeline-title" style="color:black">Relatório do Radar LCC</h4>
                                <p><small class="text-muted">Relatório final do estudo</small></p>
                            </div>
                        </div>
                    </a>
                </ul>
            </div>
        </div>
    </div>
</div>