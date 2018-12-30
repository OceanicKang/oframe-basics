<?php
namespace oframe\basics\common\helpers;

use Yii;
use Ramsey\Uuid\Uuid;
use yii\helpers\BaseStringHelper;

class StringHelper extends BaseStringHelper
{
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

    /**
     * 获取数字随机字符串
     * @Author OceanicKang 2018-12-19
     * @param  string      $prefix    前缀
     * @param  integer     $length    长度
     * @return string
     */
    public static function randomNum($prefix = '', $length = 8)
    {
        $prefix = $prefix ?: '';
        return $prefix . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, $length);
    }

    /**
     * windows 下字符编码转换
     * @Author OceanicKang 2018-12-20
     * @param  string      $value     字符串
     * @param  string      $iconv     目标编码
     * @return string                 
     */
    public static function iconvForWindows($value, $iconv = 'GB2312')
    {
        if (DebrisHelper::isWindowsOS()) {

            switch ($iconv) {

                case 'GB2312': // UTF-8 转 GB2312
                    return iconv('UTF-8', 'GB2312//TRANSLIT', $value);
                    break;

                case 'UTF-8': // GB2312 转 UTF-8
                    return iconv('GB2312', 'UTF-8//TRANSLIT', $value);
                    break;

            }

        }

        return $value;
    }

    public static function createThumbUrl($url, $width, $height)
    {
        $url = explode('/', $url);

        $nameArr = explode('.', end($url));

        $url[count($url) - 1] = $nameArr[0] . "@{$width}×{$height}." . $nameArr[1];

        return implode('/', $url);
    }

}