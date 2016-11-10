<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\Properties;

?>

<div class="tires-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'value')->textInput(['type' => 'number'])?>

    <div class="form-group">
        <?= Html::submitButton('Изменить цену', ['class' => 'btn btn-success btn-block']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>