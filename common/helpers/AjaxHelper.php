<?php 
namespace oframe\basics\common\helpers;

use Yii;
use yii\web\Response;
use yii\helpers\ArrayHelper;

/**
 * Ajax 数据格式
 *
 */
class AjaxHelper
{
    const AJAX_SUCCESS       = '200'; // 请求成功
    const AJAX_NOT_HAVE_DATA = '201'; // 没有数据 或者 没有更多数据
    const AJAX_NOT_AUTH      = '401'; // 没有权限
    const AJAX_NOT_FOUND     = '404'; // 未找到请求对象
    const AJAX_NOT_VALIDATY  = '422'; // 数据验证有误
    const AJAX_UNKNOW        = '500'; // 未知错误

    /**
     * 说明
     *
     * @var array
     */
    public static $behavior = [
        self::AJAX_SUCCESS       => '请求成功',
        self::AJAX_NOT_HAVE_DATA => '没有数据 或者 没有更多数据',
        self::AJAX_NOT_AUTH      => '没有权限',
        self::AJAX_NOT_FOUND     => '未找到请求对象',
        self::AJAX_NOT_VALIDATY  => '数据验证有误',
        self::AJAX_UNKNOW        => '未知错误',
    ];

    /**
     * 返回的数据结构
     *
     * @var array|object|string
     */
    public $data = [];

    /**
     * 直接返回数据格式
     *
     * @param int          $code    状态码
     * @param string       $message 返回的报错信息
     * @param array|object $data    返回的数据结构
     */
    public static function formatData($code = self::AJAX_UNKNOW, $message = '', $data = [])
    {
        Yii::$app -> response -> format = Response::FORMAT_JSON;

        $message = empty($message) ? self::$behavior[$code] : $message;

        $result = [
            'code' => strval($code),
            'message' => trim($message),
            'data' => $data ? ArrayHelper::toArray($data) : [],
        ];

        return $result;
    }


}