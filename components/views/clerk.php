<?php
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;

?>
<?php $result = Yii::$app->getSession()->getFlash('profile_successfully') ?>

<?php if($result): ?>
    <div class="<?= 'alert '.$result['color'] ?>" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong><?=$result['text']?></strong>
    </div>
<?php endif;?>
<div class="col-lg-3">
    <div class="well">
        <div class="col-lg-4 input-group ref">
            <?= Html::a(
                'Написать владельцу',
                ['#'],
                [
                    'id'=>'clerk',
                    'data-toggle'=>'modal',
                    'data-target'=>'#modal-clerk',
                    'class'=>'btn btn-primary',
                    'style'=>'color:white',
                ]
            ) ?>
        </div>
        <h3>Имя: <?=$profile->name?></h3>
        <h3>Телефон: <?=$profile->tel_first?></h3>
        <h3>Email: <?=$email?></h3>
        <h3>Город: <?=$profile->city?></h3>
    </div>
</div>
<?php
    Modal::begin([
        'options'=>[
            'id'=>'modal-clerk'
        ],
        'size'=>'modal-lg'
    ]);
?>
    <div class="row">
        <div class="col-lg-12">

            <?php $form = ActiveForm::begin(['id' => 'mailer-form']); ?>

            <?= $form->field($mailer, 'fromEmail') ?>

            <?= $form->field($mailer, 'subject') ?>

            <?= $form->field($mailer, 'body')->textArea(['rows' => 6]) ?>

            <div class="form-group">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
<?php
    Modal::end();
?>