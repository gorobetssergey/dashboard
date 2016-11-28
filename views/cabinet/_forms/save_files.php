<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

/**
 * @parems $model object
 */
$result = Yii::$app->getSession()->getFlash('add_new_items_ok');
$result1 = Yii::$app->getSession()->getFlash('add_new_items_err');
?>
<div class="container">
    <div class="row">
        <h2>Добавить картинки в галерею</h2>
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
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

        <?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*', 'class'=>'btn btn-info']) ?>

        <button class="btn btn-success no_gallery">Добавить в галерею</button>
        <?php ActiveForm::end() ?>
        <a href="new-items" class="btn btn-warning">без фото, пропустить</a>

    </div>
</div>