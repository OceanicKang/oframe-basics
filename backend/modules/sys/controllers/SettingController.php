<?php
namespace oframe\basics\backend\modules\sys\controllers;

use Yii;
use oframe\basics\common\models\common\Config;
use common\enums\StatusEnum;
use oframe\basics\backend\modules\sys\models\Setting;

/**
 * 系统设置
 */
class SettingController extends \backend\controllers\BController
{
    /**
     * 所有config
     * @var array
     */
    public $config = [];

    /**
     * 初始化
     * @Author OceanicKang 2018-11-05
     * @return [type]      [description]
     */
    public function init()
    {
        $this -> config = Config::find()
                        -> where(['status' => StatusEnum::STATUS_ON])
                        -> andWhere(['NOT', ['name' => '']])
                        -> asArray()
                        -> all();

        $this -> config = array_column($this -> config, null, 'name');
        
        parent::init();
    }

    /**
     * 网站设置
     * @Author OceanicKang 2018-11-05
     * @return string      [description]
     */
    public function actionWeb()
    {
        $model = new Setting;

        return $this -> render('web', [
            'model' => $model,
            'config' => $this -> config
        ]);
    }

    /**
     * 邮件服务
     * @Author OceanicKang 2018-11-05
     * @return string      [description]
     */
    public function actionEmail()
    {
        $model = new Setting;

        return $this -> render('email', [
            'config' => $this -> config
        ]);
    }

    /**
     * 返回模型
     * @Author OceanicKang 2018-11-05
     * @param $id
     * @return $this|Config|static
     */
    protected function findModel($id)
    {
        if (empty($id)) {

            $model = new Config;

            return $model -> loadDefaultValues();
        }

        if (empty(($model = Config::findOne($id)))) {

            $model = new Config;

            return $model -> loadDefaultValues();

        }

        return $model;
    }
}