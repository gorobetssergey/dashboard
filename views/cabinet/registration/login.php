<?php
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;
    use yii\helpers\Url;
?>
<div class="container">
    <div class="row">
        <h2>Аутентификация</h2>
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'email')->textInput() ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= Html::submitInput('вход', ['class'=>'btn btn-success button_float_l']) ?>
        <?php ActiveForm::end(); ?>
        <?= '  &nbsp&nbsp или ' ?>
        <?= Html::a('отмена', Url::toRoute('site/index'), ['class'=>'btn btn-info button_margin_l']) ?>
    </div>
</div>

