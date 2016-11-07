<?php

use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;

?>

<div class="row">
    <div class="col-lg-12">
        <a href=""><div class="well well-lg">55</div></a>
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
                         return ($model->topmenu->itemsTransports[$index]['description']);
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
