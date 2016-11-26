<?php

use yii\helpers\Url;
use app\components\VipItemsWidget;
use app\components\SearchWidget;

$this->title = 'Главная';
?>
<?= SearchWidget::widget()?>
<div class="mem" id = 'transport'>
    <div class="row" id = 'transport_first'>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <img src="/images/site/menu/transport/start.jpg" alt="" style="height: 180px;">
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <h3>ТРАНСПОРТ</h3>
        </div>
    </div>
    <div class="row" id = 'transport_new'>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <img src="/images/site/menu/transport/new.jpg" alt="" style="height: 180px;">
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="transport">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTransport" aria-expanded="true" aria-controls="collapseTransport">
                            Транспорт
                        </a>
                    </h4>
                </div>
                <div id="collapseTransport" class="panel-collapse collapse" role="tabpanel" aria-labelledby="transport">
                    <div class="panel-body">
                        <div class="panel-group" id="accordionTransport" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="transporTires">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionTransport" href="#collapserealTransportTires" aria-expanded="false" aria-controls="collapserealTransportTires">
                                            Шины, диски, колеса
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapserealTransportTires" class="panel-collapse collapse" role="tabpanel" aria-labelledby="transporTires">
                                    <div class="panel-body">
                                        <ul class="dropdown-inside">
                                            <li><a class="dropdown-top" href="add-new-items?catalog=1">Автошины</a></li>
                                            <li><a class="dropdown-top" href="">Диски</a></li>
                                            <li><a class="dropdown-top" href="">Колеса в сборе</a></li>
                                            <li><a class="dropdown-top" href="">Колпаки</a></li>
                                            <li><a class="dropdown-top" href="">Мотошины</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="transportCar">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionTransport" href="#collapserealTransportCar" aria-expanded="false" aria-controls="collapserealTransportCar">
                                            Легковые автомобили
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapserealTransportCar" class="panel-collapse collapse" role="tabpanel" aria-labelledby="transportCar">
                                    <div class="panel-body">
                                        Меню Легковые автомобили
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="transportMoto">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionTransport" href="#collapserealTransportMoto" aria-expanded="false" aria-controls="collapserealTransportMoto">
                                            Мото
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapserealTransportMoto" class="panel-collapse collapse" role="tabpanel" aria-labelledby="transportMoto">
                                    <div class="panel-body">
                                        Меню Мото
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="mem" id = 'real_state'>
    <div class="row" id = 'real_state_first'>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <img src="/images/site/menu/transport/start.jpg" alt="" style="height: 180px;">
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <h3>Недвижимость</h3>
        </div>
    </div>
    <div class="row" id = 'real_state_new'>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <img src="/images/site/menu/transport/new.jpg" alt="" style="height: 180px;">
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="realEstate">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapserealEstate" aria-expanded="false" aria-controls="collapserealEstate">
                            Недвижимость
                        </a>
                    </h4>
                </div>
                <div id="collapserealEstate" class="panel-collapse collapse" role="tabpanel" aria-labelledby="realEstate">
                    <div class="panel-body">
                        Меню недвижимость
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
