<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\Properties;

?>

<div class="tires-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name_tires')->textInput()?>

    <?= $form->field($model, 'price_tires')->textInput(['type' => 'number'])?>

    <?= $form->field($model, 'brand_name_tires')->dropDownList(Properties::BREND_TIRES,['prompt' => Yii::t('cabinet', 'transport_items')['transport_tires_items']['brand_name_tires']])?>

    <?= $form->field($model, 'season_tires')->dropDownList(Properties::SEASON_TIRES,['prompt' => Yii::t('cabinet', 'transport_items')['transport_tires_items']['season_tires']])?>

    <?= $form->field($model, 'width_tires')->dropDownList(Properties::WIDTH_TIRES,['prompt' => Yii::t('cabinet', 'transport_items')['transport_tires_items']['width_tires']])?>

    <?= $form->field($model, 'side_view_tires')->dropDownList(Properties::SIDE_VIEW_TIRES,['prompt' => Yii::t('cabinet', 'transport_items')['transport_tires_items']['side_view_tires']])?>

    <?= $form->field($model, 'diameter_tires')->dropDownList(Properties::DIAMETER_TIRES,['prompt' => Yii::t('cabinet', 'transport_items')['transport_tires_items']['diameter_tires']])?>

    <?= $form->field($model, 'car_type_tires')->dropDownList(Properties::CAR_TYPE_TIRES,['prompt' => Yii::t('cabinet', 'transport_items')['transport_tires_items']['car_type_tires']])?>

    <?= $form->field($model, 'thorns_tires')->dropDownList(Properties::THORNS_TIRES,['prompt' => Yii::t('cabinet', 'transport_items')['transport_tires_items']['thorns_tires']])?>

    <?= $form->field($model, 'can_thorns_tires')->dropDownList(Properties::CAN_THORNS_TIRES,['prompt' => Yii::t('cabinet', 'transport_items')['transport_tires_items']['can_thorns_tires']])?>
    <?= $form->field($model, 'type_sales')->dropDownList(Properties::TYPE_SALES,['prompt' => Yii::t('cabinet', 'delivery')['delivery_no']])?>
    <?= $form->field($model, 'old_product')->checkbox(['label' => Yii::t('cabinet', 'old_product')['title']])?>

    <?= $form->field($model, 'descriptions_tires')->textarea()?>

    <?= $form->field($model, 'titleImage')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Добавить товар', ['class' => 'btn btn-success btn-block']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>