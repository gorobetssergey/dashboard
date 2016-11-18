<?php
use app\components\VipItemsWidget;

?>

<div class="row">
    <div class="col-lg-12">
        <?= VipItemsWidget::widget([
            'ItemsVip' => $data['itemsVip'],
            'modelVip' => $data['modelVip'],
            'title' => 'Похожие товары',
            'it_style' => 'items_vips'
        ])?>
    </div>
</div>