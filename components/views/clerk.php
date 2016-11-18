<?php
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

?>
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
    <div class="well" style="background-color: #d0eded">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <img src="<?=Url::home(true)?>images/site/no_image.png" alt="..." class="img-circle clerck_photo">
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                <p id = 'clerk_name'>Имя: <?=$profile->name?></p>
            </div>
        </div>
        <div class="row">
            <div class="panel-group col-lg-12 col-md-12 col-sm-12 col-xs-12 accordeone_clerk" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Смотреть телефны:
                            </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                            <ul>
                                <li><?=$profile->tel_first?></li>
                                <?php if($profile->tel_sec):?>
                                    <li><?=$profile->tel_sec?></li>
                                <?php endif;?>
                                <?php if($profile->tel_next):?>
                                    <li><?=$profile->tel_next?></li>
                                <?php endif;?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <p><span>Email:</span><?=$email?></p>
                <p><span>Город:</span><?=$profile->city?></p>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 input-group ref">
            <?= Html::a(
                'Написать владельцу',
                ['#'],
                [
                    'id'=>'clerk',
                    'data-toggle'=>'modal',
                    'data-target'=>'#modal-clerk',
                    'class'=>'btn btn-primary btn-block',
                    'style'=>'color:white',
                ]
            ) ?>
        </div>
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
        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">

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