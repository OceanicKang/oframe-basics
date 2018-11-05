<?php
namespace oframe\basics\backend\modules\sys\controllers;

use Yii;
use oframe\basics\common\models\common\Config;
use common\enums\StatusEnum;
use oframe\basics\common\helpers\SysArrayHelper;

class ConfigController extends \backend\controllers\BController
{
    /**
     * 首页
     *
     * @return string [<description>]
     */
    public function actionIndex()
    {
        $configs = Config::find()
                -> where(['status' => [StatusEnum::STATUS_ON, StatusEnum::STATUS_OFF]])
                -> orderBy('sort asc, id asc')
                -> asArray()
                -> all();

        $configs = SysArrayHelper::itemsMerge($configs, 'id', 'pid', 0);

        return $this -> render('index', [
            'configs' => $configs
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

        $pid = $request -> get('pid');

        $level = $request -> get('level');

        $p_name = $request -> get('p_name');

        $p_title = $request -> get('p_title');

        $anchor = $request -> get('anchor', '');

        if ($request -> isPost) {

            return $model -> load($request -> post()) && $model -> save() ?
                        $this -> message('操作成功', $this -> redirect(['index', '#' => '/#layid=' . $anchor])) :
                        $this -> message($this -> analysisError($model -> getFirstErrors()), $this -> redirect(['index', '#' => '/#layid=' . $anchor]), 'error');

        }

        return $this -> render('edit', [
            'model' => $model,
            'pid' => $pid,
            'level' => $level,
            'p_name' => $p_name,
            'p_title' => $p_title
        ]);
    }

    /**
     * 状态删除
     *
     * @return string [<description>]
     */
    public function actionStatusDel($id, $anchor = '')
    {
        $model = $this -> findModel($id);

        if (in_array($model -> name, Yii::$app -> params['notDelConfigName']))
            return $this -> message('该标识为系统核心标识，禁止删除', $this -> redirect(['index', '#' => '/#layid=' . $anchor]), 'error');

        $model -> status = StatusEnum::STATUS_DEL;

        return $model -> update() ?
                $this -> message('删除成功', $this -> redirect(['index', '#' => '/#layid=' . $anchor])) :
                $this -> message($this -> analysisError($model -> getFirstErrors()), $this -> redirect(['index', '#' => '/#layid=' . $anchor]), 'error');
    }

    /**
     * 回收站
     */
    public function actionRecycle()
    {
        $configs = Config::find()
                 -> where(['status' => StatusEnum::STATUS_DEL])
                 -> orderBy('updated desc, id asc')
                 -> asArray()
                 -> all();

        return $this -> render('recycle', [
            'configs' => $configs,
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

        $model -> status = StatusEnum::STATUS_ON;

        return $model -> update() ?
                $this -> message('还原成功', $this -> redirect(['index'])) :
                $this -> message($this -> analysisError($model -> getFirstErrors()), $this -> redirect(['index']), 'error');
    }

    /**
     * 彻底删除
     *
     * @return string [<description>]
     */
    public function actionDelete($id)
    {
        $model = $this -> findModel($id);

        if (in_array($model -> name, Yii::$app -> params['notDelConfigName']))
            return $this -> message('该标识为系统核心标识，禁止删除', $this -> redirect(['index']), 'error');

        return $model -> delete() ?
                $this -> message('删除成功', $this -> redirect(['index'])) :
                $this -> message($this -> analysisError($model -> getFirstErrors()), $this -> redirect(['index']), 'error');
    }

    /**
     * 返回模型
     */
    protected function findModel($id)
    {
        if (empty($id)) {

            $model = new Config;

            return $model -> loadDefaultValues();

        }

        if (empty($model = Config::findOne($id))) {

            $model = new Config;

            return $model -> loadDefaultValues();

        }

        return $model;
    }
}