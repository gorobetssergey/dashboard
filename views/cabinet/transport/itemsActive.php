<?php

use yii\helpers\Url;

$result = Yii::$app->getSession()->getFlash('edit_items_find_err');
?>
<div class="row">
    <div class="col-lg-12">
        <?php if($result):?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong><?=$result?></strong>
            </div>
        <?php endif;?>
    </div>
</div>

<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <?php foreach ($items as $item):?>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading<?=$item->id?>">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$item->id?>" aria-expanded="true" aria-controls="collapse<?=$item->id?>">
                        <h4><?=$item->transportProps[count($item->transportProps)-1]->value?></h4>
                    </a>
                </h4>
            </div>
            <div id="collapse<?=$item->id?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?=$item->id?>">
                <div class="panel-body">
                    <div class="col-lg-12">
                        <table class="table">
                            <tr>
                                <th>Свойство товара</th>
                                <th>Значение свойства</th>
                            </tr>
                            <?php foreach ($item->transportProps as $data): ?>
                                <tr>
                                    <td><?=Yii::t('cabinet','transport_items')['transport_tires_items'][$data->prop->name]?></td>
                                    <td><?=$data->value?></td>
                                </tr>
                            <?php endforeach;?>
                        </table>
                        <a href="<?=Url::toRoute('edit-items?tompenu='.$item->topmenu_id.'&id='.$item->id)?>" class = 'btn btn-info btn-block'>Редактировать цену</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach;?>
</div>