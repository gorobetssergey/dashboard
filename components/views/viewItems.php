<?php
use yii\helpers\Url;
use app\models\Properties;
?>
<div class="col-lg-8">
    <div class="row">
        <div class="col-lg-12">
            <h3 class="text-info text-center"><?=$model->transportProps[count($model->transportProps)-1]->value.'. Стоимость '.$model->transportProps[0]->value?> Грн</h3>
        </div>
        <div class="col-lg-6 text-center" style="overflow: hidden">
            <div class="row">
                <div class="col-lg-12">
                    <img src="<?=Url::home(true)?>images/items/<?=$photo[1].'/'.$photo[0]->title?>" class="items_img img-rounded">
                </div>
                <div class="col-lg-12">
                    <div class="well">
                        <h4>Галерея</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <table class="table">
                <tr>
                    <th>Свойство товара</th>
                    <th>Значение</th>
                </tr>
                <?php $count = 0; foreach ($model->transportProps as $data): $count++;?>
                    <?php ?>
                    <tr>
                        <td>
                            <?php
                            if(Yii::t('cabinet','transport_items')['transport_tires_items'][$data->prop->name]){
                            echo Yii::t('cabinet','transport_items')['transport_tires_items'][$data->prop->name];
                            }
                            elseif($data->prop->name == Properties::TYPE_SALES_ALL){
                            echo Yii::t('cabinet', 'delivery')['title'];
                            }
                            elseif($data->prop->name == Properties::OLD_PRODUCT_ALL){
                            echo Yii::t('cabinet', 'old_product')['title'];
                            }
                            ?>
                        </td>
                        <td><?=$data->value?></td>
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