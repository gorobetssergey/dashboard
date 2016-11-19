<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\models\Items;
use app\models\Locality;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\SiteAsset;
use app\models\Users;
use kartik\typeahead\Typeahead;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

SiteAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Boards',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
        ['label' => 'About', 'url' => ['/site/about']],
        ['label' => 'Contact', 'url' => ['/site/contact']],
    ];
    if(Yii::$app->user->isGuest):
        $menuItems[]=[
            'label' => 'Войти',
            'url' => ['/site/login']
        ];
        $menuItems[]=[
            'label' => 'Регистрация',
            'url' => ['/site/reg']
        ];
    else:
        if(Yii::$app->user->identity->role==Users::ROLE_USER):
            $menuItems[] = [
                'label' => 'Кабинет', 'url' => ['/cabinet/index'],
            ];
            elseif(Yii::$app->user->identity->role==Users::ROLE_ADMIN):
                $menuItems[] = [
                    'label' => 'Админка', 'url' => ['/admin/index'],
                ];
        endif;
        $menuItems[]=[
            'label' => 'Выйти (' . Yii::$app->user->identity->email . ')',
            'url' => ['/site/logout'],
            'linkOptions' => [
                'data-method' => 'post'
            ]
        ];
    endif;

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 col-lg-offset-1 col-md-offset-1">
                <?php
                $form = ActiveForm::begin();
                echo $form->field(new Items(), 'name')->label(false)->widget(Typeahead::classname(), [
                    'options' => ['placeholder' => Yii::t('site', 'product_name')],
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
                ActiveForm::end();
                ?>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 col-lg-offset-1 col-md-offset-1">
                <?php
                $forms = ActiveForm::begin();
                echo $forms->field(new Locality(), 'title')->label(false)->widget(Typeahead::classname(), [
                    'name' => 'title',
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
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
