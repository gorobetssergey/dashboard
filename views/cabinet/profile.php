<?php
 use yii\helpers\Html;
 use yii\widgets\ActiveForm;
    use yii\helpers\Url;


/**
 * @var $model
 */

?>


<h2>Профиль</h2>
<div class="container">
    <div class="row">
        <?php $form = ActiveForm::begin() ?>
            <?= $form->field($model,'user_id')->hiddenInput()->label(false) ?>
            <?= $form->field($model,'tel_first')->textInput(['class'=>'col-4 input-sm']) ?>
            <?= $form->field($model,'tel_sec')->textInput(['class'=>'col-4 input-sm']) ?>
            <?= $form->field($model,'tel_next')->textInput(['class'=>'col-4 input-sm']) ?>
            <?= $form->field($model,'name')->textInput(['class'=>'col-4 input-sm']) ?>
            <?= $form->field($model,'surname')->textInput(['class'=>'col-4 input-sm']) ?>
            <?= $form->field($model,'patronymic')->textInput(['class'=>'col-4 input-sm']) ?>
            <?= $form->field($model,'city')->textInput(['class'=>'col-4 input-sm']) ?>
            <?= Html::submitInput('сохранить', ['class'=>'btn btn-success button_float_l']) ?>
        <?php ActiveForm::end() ?>
        <?= Html::a('отмена', Url::toRoute('cabinet/index'), ['class'=>'btn btn-danger button_margin_l']) ?>
    </div>
</div>
