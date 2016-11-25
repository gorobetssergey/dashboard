<?php

use yii\helpers\Url;
use app\components\ClerkWidget;
use app\components\ViewItemsWidget;
use app\components\LikeWidget;
?>

<?php $result = Yii::$app->getSession()->getFlash('profile_successfully') ?>

<?php if($result): ?>
    <div class="<?= 'alert '.$result['color'] ?>" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong><?=$result['text']?></strong>
    </div>
<?php endif;?>
<div class="row">
    <?= ViewItemsWidget::widget([
        'photo' => $photo,
        'model' => $model,
        'countModel'=> $countModel,
        'description' => $description
    ])?>
    <?= ClerkWidget::widget([
        'user_profile' => $model->user,
        'mailer' => $mailer
    ])?>
</div>
<div class="row">
    <?= LikeWidget::widget([
        'data' => $data
    ])?>
</div>