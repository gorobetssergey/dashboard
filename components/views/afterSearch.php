<?php
use yii\helpers\Url;

?>

<?php if($items): ?>
    <?php foreach ($items as $item) :?>
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <a href="<?=Url::toRoute('view?items='.$item['id'])?>">
                <div class="items_vips">
                    <h4 class="text-muted text-center"><?= $item['name'] ?></h4>
                    <img src="<?=Url::home(true)?>images/items/<?=$item['photo']?>" class="items_img">
                    <h3 class="text-center"><?= $item['price']['value'].' грн' ?></h3>
                </div>
            </a>
        </div>
    <?php endforeach; ?>
<?php endif;?>
