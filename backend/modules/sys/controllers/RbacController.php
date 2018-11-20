<?php
namespace oframe\basics\backend\modules\sys\controllers;

use Yii;
use common\models\backend\AuthItem;
use common\models\backend\AuthItemChild;
use common\models\backend\AuthAssignment;
use oframe\basics\common\helpers\SysArrayHelper;
use common\models\backend\Manager;

class RbacController extends \backend\controllers\BController
{
    // 权限 accredit =========================================
    
    /**
     * 权限列表
     *
     * @return string [<description>]
     */
    public function actionAccredit()
    {
        $accredit = AuthItem::getAuths();

        return $this -> render('accredit', [
            'models' => $accredit
        ]);
    }

    /**
     * 编辑|新增 权限
     *
     * @return string [<description>]
     */
    public function actionAccreditEdit()
    {
        $request = Yii::$app -> request;

        $id = $request -> get('id');

        $model = $this -> findModel($id);

        $pid = $request -> get('pid');

        $level = $request -> get('level');

        $p_title = $request -> get('p_title');

        $p_name = $request -> get('p_name');

        if ($request -> isPost) {

            return ($model -> load($request -> post()) && $model -> save()) ?
                    $this -> message('操作成功', $this -> redirect(['accredit'])) :
                    $this -> message($this -> analysisError($model -> getFirstErrors()), $this -> redirect(['accredit']), 'error');

        }

        return $this -> render('accredit-edit', [
            'model'   => $model,
            'pid'     => $pid,
            'level'   => $level,
            'p_title' => $p_title,
            'p_name'  => $p_name
        ]);
    }

    /**
     * 删除 权限
     *
     * @return string [<description>]
     */
    public function actionAccreditDel($id)
    {
        if ($model = $this -> findModel($id)) {

            if (in_array($model -> name, Yii::$app -> params['notDelRbacUrl']))
                return $this -> message('该权限为系统核心权限，禁止删除', $this -> redirect(['accredit']), 'error');

            $cate = AuthItem::findAll(['type' => AuthItem::AUTH]);

            $child = SysArrayHelper::getChildsId($cate, $id);

            if ($child) return $this -> message('存在子权限，禁止删除', $this -> redirect(['accredit']), 'error');

            return $model -> delete() ?
                    $this -> message('删除成功', $this -> redirect(['accredit'])) :
                    $this -> message($this -> analysisError($model -> getFirstErrors()), $this -> redirect(['accredit']), 'error');

        }

        return $this -> message('未找到该权限', $this -> redirect(['accredit']), 'error');
    }


    /**
     * 给角色分配权限
     *
     * @return string [<description>]
     */
    public function actionAccreditAssign($parent)
    {
        $model = new AuthItemChild;

        $accredit = AuthItem::getAuths();

        $AuthItemChild = AuthItemChild::find()
                            -> where(['parent' => $parent])
                            -> asArray() -> all();

        $AuthItemChild = array_column($AuthItemChild, 'child');

        if (Yii::$app -> request -> isPost) {

            $post = Yii::$app -> request -> post();

            $post['child'] = $post['child'] ?? [];

            $result = AuthItem::setAccreditAssign($parent, $post['child']);

            return $result !== true ?
                    $this -> message($result, $this -> redirect(['accredit-assign', 'parent' => $parent]), 'error') :
                    $this -> message('权限分配成功', $this -> redirect(['accredit-assign', 'parent' => $parent]));

        }

        return $this -> render('accredit-assign', [
            'model' => $model,
            'parent' => $parent,
            'accredit' => $accredit,
            'AuthItemChild' => $AuthItemChild
        ]);
    }

    // 角色 role =========================================
    
    /**
     * 角色列表
     *
     * @return string [<description>]
     */
    public function actionRole()
    {
        $models = AuthItem::find()
                -> where(['type' => AuthItem::ROLE])
                -> orderBy('sort asc, id asc')
                -> asArray()
                -> all();

        return $this -> render('role', [
            'models' => $models
        ]);
    }

    /**
     * 编辑|新增
     *
     * @return string [<description>]
     */
    public function actionRoleEdit($id)
    {
        $model = $this -> findModel($id);

        if (Yii::$app -> request -> isPost) {

            return ($model -> load(Yii::$app -> request -> post()) && $model -> save()) ?
                    $this -> message('操作成功', $this -> redirect(['role'])) :
                    $this -> message($this -> analysisError($model -> getFirstErrors()), $this -> redirect(['role']), 'error');

        }

        return $this -> render('role-edit', [
            'model' => $model
        ]);
    }

    /**
     * 删除 角色
     *
     * @return string [<description>]
     */
    public function actionRoleDel($id)
    {
        if ($model = $this -> findModel($id)) {

            if (in_array($model -> name, Yii::$app -> params['defaultNotDelRoleName']))
                return $this -> message('该角色不可删除', $this -> redirect(['role']), 'error');

            return $model -> delete() ?
                    $this -> message('删除成功', $this -> redirect(['role'])) :
                    $this -> message($this -> analysisError($model -> getFirstErrors()), $this -> redirect(['role']), 'error');

        }

        return $this -> message('未找到该角色', $this -> redirect(['role']), 'error');
    }

    // 规则 rule =========================================
    
    /**
     * 规则列表
     *
     * @return string [<description>]
     */
    public function actionRule()
    {
        return $this -> render('rule');
    }
    
    

    /**
     * 返回模型
     *
     * @return $this|Model
     */
    protected function findModel($id)
    {
        if (empty($id)) {

            $model = new AuthItem;

            return $model -> loadDefaultValues();

        }

        if (empty(($model = AuthItem::findOne(['id' => $id])))) {

            $model = new AuthItem;

            return $model -> loadDefaultValues();

        }

        return $model;
    }

}