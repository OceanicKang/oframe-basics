<?php
namespace oframe\basics\backend\widgets\pages;

use Yii;
use oframe\basics\common\models\backend\Menu;
use common\enums\StatusEnum;

class MenuWidget extends \yii\base\Widget
{
    public function run()
    {
        if (!$menus = Yii::$app -> cache -> get(Menu::TYPE_SIDE)) {

            $menus = Menu::getMenus(Menu::TYPE_SIDE, StatusEnum::STATUS_ON);

            Yii::$app -> cache -> set(Menu::TYPE_SIDE, $menus);

        }

        return $this -> render('menu', [
            'menus' => $menus
        ]);
    }
}