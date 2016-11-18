<?php
use yii\helpers\Url;
?>
<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3 class="text-info text-center"><?=$model->transportProps[count($model->transportProps)-1]->value.'. Стоимость '.$model->transportProps[0]->value?> Грн</h3>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center" style="overflow: hidden">
            <div class="row">
                <div class="col-lg-12">
                    <img src="<?=Url::home(true)?>images/items/<?=$photo[1].'/'.$photo[0]->title?>" class="items_img img-rounded">
                </div>
                <div class="col-lg-12">
                    <div class="well">
                        <h4>Галерея</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <table class="table">
                <tr>
                    <th>Свойство товара</th>
                    <th>Значение</th>
                </tr>
                <?php $count = 0; foreach ($model->transportProps as $data): $count++;?>
                    <?php if($count == $countModel-1)continue;?>
                    <tr>
                        <td><?=Yii::t('cabinet','transport_items')['transport_tires_items'][$data->prop->name]?></td>
                        <td><?=$data->value?></td>
                    </tr>
                <?php endforeach;?>
            </table>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="well">
            <h4><?= $description?></h4>
        </div>
    </div>
</div>