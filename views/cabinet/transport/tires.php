<?php
$result = Yii::$app->getSession()->getFlash('add_new_items_ok');
$result1 = Yii::$app->getSession()->getFlash('add_new_items_err');
?>

<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <h3 class="text-center">TIRES</h3>
        <?php if($result):?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong><?=$result?></strong>
            </div>
        <?php endif;?>
        <?php if($result1):?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong><?=$result1?></strong>
            </div>
        <?php endif;?>
        <?= $this->render('forms/_forms_tires', [
            'model' => $items,
        ]) ?>
    </div>
</div>

