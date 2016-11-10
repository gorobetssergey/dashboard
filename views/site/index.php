<?php

/* @var $this yii\web\View */
/* @var $ItemsVip */
/* @var $ItemsTop */
/* @var $ItemsStandard */

$this->title = 'Главная';
?>
<div class="container">
    <div class="row">
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
        <?php foreach ($ItemsStandard as $item) :?>
            <a href="#">
                <div class="items_block">
                    <label class="text-muted text-left">Standard</label>
                    <img src="/images/site/no_image.png" class="items_img">
                    <h4><?= $item->name ?></h4>
                    <h3 class="text-center"><?= '0'.'грн' ?></h3>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>
