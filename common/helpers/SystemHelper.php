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

    /**
     * 获取文件夹大小
     */
    public static function getDirSize($dir)
    {

        $handle = opendir($dir);

        $size = 0;

        while (($FolderOrFile = readdir($handle)) !== false) {

            if ($FolderOrFile != '.' && $FolderOrFile != '..') {

                if (is_dir("$dir/$FolderOrFile")) {

                    $size += self::getDirSize("$dir/$FolderOrFile");

                } else {

                    $size += filesize("$dir/$FolderOrFile");

                }

            }

        }

        closedir($handle);

        return $size;
    }

}