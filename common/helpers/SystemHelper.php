<?php
namespace oframe\basics\common\helpers;

use Yii;
use Ramsey\Uuid\Uuid;
use yii\helpers\BaseStringHelper;

class SystemHelper extends BaseStringHelper
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
     * 生成唯一标识 uuid
     * @Author OceanicKang 2018-12-18
     * @param  string      $type      time/md5/random/sha1/uniqid
     * @param  string      $name      加密名
     * @throws \Exception 
     * @return string
     */
    public static function uuid($type = 'time', $name = 'php.net')
    {
        switch ($type) {
            // 版本1：基于时间的 UUID 对象
            case 'time':
                $uuid = Uuid::uuid1();
                break;

            // 版本3：基于名称和散列的 MD5 UUID 对象
            case 'md5':
                $uuid = Uuid::uuid3(Uuid::NAMESPACE_DNS, $name);
                break;

            // 版本4：随机 UUID 对象
            case 'random':
                $uuid = Uuid::uuid4();
                break;

            // 版本5：基于名称和散列的 SHA1 UUID 对象
            case 'sha1':
                $uuid = Uuid::uuid5(Uuid::NAMESPACE_DNS, $name);
                break;

            // php 自带的唯一 id
            case 'uniqid':
                return md5(uniqid(md5(microtime(true) . self::randomNum(8)), true));
                break;
        }

        return $uuid -> toString();
    }

}