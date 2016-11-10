<?php

$result = Yii::$app->getSession()->getFlash('edit_items_price_ok');
$result2 = Yii::$app->getSession()->getFlash('edit_items_price_err');
?>
<?php if($result):?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong><?=$result?></strong>
    </div>
<?php endif;?>
<?php if($result2):?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong><?=$result?></strong>
    </div>
<?php endif;?>
<?= $this->render('_forms/_edit_price', [
    'model' => $model,
]) ?>