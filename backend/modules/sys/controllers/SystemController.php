<?php
namespace oframe\basics\backend\modules\sys\controllers;

use Yii;
use oframe\basics\common\helpers\SystemHelper;

class SystemController extends \backend\controllers\BController
{
    // 系统信息 =====================================
    
    public function actionInfo()
    {
        $db = Yii::$app -> db;

        $models = $db -> createCommand('SHOW TABLE STATUS') -> queryAll();

        $models = array_map('array_change_key_case', $models);

        // 数据库大小
        $mysql_size = 0;
        foreach ($models as $model) $mysql_size += $model['data_length'];

        // 禁用函数
        $disable_functions = ini_get('disable_functions');

        $disable_functions = $disable_functions ?: '未禁用';

        // 附件大小
        $attachment_size = SystemHelper::getDirSize(Yii::getAlias('@attachment'));

        return $this -> render('info', [
            'mysql_size' => $mysql_size,
            'attachment_size' => $attachment_size,
            'disable_functions' => $disable_functions
        ]);
    }
}
