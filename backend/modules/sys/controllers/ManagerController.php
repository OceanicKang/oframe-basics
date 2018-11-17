<?php
namespace oframe\basics\backend\modules\sys\controllers;

use Yii;
use common\models\backend\Manager;
use common\models\backend\AuthAssignment;
use common\models\backend\AuthItem;

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

    /**
     * 简单 修改|添加 后台用户
     */
    public function actionEdit($id)
    {
        $model = $this -> findModel($id);

        $roles = AuthItem::getRoles();

        return $this -> render('edit', [
            'model' => $model,
            'roles' => $roles
        ]);
    }

    
    /**
     * 返回模型
     * @Author OceanicKang 2018-11-16
     */ 
    protected function findModel($id)
    {
        if (empty($id)) {

            $model = new Manager;

            return $model -> loadDefaultValues();

        }

        if (empty($model = Manager::findOne($id))) {

            $model = new Manager;

            return $model -> loadDefaultValues();

        }

        return $model;
    }
}