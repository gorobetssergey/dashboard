<?php
use yii\helpers\Url;
use yii\web\View;

/**
 * @property object $menus
 */

 $this->registerCssFile('components/css/top_menu.css', ['depends' => [\yii\web\JqueryAsset::className()]]);
 $this->registerJsFile('components/js/menu.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_END]);
?>
<div class="">
    <div data-count_menus="<?= $count_menus ?>" class="display_menu width_page">
        <ul class="ul_style">
            <!--           Main menu -->
            <?php foreach ($menus as $key => $menu): ?>
            <a href="#">
                <li id="<?= $key ?>" class="color_menu ul_menu li_style">
                    <?= Yii::t('cabinet', 'menu')[$menu->title]?>
                </li>
            </a>
        <?php endforeach; ?>
<!--          button to more menu  -->
            <a href="#">
                <li id="-1" class="color_menu ul_menu li_style glyphicon glyphicon-menu-right">

                </li>
            </a>
        </ul>

    </div>
    <div class="pointer hide"></div>
    <div class="pointer_main hide"></div>

<!-- Sub Menu -->
<?php

    for($i=0; $i<$count_sub_menus; $i++):
        $count_title = count($sub_menus[$i]);
        ?>
<div id="sub_menu<?= $i ?>" class="sub_menu hide">
    <li class="ul_sub_menu sub_menu_left text-center">
        <div class="sub_menu_left_style">
        </div>
    </li>
    <ul class="ul_sup" data-sub_menu_count="<?= $count_title ?>">
    <?php
    for($j=0; $j<$count_title; $j++): ?>
        <a href="#" >
            <li id="<?= $j ?>" class="ul_sub_menu li_sub_style text-center">
                <img class="img_sub" src="/images/site/menu/sub_menu/laptop.png">
                    <?= $sub_menus[$i][$j] ?>
            </li>
        </a>
    <?php endfor; ?>
        <a href="#" >
            <li class="ul_sub_menu sub_menu_right text-center">
                <div>
                    <span id="0" class="excess_sub_menu glyphicon glyphicon-menu-right menu_left_right"></span>
                </div>
            </li>
        </a>
    </ul>
    <a href="#" >
        <li class="ul_sub_menu sub_menu_right text-center">
            <div>
                <span id="1" class="excess_sub_menu glyphicon glyphicon-menu-left menu_left_right hide"></span>
            </div>
        </li>
    </a>
</div>
<?php endfor; ?>
<!-- Menu to button More menu -->
<!--    <div id="sub_menu--><?//= '-'.$i ?><!--" class="sub_menu_all hide">-->
<!--        <ul class="ul_more">-->
<!--            --><?php //foreach ($menus as $key => $menu): ?>
<!--                <a href="#">-->
<!--                    <li id="--><?//= '-'.$key ?><!--" class="color_menu ul_menu_all li_style_more">-->
<!--                        --><?//= Yii::t('cabinet', 'menu')[$menu->title]?>
<!--                    </li>-->
<!--                </a>-->
<!--            --><?php //endforeach; ?>
<!--        </ul>-->
<!--    </div>-->
</div>

