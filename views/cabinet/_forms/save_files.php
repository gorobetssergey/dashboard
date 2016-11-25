<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

/**
 * @parems $model object
 */
?>
<div class="container">
    <div class="row">
        <h2>Добавить картинки в галерею</h2>
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

        <?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*', 'class'=>'btn btn-info']) ?>

        <button class="btn btn-success no_gallery">Добавить в галерею</button>
        <?php ActiveForm::end() ?>
        <a href="new-items" class="btn btn-warning">без фото, пропустить</a>

    </div>
</div>