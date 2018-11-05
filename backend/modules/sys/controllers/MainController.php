<?php
namespace oframe\basics\backend\modules\sys\controllers;

use Yii;
use oframe\basics\common\models\backend\Menu;
use common\enums\StatusEnum;

class MainController extends \backend\controllers\BController
{
    /**
     * 首页
     *
     * @return string [<description>]
     */
    public function actionIndex()
    {
        return $this -> render('index', [

        ]);
    }

    /**
     * 系统设置
     *
     * @return string [<description>]
     */
    public function actionSetting()
    {
        if (!$menus = Yii::$app -> cache -> get(Menu::TYPE_SYS)) {

            $menus = Menu::getMenus(Menu::TYPE_SYS, StatusEnum::STATUS_ON);

            Yii::$app -> cache -> set(Menu::TYPE_SYS, $menus);

        }

        return $this -> render('setting', [
            'menus' => $menus
        ]);
    }
}