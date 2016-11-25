<?php
use app\components\AfterSearchWidget;

?>

<?= AfterSearchWidget::widget([
    'items' => $model,
])?>