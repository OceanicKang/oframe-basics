<?php
namespace oframe\basics\common\helpers;

use Yii;

class DebrisHelper
{

    /**
     * 获取水印坐标
     * @Author OceanicKang 2018-12-30
     * @param  string      $imgUrl          图片URL
     * @param  string      $watermarkImgUrl 水印URL
     * @param  int         $point           坐标类型
     * @return array
     */
    public static function getWatermarkLocation($imgUrl, $watermarkImgUrl, $point)
    {
        if (empty($imgUrl) || empty($watermarkImgUrl)) return false;

        if (!file_exists($watermarkImgUrl) || !file_exists($imgUrl)) return false;

        $imgInfo = getimagesize($imgUrl);

        $watermarkImgInfo = getimagesize($watermarkImgUrl);

        if (empty($watermarkImgInfo) || empty($imgInfo)) return false;

        $imgWidth = $imgInfo[0];

        $imgHeight = $imgInfo[1];

        $imgMime = $imgInfo['mime'];

        $watermarkImgWidth = $watermarkImgInfo[0];

        $watermarkImgHeight = $watermarkImgInfo[1];

        $watermarkMime = $watermarkImgInfo['mime'];

        switch ($point) {

            case 1: // 左上
                $left = 20;
                $top = 20;
                break;

            case 2: // 中上
                $left = floor(($imgWidth - $watermarkImgWidth) / 2);
                $top = 20;
                break;

            case 3: // 右上
                $left = $imgWidth - $watermarkImgWidth - 20;
                $top = 20;
                break;

            case 4: // 左中
                $left = 20;
                $top = floor(($imgHeight - $watermarkImgHeight) / 2);
                break;

            case 5: // 正中
                $left = floor(($imgWidth - $watermarkImgWidth) / 2);
                $top = floor(($imgHeight - $watermarkImgHeight) / 2);
                break;

            case 6: // 右中
                $left = $imgWidth - $watermarkImgWidth - 20;
                $top = floor(($imgHeight - $watermarkImgHeight) / 2);
                break;
                
            case 7: // 左下
                $left = 20;
                $top = $imgHeight - $watermarkImgHeight - 20;
                break;

            case 8: // 中下
                $left = floor(($imgWidth - $watermarkImgWidth) / 2);
                $top = $imgHeight - $watermarkImgHeight - 20;
                break;

            case 9: // 右下
                $left = $imgWidth - $watermarkImgWidth - 20;
                $top = $imgHeight - $watermarkImgHeight - 20;
                break;

            default: // 右下
                $left = $imgWidth - $watermarkImgWidth - 20;
                $top = $imgHeight - $watermarkImgHeight - 20;
                break;

        }

        if (($imgWidth - $left) < $watermarkImgWidth || ($imgHeight - $top) < $watermarkImgHeight) return false;

        return [$left, $top];
    }

    /**
     * 验证是否为 Windows 环境
     * @Author OceanicKang 2018-12-20
     * @return boolean
     */
    public static function isWindowsOS()
    {
        return strncmp(PHP_OS, 'WIN', 3) === 0;
    }

    /**
     * Debug 回溯跟踪
     * @Author OceanicKang 2018-12-30
     * @param  boolean     $reverse
     * @return [type]                 [description]
     */
    public static function debug($reverse = false)
    {
        $debug = debug_backtrace();

        $data = [];

        foreach ($debug as $e) {

            $function = $e['function'] ?? 'null function';

            $class = $e['class'] ?? 'null class';

            $file = $e['file'] ?? 'null file';

            $line = $e['line'] ?? 'null line';

            $data[] = $file . '(' . $line . '),' . $class . '::' . $function . '()';

        }

        return true == $reverse ? array_reverse($data) : $data;
    }
}