<?php
namespace oframe\basics\backend\modules\sys\controllers;

use Yii;
use oframe\basics\common\models\backend\Menu;
use common\enums\StatusEnum;

class MenuController extends \backend\controllers\BController
{
    /**
     * 侧边菜单
     *
     * @return string [<description>]
     */
    public function actionSideMenu()
    {
        $side_menu = Menu::getMenus(Menu::TYPE_SIDE); // 侧边菜单

        return $this -> render('index', [

            'type' => Menu::TYPE_SIDE,

            'menus' => $side_menu

        ]);
    }

    /**
     * 系统菜单
     *
     * @return string [<description>]
     */
    public function actionSysMenu()
    {
        $sys_menu = Menu::getMenus(Menu::TYPE_SYS); // 系统菜单

        return $this -> render('index', [

            'type' => Menu::TYPE_SYS,

            'menus' => $sys_menu

        ]);
    }

    /**
     * 编辑|新增
     *
     * @return string [<description>]
     */
    public function actionEdit()
    {
        $request = Yii::$app -> request;

        $id = $request -> get('id');

        $model = $this -> findModel($id);

        $p_title = $request -> get('p_title'); // 父级菜单

        $p_url = $request -> get('p_url'); // 父级路由

        $pid = $request -> get('pid'); // 父id

        $type = $request -> get('type'); // 菜单类型

        $level = $request -> get('level'); // 菜单级别

        if ($request -> isPost) {

            $url = Menu::TYPE_SIDE == $type ? 'side-menu' : 'sys-menu';

            return ($model -> load($request -> post()) && $model -> save()) ? 
                    $this -> message('添加成功', $this -> redirect([$url])) :
                    $this -> message($this -> analysisError($model -> getFirstErrors()), $this -> redirect([$url]), 'error');

        }

        return $this -> render('edit', [
            'model' => $model,
            'p_title' => $p_title,
            'p_url' => $p_url,
            'pid' => $pid,
            'type' => $type,
            'level' => $level
        ]);
    }

    /**
     * 状态删除
     *
     * @return string [<description>]
     */
    public function actionStatusDel($id)
    {

        $model = $this -> findModel($id);

        $url = Menu::TYPE_SIDE == $model -> type ? 'side-menu' : 'sys-menu';

        if (in_array($model -> url, Yii::$app -> params['notDelMenuUrl']))
            return $this -> message('该菜单为系统核心菜单，禁止删除', $this -> redirect([$url]), 'error');

        $model -> status = StatusEnum::STATUS_DEL;

        return $model -> update() ?
                $this -> message('删除成功，可在回收站恢复', $this -> redirect([$url])) :
                $this -> message($this -> analysisError($model -> getFirstErrors()), $this -> redirect([$url]), 'error');
    }

    /**
     * 回收站
     *
     * @return string [<description>]
     */
    public function actionRecycle($type)
    {
        $menus = Menu::find()
                -> where(['type' => $type, 'status' => StatusEnum::STATUS_DEL])
                -> orderBy('updated desc, id asc')
                -> asArray()
                -> all();

        return $this -> render('recycle', [
            'menus' => $menus
        ]);
    }

    /**
     * 还原
     *
     * @return string [<description>]
     */
    public function actionRestore($id)
    {
        
        $model = $this -> findModel($id);
        
        $url = Menu::TYPE_SIDE == $model -> type ? 'side-menu' : 'sys-menu';

        if (in_array($model -> url, Yii::$app -> params['notDelMenuUrl']))
            return $this -> message('该菜单为系统核心菜单，禁止删除', $this -> redirect([$url]), 'error');

        $model -> status = StatusEnum::STATUS_ON;

        return $model -> update() ?
                $this -> message('还原成功', $this -> redirect([$url])) :
                $this -> message($this -> analysisError($model -> getFirstErrors()), $this -> redirect([$url]), 'error');
    }

    /**
     * 彻底删除
     *
     * @return string [<description>]
     */
    public function actionDelete($id)
    {
        $model = $this -> findModel($id);

        $url = Menu::TYPE_SIDE == $model -> type ? 'side-menu' : 'sys-menu';

        return $model -> delete() ?
                $this -> message('删除成功', $this -> redirect([$url])) :
                $this -> message($this -> analysisError($model -> getFirstErrors()), $this -> redirect([$url]), 'error');
    }

    /**
     * 返回模型
     */
    protected function findModel($id)
    {
        if (empty($id)) {

            $model = new Menu;

            return $model -> loadDefaultValues();

        }

        if (empty($model = Menu::findOne($id))) {

            $model = new Menu;

            return $model -> loadDefaultValues();

        }

        return $model;
    }
}




