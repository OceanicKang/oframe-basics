<?php
namespace oframe\basics\common\controllers;

use Yii;

/**
 * 基类控制器
 */

class BaseController extends \yii\web\Controller
{
    /**
     * 默认分页大小
     *
     * @var int
     */
    protected $_pageSize = 20;

    public function init()
    {
        // $this -> _pageSize = Yii::$app -> config -> get('SYS_SITE_PAGE') ? Yii::$app -> config -> get('SYS_SITE_PAGE') : $this -> _pageSize;

        return parent::init();
    }

    /**
     * 解析Yii2错误信息
     *
     * @param $errors
     * @return string
     */
    public function analysisError($errors)
    {
        $errors = array_values($errors)[0];

        return $errors ?? '操作失败';
    }

    /**
     * 公共下载方式
     */
    public function download($fileName, $path)
    {
        ob_end_clean();

        header ("Cache-Control: must-revalidate, post-check=0, pre-check=0");

        header ('Content-Description: File Transfer');

        header ('Content-Type: application/octet-stream; charset=utf8');

        header ('Content-Length: ' . filesize($path));

        header ('Content-Disposition: attachment; filename=' . basename($path));

        readfile($path);

    }

    /**
     * 打印调试
     * @param $array
     */
    public function p($array)
    {
        echo "<pre>";

        print_r($array);
    }
    
}