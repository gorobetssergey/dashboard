<?php
use yii\helpers\Url;

/**
 * @property object $menus
 */

 $this->registerCssFile('components/css/top_menu.css', ['depends' => [\yii\web\JqueryAsset::className()]]);
 $this->registerJsFile('components/js/menu.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<div class="">
    <div data-count_menus="<?= $count_menus ?>" class="display_menu">
        <ul class="ul_style">
        <?php foreach ($menus as $key => $menu): ?>
            <a href="#">
                <li id="<?= $key ?>" class="color_menu ul_menu li_style">
                    <?= Yii::t('cabinet', 'menu')[$menu->title]?>
                </li>
            </a>
        <?php endforeach; ?>
            <a href="#">
                <li id="-1" class="color_menu ul_menu li_style">
                    <?= Yii::t('cabinet', 'menu')['more']?>
                </li>
            </a>
        </ul>

    </div>
</div>
<?php
    for($i=0; $i<$count_sub_menus; $i++):
?>
<div id="sub_menu<?= $i ?>" class="sub_menu collapse">
    <ul class="ul_sup">
    <?php
    $count_title = count($sub_menus[$i]);
    for($j=0; $j<$count_title; $j++): ?>
        <a href="#" >
            <li id="<?= $j ?>" class="ul_sub_menu li_sub_style text-center">
                <img class="img_sub" src="/images/site/menu/sub_menu/laptop.png">
                    <?= wordwrap($sub_menus[$i][$j], 12, "<br />\n"); ?>
            </li>
        </a>
    <?php endfor; ?>
    </ul>
</div>
<?php endfor; ?>
<?php
for($i=0; $i<$count_sub_menus; $i++):
    ?>
    <div id="sub_menu<?= '-'.$i ?>" class="sub_menu_all collapse">
        <ul class="ul_sup ul_more">
            <?php foreach ($menus as $key => $menu): ?>
                <a href="#">
                    <li id="<?= '-'.$key ?>" class="color_menu ul_menu_all li_style_more">
                        <?= Yii::t('cabinet', 'menu')[$menu->title]?>
                    </li>
                </a>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endfor; ?>

