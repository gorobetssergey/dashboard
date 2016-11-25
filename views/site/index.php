<?php

use yii\helpers\Url;
use app\components\VipItemsWidget;

$this->title = 'Главная';
?>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <?= VipItemsWidget::widget([
                'ItemsVip' => $ItemsVip,
                'modelVip' => $modelVip,
                'title' => 'VIP',
                'it_style' => 'items_block'
            ])?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <?php if($ItemsTop): ?>
                <h3>TOP</h3>
                <?php foreach ($ItemsTop as $item) :?>
                    <a href="#">
                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 items_block">
                            <label class="text-muted text-left">Top</label>
                            <img src="<?=Url::home(true)?>images/site/no_image.png" class="items_img">
                            <h4><?= $item->name ?></h4>
                            <h3 class="text-center"><?= '0'.'грн' ?></h3>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php endif;?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <?php if($ItemsStandard): ?>
                <h3>Standart</h3>
                <?php foreach ($ItemsStandard as $item) :?>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <a href="<?=Url::toRoute('view?items='.$item->id)?>">
                            <div class="items_block">
                                <h4 class="text-muted text-center"><?= $item->name ?></h4>
                                <img src="<?=Url::home(true)?>images/items/<?=$modelStandard[$item->id]?>" class="items_img">
                                <h3 class="text-center"><?= $item->topmenu->itemsTransports[$item->items_id-1]->transportProps[0]->value.'грн' ?></h3>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php endif;?>
        </div>
    </div>
</div>
