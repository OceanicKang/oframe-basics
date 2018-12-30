<?php
namespace oframe\basics\backend\modules\sys\controllers;

use Yii;
use common\models\backend\Manager;
use common\models\backend\AuthAssignment;
use common\models\backend\AuthItem;
use oframe\basics\backend\modules\sys\models\Search;
use yii\data\Pagination;

class ManagerController extends \backend\controllers\BController
{
    /**
     * 管理员列表
     *
     * @return string
     */
    public function actionIndex()
    {
        $roles = AuthItem::getRoles();

        $search = new Search;

        $get = Yii::$app -> request -> get();

        $search -> load($get);

        $data = Manager::find()
                -> andFilterWhere([ 'mobile_phone' => $search -> mobile_phone,
                                    'email' => $search -> email,
                                    'role_id' => $search -> role_id])
                -> andFilterWhere(['like', 'username', $search -> username])
                -> with(['roleName']);

        $pages = new Pagination(['totalCount' => $data -> count(), 'pageSize' => $this -> _pageSize]);

        $models = $data
                -> offset($pages -> offset)
                -> limit($pages -> limit)
                -> asArray()
                -> all();

        return $this -> render('index', [
            'models' => $models,
            'pages' => $pages,
            'roles' => $roles,
            'search' => $search,
        ]);
    }

    /**
     * 简单 修改|添加 后台用户
     *
     * @return string
     */
    public function actionEdit($id)
    {
        $model = $this -> findModel($id);

        $roles = AuthItem::getRoles();

        if (Yii::$app -> request -> isPost) {

            $old_hash_password = $model -> password_hash;

            $model -> load(Yii::$app -> request -> post());

            if (!$model) return $this -> message($this -> analysisError($model -> getFirstErrors()), $this -> redirect(['index']), 'error');

            if ($old_hash_password != $model -> password_hash) $model -> setPassword($model -> password_hash);       // hash 密码

            AuthAssignment::add($model -> role_id, $model -> id); // 分配角色

            return $model -> save() ?
                    $this -> message('保存成功', $this -> redirect(['index'])) :
                    $this -> message($this -> analysisError($model -> getFirstErrors()), $this -> redirect(['index']), 'error');

        }

        return $this -> render('edit', [
            'model' => $model,
            'roles' => $roles
        ]);
    }

    /**
     * 删除用户
     *
     * @return string
     */
    public function actionDelete($id)
    {
        $model = $this -> findModel($id);

        return $model -> delete() ?
                $this -> message('删除成功', $this -> redirect(['index'])) :
                $this -> message($this -> analysisError($model -> getFirstErrors()), $this -> redirect(['index']), 'error');
    }

    /**
     * 用户详情
     * @Author OceanicKang 2018-12-13
     * @param int $id 用户ID
     * @return string
     */
    public function actionDetail($id)
    {
        $model = $this -> findModel($id);

        return $this -> render('detail', [
            'model' => $model
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