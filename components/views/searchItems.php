<?php

use yii\widgets\ActiveForm;
use kartik\typeahead\Typeahead;
use yii\helpers\Html;
use yii\helpers\Url;

$this->registerCssFile('components/css/search.css', ['depends' => [\yii\web\JqueryAsset::className()]]);

?>

<div class="row top_margin">
    <?php
    $form = ActiveForm::begin([
        'method' => 'post',
        'action' => Url::home(true).'site/find-like-items'
    ]);
    ?>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 col-lg-offset-1 col-md-offset-1">
        <?php
        echo $form->field($items, 'name')->label(false)->widget(Typeahead::classname(), [
            'options' => ['placeholder' => Yii::t('site', 'product_name'),
            ],
            'pluginOptions' => ['highlight'=>true],
            'dataset' => [
                [
                    'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                    'display' => 'value',
                    'remote' => [
                        'url' => Url::to(['site/get-name']) . '?s=%QUERY',
                        'wildcard' => '%QUERY'
                    ]
                ]
            ],
            'pluginOptions' => ['highlight' => true],
        ]);
        ?>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 col-lg-offset-1 col-md-offset-1">
        <?php
        echo $form->field($city, 'title')->label(false)->widget(Typeahead::classname(), [
            'name' => 'title_city',
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
    </div>
    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
        <?= Html::submitInput('Найти', ['class'=>'btn btn-info btn-block']) ?>
    </div>
    <?php ActiveForm::end();?>
</div>