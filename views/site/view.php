<?php

?>
<div class="row">
    <div class="col-lg-9">
        <div class="row">
            <div class="col-lg-12 text-center">
                <img src="/images/site/no_image.png" class="items_img img-rounded">
            </div>
            <div class="col-lg-12">
                <table class="table">
                    <tr>
                        <th>Свойство товара</th>
                        <th>Значение свойства</th>
                    </tr>
                    <?php foreach ($model->transportProps as $data): ?>
                        <tr>
                            <td><?=Yii::t('cabinet','transport_items')['transport_tires_items'][$data->prop->name]?></td>
                            <td><?=$data->value?></td>
                        </tr>
                    <?php endforeach;?>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="well">
            <h4>Доп инфа по типу ОЛХ</h4>
        </div>
    </div>
</div>