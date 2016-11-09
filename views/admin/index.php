<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
?>
<div class="row">
    <div class="col-lg-12">
        <div class="btn-group" role="group" aria-label="...">
            <a href="<?= Url::toRoute('admin/moderation')?>" class="btn btn-warning">Товары на модерации (<?=$items_moderation?>)</a>
        </div>
    </div>
</div>