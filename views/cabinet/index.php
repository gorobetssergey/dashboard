<?php
/* @var $this yii\web\View */
?>
<div class="row">
    <div class="col-lg-12">
        <div class="btn-group" role="group" aria-label="...">
            <a href="<?=\yii\helpers\Url::toRoute('get-my-moderation-items')?>" class="btn btn-warning">Товары на модерации (<?=$items_moderation?>)</a>
            <a href="<?=\yii\helpers\Url::toRoute('get-my-active-items')?>" class="btn btn-success">Активные товары (<?=$all_items?>)</a>
            <a href="<?=\yii\helpers\Url::toRoute('get-my-active-items')?>" class="btn btn-danger">Отказ модерации (<?=$moderation_er?>)</a>
        </div>
    </div>
</div>
