<?php
namespace oframe\basics\backend\modules\sys\models;

use Yii;
use oframe\basics\common\models\common\Config;

/**
 * 网站设置 model
 */
class Setting extends \yii\base\Model
{
    /**
     * 批量更新配置值
     * @Author OceanicKang 2018-11-05
     * @param  array      $post      [description]
     * @return bool                 [description]
     */
    public static function updateValues($post)
    {
        $sql = '';

        foreach ($post['Setting'] as $name => $value) {

            $sql .= "UPDATE `of_sys_config` SET `value` = '{$value}' WHERE `name` = '{$name}';";

        }

        $result = Yii::$app -> db -> createCommand($sql) -> execute();

        Yii::$app -> config -> getAll(false);

        return true;
    }

}