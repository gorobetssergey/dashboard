<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use yii\helpers\Url;
use kartik\typeahead\Typeahead;

/**
 * @var $model
 */

?>
<?php $result = Yii::$app->getSession()->getFlash('profile_successfully') ?>
<div class="container">
    <?php if($result): ?>
        <div class="<?= 'alert '.$result['color'] ?>" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong><?=$result['text']?></strong>
        </div>
    <?php endif;?>
    <h2>Профиль</h2>
    <div class="text-center">
        <span class="text-muted">Для доступа к функцианалу создания заявок нужно <b>заполнить профиль</b></span> <?= Html::a('Пропустить, сделать пустой профиль', Url::toRoute('cabinet/index'), ['class'=>'btn btn-info']) ?>
    </div>
    <div class="row">
        <?php $form = ActiveForm::begin() ?>
            <?= $form->field($model,'tel_first')->textInput(['class'=>'col-4 input-sm']) ?>
            <?= $form->field($model,'tel_sec')->textInput(['class'=>'col-4 input-sm']) ?>
            <?= $form->field($model,'tel_next')->textInput(['class'=>'col-4 input-sm']) ?>
            <?= $form->field($model,'name')->textInput(['class'=>'col-4 input-sm']) ?>
            <?= $form->field($model,'surname')->textInput(['class'=>'col-4 input-sm']) ?>
            <?= $form->field($model,'patronymic')->textInput(['class'=>'col-4 input-sm']) ?>
            <?= $form->field($model, 'city')->widget(Typeahead::classname(), [
                'options' => ['placeholder' => Yii::t('site', 'city_name')],
                'pluginOptions' => ['highlight'=>true],
                'dataset' => [
                    [
                        'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                        'display' => 'value',
                        'remote' => [
                            'url' => Url::to(['site/get-town']) . '?s=%QUERY',
                            'wildcard' => '%QUERY'
                        ]
                    ]
                ],
                'pluginOptions' => ['highlight' => true],
            ]);
            ?>
            <?= $form->field($model,'ownership')->dropDownList($ownership, ['class'=>'col-4 input-sm', 'selected' => $self_ownership]) ?>
            <?= Html::submitInput('сохранить', ['class'=>'btn btn-success button_float_l']) ?>
        <?php ActiveForm::end() ?>
        <?= Html::a('отмена', Url::toRoute('cabinet/index'), ['class'=>'btn btn-danger button_margin_l']) ?>
    </div>
</div>
