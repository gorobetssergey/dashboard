<?php

use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
$result = Yii::$app->getSession()->getFlash('moderation_ok');
$result1 = Yii::$app->getSession()->getFlash('moderation_no');
?>

<div class="row">
    <div class="col-lg-12">
        <?php if($result):?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong><?=$result?></strong>
            </div>
        <?php endif;?>
        <?php if($result1):?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong><?=$result1?></strong>
            </div>
        <?php endif;?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'label' => 'Топменю',
                    'format' => 'raw',
                    'value' => function ($model, $key, $index) {
                        return Yii::t('cabinet', $model->topmenu->title);
                    },
                ],
                [
                    'label' => 'Описание товара',
                    'format' => 'raw',
                    'value' => function ($model, $key, $index) {
                         return ($model->topmenu->getItemsTable($model)[$key-1]->description);
                    },
                ],

                [
                    'label' => 'Просмотреть',
                    'format' => 'raw',
                    'value' => function ($model, $key, $index) {
                        $url = Url::toRoute('view-items?id='.$key.'');
                        return Html::a('Просмотреть', $url, [
                            'title' => 'Просмотреть',
                            'data-pjax' => '0',
                        ]);
                    },
                ],
                [
                    'label' => 'Удалить',
                    'format' => 'raw',
                    'value' => function ($model, $key, $index) {
                        $url = Url::toRoute('change-consumption?id='.$key.'');
                        return Html::a('Удалить', $url, [
                            'title' => 'Удалить',
                            'data-pjax' => '0',
                        ]);
                    },
                ],
                [
                    'label' => 'Разрешить',
                    'format' => 'raw',
                    'value' => function ($model, $key, $index) {
                        $url = Url::toRoute('change-consumption?id='.$key.'');
                        return Html::a('Разрешить', $url, [
                            'title' => 'Разрешить',
                            'data-pjax' => '0',
                        ]);
                    },
                ],
            ],
        ]); ?>
    </div>
</div>
