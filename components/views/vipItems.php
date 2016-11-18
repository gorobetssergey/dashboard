<?php
use yii\helpers\Url;

?>

<?php if($ItemsVip): ?>
    <h3><?=$title?></h3>
    <?php foreach ($ItemsVip as $item) :?>
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <a href="<?=Url::toRoute('view?items='.$item->id)?>">
                <div class="<?=$it_style?>">
                    <h4 class="text-muted text-center"><?= $item->name ?></h4>
                    <img src="<?=Url::home(true)?>images/items/<?=$modelVip[$item->id]?>" class="items_img">
                    <h3 class="text-center"><?= $item->topmenu->itemsTransports[$item->items_id-1]->transportProps[0]->value.'грн' ?></h3>
                </div>
            </a>
        </div>
    <?php endforeach; ?>
<?php endif;?>