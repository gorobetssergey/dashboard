<?php

use yii\widgets\DetailView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

use app\models\Properties;
?>
<div class="row">
    <div class="col-lg-12">
        <table class="table">
            <tr>
                <th>Свойство товара</th>
                <th>Значение свойства</th>
            </tr>
            <?php foreach ($model->transportProps as $item): ?>
                <tr>
                    <td><?php

                        if(Yii::t('cabinet','transport_items')['transport_tires_items'][$item->prop->name]){
                            echo Yii::t('cabinet','transport_items')['transport_tires_items'][$item->prop->name];
                        }
                        elseif($item->prop->name == Properties::TYPE_SALES_ALL){
                            echo Yii::t('cabinet', 'delivery')['title'];
                        }
                        elseif($item->prop->name == Properties::OLD_PRODUCT_ALL){
                            echo Yii::t('cabinet', 'old_product')['title'];
                        }
                        ?>
                    </td>
                    <td><?=$item->value?></td>
                </tr>
            <?php endforeach;?>
        </table>
    </div>
    <div class="col-lg-6">
        <?php $form = ActiveForm::begin([
                'action' => 'moderation',

        ]); ?>

        <?= $form->field($model, 'id')->hiddenInput(['value'=>$id])->label(false) ?>
        <?= $form->field($model, 'solve')->textInput()->hiddenInput()->label(false) ?>
        <?= Html::submitButton('Разрешить', ['class' => 'btn btn-success btn-block']) ?>

        <?php ActiveForm::end(); ?>
    </div>
    <div class="col-lg-6">
        <?php $form = ActiveForm::begin([
            'action' => 'moderation',

        ]); ?>

        <?= $form->field($model, 'id')->hiddenInput(['value'=>$id])->label(false) ?>
        <?= $form->field($model, 'rejection_reason')->textInput(['required ' => 'required '])->label('Причина отказа') ?>

        <?= Html::submitButton('Запретить', ['class' => 'btn btn-danger btn-block']) ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>
