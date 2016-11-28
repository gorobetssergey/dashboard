<?php


namespace app\components;
use app\models\SubCat;
use app\models\Topmenu;
use yii\base\Widget;
use Yii;

/**
 * Class WidgetTopMenu
 * @package app\components
 */
class WidgetTopMenu extends Widget
{
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
    }

    public function run()
    {
        $menu = new Topmenu();
        $menus = $menu->getTopMenu();
        $count_menus = count($menus);
        $modelSutegoryes = new SubCat();
        $list_sub_categoryes = $modelSutegoryes->getList();
        $model = array();
        foreach ($list_sub_categoryes as $key => $item){
            $count_model = $modelSutegoryes->getListSubMenu($item->id_sub);
            foreach ($count_model as $i => $id_title)
                $model[$key][$i] = Yii::t('cabinet', 'sub_menu')[$id_title->idCat->title];
        }
        $count_model = count($model);

        return $this->render('top_menu',[
            'menus' => $menus,
            'count_menus' => $count_menus,
            'sub_menus' => $model,
            'count_sub_menus' => $count_model
        ]);
    }
}