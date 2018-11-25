<?php
namespace oframe\basics\common\helpers;

use Yii;

class SystemHelper
{
    /**
     * 获取文件类型
     */
    public static function getFileType($fileName)
    {
        $fileType = strtolower(substr(strrchr($fileName, '.'), 1));

        return Yii::$app -> params['FileExtension'][$fileType];
    }
}