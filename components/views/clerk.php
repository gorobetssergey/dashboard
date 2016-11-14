<?php
use yii\helpers\Html;
use yii\bootstrap\Modal;

?>
<div class="col-lg-3">
    <div class="well">
        <div class="col-lg-4 input-group ref">
            <?= Html::a(
                'Найти пользователя',
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
    <h3>форма отправки сообщения</h3>
<?php
    Modal::end();
?>