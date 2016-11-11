<?php

/* @var $this yii\web\View */
/* @var $ItemsVip */
/* @var $ItemsTop */
/* @var $ItemsStandard */

$this->title = 'Главная';
?>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <?php if($ItemsVip): ?>
                <h3>VIP</h3>
                <?php foreach ($ItemsVip as $item) :?>
                    <a href="#">
                        <div class="items_block">
                            <label class="text-muted text-left">Vip</label>
                            <img src="/images/site/no_image.png" class="items_img">
                            <h4><?= $item->name ?></h4>
                            <h3 class="text-center"><?= '0'.'грн' ?></h3>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php endif;?>
        </div>

        <div class="col-lg-12">
            <?php if($ItemsTop): ?>
                <h3>TOP</h3>
                <?php foreach ($ItemsTop as $item) :?>
                    <a href="#">
                        <div class="items_block">
                            <label class="text-muted text-left">Top</label>
                            <img src="/images/site/no_image.png" class="items_img">
                            <h4><?= $item->name ?></h4>
                            <h3 class="text-center"><?= '0'.'грн' ?></h3>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php endif;?>
        </div>

        <div class="col-lg-12">
            <?php if($ItemsStandard): ?>
                <h3>Standart</h3>
                <?php foreach ($ItemsStandard as $item) :?>
                    <a href="#">
                        <div class="items_block">
                            <label class="text-muted text-left">Standard</label>
                            <img src="/images/site/no_image.png" class="items_img">
                            <h4><?= $item->name ?></h4>
                            <h3 class="text-center"><?= $item->topmenu->itemsTransports[$item->items_id-1]->transportProps[0]->value.'грн' ?></h3>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php endif;?>
        </div>

    </div>
</div>
