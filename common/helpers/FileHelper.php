<?php
namespace oframe\basics\common\helpers;

use Yii;

class FileHelper
{
    
    /**
     * 获取文件类型（英文）
     */
    public static function getFileTypeToEN($fileName)
    {
        $fileType = strtolower(substr(strrchr($fileName, '.'), 1));

        return $fileType;
    }

    /**
     * 获取文件类型（中文）
     */
    public static function getFileTypeToCN($fileName)
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

    /**
     * 创建目录
     * @Author OceanicKang 2018-12-19
     * @param  string      $catalogue 目录
     * @return true
     */
    public static function mkdirs($catalogue)
    {
        if (!file_exists($catalogue)) {

            self::mkdirs(dirname($catalogue));

            mkdir($catalogue, 0777);

        }

        return true;
    }

    /**
     * 根据 URL 获取文件绝对路径
     * @Author OceanicKang 2018-12-30
     * @param  string      $url
     * @param  string      $type      URL类型
     * @return string
     */
    public static function getLocalFilePath($url, $type = 'images')
    {
        $prefix = Yii::getAlias('@root/') . 'web';

        switch ($type) {

            case 'images':
                if (true == Yii::$app -> config -> get('UPLOAD_IMAGES_FULL_PATH')) $url = str_replace(Yii::$app -> request -> hostInfo, '', $url);
                break;

            default:
                throw new Exception("getLocalFilePath 传入类型错误", 1);

        }

        return $prefix . $url;
    }

}