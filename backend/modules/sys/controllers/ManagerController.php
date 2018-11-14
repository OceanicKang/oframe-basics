<?php
namespace oframe\basics\backend\modules\sys\controllers;

use Yii;
use common\models\backend\Manager;
use common\models\backend\AuthAssignment;

class ManagerController extends \backend\controllers\BController
{
    /**
     * 管理员列表
     *
     * @return string [<description>]
     */
    public function actionIndex()
    {
        $models = Manager::find() -> with(['roleName']) -> asArray() -> all();

        return $this -> render('index', [
            'models' => $models
        ]);
    }
}