<style>
    /* Timeline */
    .timeline,
    .timeline-horizontal {
        list-style: none;
        padding: 20px;
        position: relative;
    }

    .timeline:before {
        top: 40px;
        bottom: 0;
        position: absolute;
        content: " ";
        width: 3px;
        background-color: #eeeeee;
        left: 50%;
        margin-left: -1.5px;
    }

    .timeline .timeline-item {
        margin-bottom: 20px;
        position: relative;
    }

    .timeline .timeline-item:before,
    .timeline .timeline-item:after {
        content: "";
        display: table;
    }

    .timeline .timeline-item:after {
        clear: both;
    }

    .timeline .timeline-item .timeline-badge {
        color: #fff;
        width: 54px;
        height: 54px;
        line-height: 52px;
        font-size: 22px;
        text-align: center;
        position: absolute;
        top: 18px;
        left: 50%;
        margin-left: -25px;
        background-color: #7c7c7c;
        border: 3px solid #ffffff;
        z-index: 100;
        border-top-right-radius: 50%;
        border-top-left-radius: 50%;
        border-bottom-right-radius: 50%;
        border-bottom-left-radius: 50%;
    }

    .timeline .timeline-item .timeline-badge i,
    .timeline .timeline-item .timeline-badge .fa,
    .timeline .timeline-item .timeline-badge .glyphicon {
        top: 2px;
        left: 0px;
    }

    .timeline .timeline-item .timeline-badge.primary {
        background-color: #1f9eba;
    }

    .timeline .timeline-item .timeline-badge.info {
        background-color: #5bc0de;
    }

    .timeline .timeline-item .timeline-badge.success {
        background-color: #59ba1f;
    }

    .timeline .timeline-item .timeline-badge.warning {
        background-color: #d1bd10;
    }

    .timeline .timeline-item .timeline-badge.danger {
        background-color: #ba1f1f;
    }

    .timeline .timeline-item .timeline-panel {
        position: relative;
        width: 46%;
        float: left;
        right: 16px;
        border: 1px solid #c0c0c0;
        background: #ffffff;
        border-radius: 2px;
        padding: 20px;
        -webkit-box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
        box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
    }

    .timeline .timeline-item .timeline-panel:before {
        position: absolute;
        top: 26px;
        right: -16px;
        display: inline-block;
        border-top: 16px solid transparent;
        border-left: 16px solid #c0c0c0;
        border-right: 0 solid #c0c0c0;
        border-bottom: 16px solid transparent;
        content: " ";
    }

    .timeline .timeline-item .timeline-panel .timeline-title {
        margin-top: 0;
        color: inherit;
    }

    .timeline .timeline-item .timeline-panel .timeline-body>p,
    .timeline .timeline-item .timeline-panel .timeline-body>ul {
        margin-bottom: 0;
    }

    .timeline .timeline-item .timeline-panel .timeline-body>p+p {
        margin-top: 5px;
    }

    .timeline .timeline-item:last-child:nth-child(even) {
        float: right;
    }

    .timeline .timeline-item:nth-child(even) .timeline-panel {
        float: right;
        left: 16px;
    }

    .timeline .timeline-item:nth-child(even) .timeline-panel:before {
        border-left-width: 0;
        border-right-width: 14px;
        left: -14px;
        right: auto;
    }

    .timeline-horizontal {
        list-style: none;
        position: relative;
        padding: 20px 0px 20px 0px;
        display: inline-block;
    }

    .timeline-horizontal:before {
        height: 3px;
        top: auto;
        bottom: 26px;
        left: 56px;
        right: 0;
        width: 100%;
        margin-bottom: 20px;
    }

    .timeline-horizontal .timeline-item {
        display: table-cell;
        height: 280px;
        width: 20%;
        min-width: 320px;
        float: none !important;
        padding-left: 0px;
        padding-right: 20px;
        margin: 0 auto;
        vertical-align: bottom;
    }

    .timeline-horizontal .timeline-item .timeline-panel {
        top: auto;
        bottom: 64px;
        display: inline-block;
        float: none !important;
        left: 0 !important;
        right: 0 !important;
        width: 100%;
        margin-bottom: 20px;
    }

    .timeline-horizontal .timeline-item .timeline-panel:before {
        top: auto;
        bottom: -16px;
        left: 28px !important;
        right: auto;
        border-right: 16px solid transparent !important;
        border-top: 16px solid #c0c0c0 !important;
        border-bottom: 0 solid #c0c0c0 !important;
        border-left: 16px solid transparent !important;
    }

    .timeline-horizontal .timeline-item:before,
    .timeline-horizontal .timeline-item:after {
        display: none;
    }

    .timeline-horizontal .timeline-item .timeline-badge {
        top: auto;
        bottom: 0px;
        left: 43px;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div style="display:inline-block;width:100%;overflow-y:auto;">
                <ul class="timeline timeline-horizontal">
                    <li class="timeline-item">
                        <div class="timeline-badge primary"><i class="glyphicon glyphicon-check"></i></div>
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h4 class="timeline-title">Mussum ipsum cacilds 1</h4>
                                <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> 11 hours ago via Twitter</small></p>
                            </div>
                            <div class="timeline-body">
                                <p>Mussum ipsum cacilds, vidis litro abertis. Consetis faiz elementum girarzis, nisi eros gostis.</p>
                            </div>
                        </div>
                    </li>
                    <li class="timeline-item">
                        <div class="timeline-badge success"><i class="glyphicon glyphicon-check"></i></div>
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h4 class="timeline-title">Mussum ipsum cacilds 2</h4>
                                <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> 11 hours ago via Twitter</small></p>
                            </div>
                            <div class="timeline-body">
                                <p>Mussum ipsum cacilds, vidis faiz elementum girarzis, nisi eros gostis.</p>
                            </div>
                        </div>
                    </li>
                    <li class="timeline-item">
                        <div class="timeline-badge info"><i class="glyphicon glyphicon-check"></i></div>
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h4 class="timeline-title">Mussum ipsum cacilds 3</h4>
                                <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> 11 hours ago via Twitter</small></p>
                            </div>
                            <div class="timeline-body">
                                <p>Mussum ipsum cacilds, vidis litro abertis. Consetis adipisci. Mé faiz elementum girarzis, nisi eros gostis.</p>
                            </div>
                        </div>
                    </li>
                    <li class="timeline-item">
                        <div class="timeline-badge danger"><i class="glyphicon glyphicon-check"></i></div>
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h4 class="timeline-title">Mussum ipsum cacilds 4</h4>
                                <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> 11 hours ago via Twitter</small></p>
                            </div>
                            <div class="timeline-body">
                                <p>Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , depois divoltis porris, paradis. Paisis, filhis, espiritis santis.</p>
                            </div>
                        </div>
                    </li>
                    <li class="timeline-item">
                        <div class="timeline-badge warning"><i class="glyphicon glyphicon-check"></i></div>
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h4 class="timeline-title">Mussum ipsum cacilds 5</h4>
                                <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> 11 hours ago via Twitter</small></p>
                            </div>
                            <div class="timeline-body">
                                <p>Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , depois divoltis porris, paradis. Paisis, filhis, espiritis santis.</p>
                            </div>
                        </div>
                    </li>
                    <li class="timeline-item">
                        <div class="timeline-badge"><i class="glyphicon glyphicon-check"></i></div>
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h4 class="timeline-title">Mussum ipsum cacilds 6</h4>
                                <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> 11 hours ago via Twitter</small></p>
                            </div>
                            <div class="timeline-body">
                                <p>Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , depois divoltis porris, paradis. Paisis, filhis, espiritis santis.</p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <h1>Timeline</h1>
            </div>
            <ul class="timeline">
                <li class="timeline-item">
                    <div class="timeline-badge"><i class="glyphicon glyphicon-off"></i></div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4 class="timeline-title">Mussum ipsum cacilds 1</h4>
                            <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> 11 hours ago via Twitter</small></p>
                        </div>
                        <div class="timeline-body">
                            <p>Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , depois divoltis porris, paradis. Paisis, filhis, espiritis santis. Mé faiz elementum girarzis, nisi eros vermeio, in elementis mé pra quem é amistosis quis leo. Manduma pindureta quium dia nois paga. Sapien in monti palavris qui num significa nadis i pareci latim. Interessantiss quisso pudia ce receita de bolis, mais bolis eu num gostis.</p>
                        </div>
                    </div>
                </li>
                <li class="timeline-item">
                    <div class="timeline-badge"><i class="glyphicon glyphicon-check"></i></div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4 class="timeline-title">Mussum ipsum cacilds 2</h4>
                            <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> 11 hours ago via Twitter</small></p>
                        </div>
                        <div class="timeline-body">
                            <p>Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , depois divoltis porris, paradis. Paisis, filhis, espiritis santis. Mé faiz elementum girarzis, nisi eros gostis.</p>
                        </div>
                    </div>
                </li>
                <li class="timeline-item">
                    <div class="timeline-badge"><i class="glyphicon glyphicon-check"></i></div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4 class="timeline-title">Mussum ipsum cacilds 3</h4>
                            <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> 11 hours ago via Twitter</small></p>
                        </div>
                        <div class="timeline-body">
                            <p>Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , depois divoltis porris, paradis. Paisis, filhis, espiritis santis. Mé faiz elementum girarzis, nisi eros vermeio, in elementis mé pra quem é amistosis quis leo. Manduma pindureta quium dia nois paga. Sapien in monti palavris qui num significa nadis i pareci latim. Interessantiss quisso pudia ce receita de bolis, mais bolis eu num gostis.</p>
                            <p>Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , depois divoltis porris, paradis. Paisis, filhis, espiritis santis. Mé faiz elementum girarzis, nisi eros vermeio, in elementis mé pra quem é amistosis quis leo. Manduma pindureta quium dia nois paga. Sapien in monti palavris qui num significa nadis i pareci latim. Interessantiss quisso pudia ce receita de bolis, mais bolis eu num gostis.</p>

                        </div>
                    </div>
                </li>
                <li class="timeline-item">
                    <div class="timeline-badge"><i class="glyphicon glyphicon-check"></i></div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4 class="timeline-title">Mussum ipsum cacilds 4</h4>
                            <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> 11 hours ago via Twitter</small></p>
                        </div>
                        <div class="timeline-body">
                            <p>Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , depois divoltis porris, paradis. Paisis, filhis, espiritis santis. Mé faiz elementum girarzis, nisi eros vermeio, in elementis mé pra quem é amistosis quis leo. Manduma pindureta quium dia nois paga. Sapien in monti palavris qui num significa nadis i pareci latim. Interessantiss quisso pudia ce receita de bolis, mais bolis eu num gostis.</p>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>