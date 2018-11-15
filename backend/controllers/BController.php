<?php
namespace oframe\basics\backend\controllers;

use Yii;
use oframe\basics\common\helpers\AjaxHelper;
use yii\web\UnauthorizedHttpException;

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

        // 禁止删除的权限路由
        Yii::$app -> params['notDelRbacUrl'] = array_merge(Yii::$app -> params['defaultNotDelRbacUrl'], Yii::$app -> params['notDelRbacUrl']);

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

    /**
     * RBAC 权限验证
     *
     * @return bool [<description>]
     */
    public function beforeAction($action)
    {
        // 验证是否是总管理员
        if (!\Yii::$app -> user -> isGuest && in_array(Yii::$app -> user -> id, Yii::$app -> params['adminAccount'])) return true;

        if (!parent::beforeAction($action)) return false;

        // 需要验证的路由
        $permissionName = '/' . Yii::$app -> controller -> module -> id . 
                          '/' . Yii::$app -> controller -> id .
                          '/' . Yii::$app -> controller -> action -> id;

        // 不需要 RBAC 的路由
        $notAuthRoute = Yii::$app -> params['notAuthRoute'];

        // 不需要 RBAC 的方法
        $notAuthAction = Yii::$app -> params['notAuthAction'];

        if (in_array($permissionName, $notAuthRoute) || in_array(Yii::$app -> controller -> action -> id, $notAuthAction)) return true;

        if (!Yii::$app -> user -> can($permissionName) && Yii::$app -> getErrorHandler() -> exception === null) {

            throw new UnauthorizedHttpException('对不起，您暂未获得此操作的权限');

        }

        return true;
    }
    
}