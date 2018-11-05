<?php
namespace oframe\basics\backend\controllers;

use Yii;
use oframe\basics\common\helpers\AjaxHelper;

/**
 * Backend 基类控制器
 *
 */

class BController extends \oframe\basics\common\controllers\BaseController
{
    /**
     * 默认布局文件
     * @var string
     */
    public $layout = '@basics/backend/views/layout/main.php';

    /**
     * 初始化
     */
    public function init()
    {
        // 禁止删除的配置标识
        Yii::$app -> params['notDelConfigName'] = array_merge(Yii::$app -> params['defaultNotDelConfigName'], Yii::$app -> params['notDelConfigName']); 
        // 禁止删除的菜单路由
        Yii::$app -> params['notDelMenuUrl'] = array_merge(Yii::$app -> params['defaultNotDelMenuUrl'], Yii::$app -> params['notDelMenuUrl']); 
        // 无需RBAC验证的路由
        Yii::$app -> params['notAuthRoute'] = array_merge(Yii::$app -> params['defaultNotAuthRoute'], Yii::$app -> params['notAuthRoute']); 
        // 无需RBAC验证的方法
        Yii::$app -> params['notAuthAction'] = array_merge(Yii::$app -> params['defaultNotAuthAction'], Yii::$app -> params['notAuthAction']); 

        return parent::init();
    }


    /**
     * 错误提示信息 非浮动型
     *
     * @param string $msgText 错误内容
     * @param string $skipUrl 跳转链接
     * @param string $msgType 提示类型
     * @param int $closeTime 提示关闭时间
     * @return mixed
     */
    public function Message($msgText, $skipUrl, $msgType = '', $closeTime = 5)
    {
        $closeTime = (int)$closeTime;

        // 如果是成功的提示 则默认为3秒关闭
        if (!$closeTime && $msgType == 'success' || !$msgType)
        {
            $closeTime = 3;
        }

        $html = $this -> hintText($msgText, $closeTime);

        switch ($msgType)
        {
            case 'success':
                Yii::$app -> getSession() -> setFlash('success', $html); break;
            case 'error':
                Yii::$app -> getSession() -> setFlash('error', $html); break;
            case 'info':
                Yii::$app -> getSession() -> setFlash('info', $html); break;
            case 'warning':
                Yii::$app -> getSession() -> setFlash('warning', $html); break;
            default :
                Yii::$app -> getSession() -> setFlash('success', $html); break;
        }

        return $skipUrl;
    }

    /**
     * @param $msg
     * @param $closeTime
     * @return string
     */
    public function hintText($msg, $closeTime)
    {

        $text = $msg . '，<span id="alter_timer">'.$closeTime.'</span>秒后自动关闭...';

        return $text;

    }

    /**
     * 全局通用修改排序和状态
     * 
     * @return string [<description>]
     */
    public function actionAjaxUpdate($id)
    {
        $insert_data = [];

        $data = Yii::$app -> request -> get();

        isset($data['status']) && $insert_data['status'] = $data['status'];

        isset($data['sort']) && $insert_data['sort'] = $data['sort'];

        $model = $this -> findModel($id);

        $model -> attributes = $insert_data;

        $response = Yii::$app -> response;

        $response -> data = !$model -> save() ?
                                AjaxHelper::formatData(422, $this -> analysisError($model -> getFirstErrors())) :
                                AjaxHelper::formatData(200);

        $response -> send();
    }

    
}