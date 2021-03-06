<?php
namespace oframe\basics\backend\modules\sys\controllers;

use Yii;
use oframe\basics\common\models\common\Config;
use common\enums\StatusEnum;
use oframe\basics\backend\modules\sys\models\Setting;
use oframe\basics\common\helpers\SysArrayHelper;

/**
 * 系统设置
 */
class SettingController extends \backend\controllers\BController
{
    /**
     * 网站配置信息界面
     */
    public function actionConfig()
    {
        $configs = Config::find()
                -> where(['status' => StatusEnum::STATUS_ON])
                -> andWhere(['NOT', ['name' => '']])
                -> orderBy('sort asc')
                -> asArray()
                -> all();

        $configs = SysArrayHelper::itemsMerge($configs);

        return $this -> render('config', [
            'configs' => $configs
        ]);
    }

    /**
     * 更新 config value
     * @Author OceanicKang 2018-11-19
     * @param  string      $action    [description]
     * @return string                 [description]
     */
    public function actionUpdate($anchor = '')
    {
        return Yii::$app -> request -> isPost && Setting::updateValues(Yii::$app -> request -> post()) ? 
                    $this -> message('保存成功', $this -> redirect(['config', '#' => '/#layid=' . $anchor])) :
                    $this -> message('保存失败', $this -> redirect(['config', '#' => '/#layid=' . $anchor]), 'error');
    }

    /**
     * 发送测试邮件
     * @Author OceanicKang 2018-11-07
     * @return string      [description]
     */
    public function actionSendEmail()
    {
        try {

            Yii::$app
                -> mailer
                -> compose()
                -> setFrom([
                    Yii::$app -> config -> get('SYS_EMAIL_USERNAME') => Yii::$app -> config -> get('SYS_EMAIL_NICKNAME')
                ])
                -> setTo(Yii::$app -> user -> identity -> email)
                -> setSubject(Yii::$app -> config -> get('SYS_EMAIL_NICKNAME') . '-测试邮件')
                -> setTextBody('这是一份测试邮件')
                -> send();

        } catch (\Exception $e) {

            return $this -> message($e -> getMessage(), $this -> redirect(['email']), 'error', 10000);

        }

        return $this -> message('发送成功', $this -> redirect(['email']));
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