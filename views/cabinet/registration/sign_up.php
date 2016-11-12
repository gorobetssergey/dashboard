<?php
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;
    use yii\helpers\Url;
?>
<div class="container">
    <div class="row">
        <h2>Реєстрация</h2>
        <?php $result = Yii::$app->getSession()->getFlash('registration_error') ?>
        <?php if($result != false){?>
            <div class="<?= 'alert alert-warning' ?>" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong><?=$result?></strong>
            </div>
        <?php }?>
        <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'email')->textInput() ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= Html::submitInput('зарегистрироваться', ['class'=>'btn btn-success button_float_l']) ?>
        <?php ActiveForm::end(); ?>
        <?= '  &nbsp&nbsp или ' ?>
        <?= Html::a('войти', Url::toRoute('cabinet/login'), ['class'=>'btn btn-info button_margin_l']) ?>

    </div>
</div>
