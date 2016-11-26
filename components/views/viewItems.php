<?php
use yii\helpers\Url;
use app\models\Properties;
?>
<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3 class="text-info text-center"><?=$model->transportProps[count($model->transportProps)-1]->value.'. Стоимость '.$model->transportProps[0]->value?> Грн</h3>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center" style="overflow: hidden">
            <div class="row">
<!--                <div class="col-lg-12">-->
<!--                    <img src="--><?//=Url::home(true)?><!--images/items/--><?//=$photo[1].'/'.$photo[0]->title?><!--" class="items_img">-->
<!--                </div>-->
<!--                <div class="col-lg-12">-->
<!--                    <div class="well">-->
<!--                        <h4>Галерея</h4>-->
<!--                    </div>-->
<!--                </div>-->
                <div class="col-lg-12">
                    <div>
                            <img id="0" src="<?=Url::home(true)?>images/items/<?=$photo[1].'/'.$photo[0]->title?>" class="items_img click_photo image_pointer">
                            <ul class="pager_fixed pager_important pager">
                                <li class="previous"><a class="p_left image_pointer glyphicon glyphicon-triangle-left"></a></li>
                                <li class="next"><a class="p_right image_pointer glyphicon glyphicon-triangle-right"></a></li>
                            </ul>
                    </div>
                    <div class="gallery_height row">
                        <?php   $max_file = 11;
                                $photo_one = '';
                        for($i=0; $i<$max_file; $i++):
                            switch($i){
                                case 0 : {$photo_one = $photo[0]->title;}break;
                                case 1 : {$photo_one = $photo[0]->photo_1;}break;
                                case 2 : {$photo_one = $photo[0]->photo_2;}break;
                                case 3 : {$photo_one = $photo[0]->photo_3;}break;
                                case 4 : {$photo_one = $photo[0]->photo_4;}break;
                                case 5 : {$photo_one = $photo[0]->photo_5;}break;
                                case 6 : {$photo_one = $photo[0]->photo_6;}break;
                                case 7 : {$photo_one = $photo[0]->photo_7;}break;
                                case 8 : {$photo_one = $photo[0]->photo_8;}break;
                                case 9 : {$photo_one = $photo[0]->photo_9;}break;
                                case 10 : {$photo_one = $photo[0]->photo_10;}break;
                            }
                            if(! $photo_one){
                                continue;
                            }
                        ?>
                            <img id="<?= $i ?>" src="<?=Url::home(true)?>images/items/<?=$photo[1].'/'.$photo_one?>" class="gallery_img_border_standard gallery_img image_pointer">
                        <?php endfor;?>
                        <span id="max_images" data-max_file="<?= $i ?>"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <table class="table">
                <tr>
                    <th>Свойство товара</th>
                    <th>Значение</th>
                </tr>
                <?php $count = 0; foreach ($model->transportProps as $key => $data): $count++;if($key == 11)continue; ?>

                    <?php ?>
                    <tr>
                        <td>
                            <?= Yii::t('cabinet','transport_items')['transport_tires_items'][$data->prop->name]?>
                        </td>
                        <td>
                            <?php if($key != 9){?>
                                <?=$data->value?>
                            <?php } else{ ?>
                                <ul>
                                    <?php   echo Properties::prepare($data->value); ?>
                                </ul>
                            <?php }?>
                        </td>
                    </tr>
                <?php endforeach;?>
            </table>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="well">
            <h4><?= $description?></h4>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal  fade" id="photoModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <img  src="" class="show_image image_modal">
            </div>
        </div>
    </div>
</div>
<?php
    $this->registerJsFile('js/site/images_gallery.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>