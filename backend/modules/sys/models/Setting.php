<?php
namespace oframe\basics\backend\modules\sys\models;

use Yii;
use yii\db\ActiveRecord;
use oframe\basics\common\models\common\Config;

/**
 * 网站设置 model
 */
class Setting extends ActiveRecord
{

    /**------ 网站设置 ------**/

    /**
     * 网站名称
     * @var string
     */
    public $WEB_SITE_TITLE = '';

    /**
     * 网站域名
     * @var string
     */
    public $WEB_SITE_DOMAIN = '';

    /**
     * LOGO NAME
     * @var string
     */
    public $WEB_SITE_LOGO_NAME = '';

    /**
     * AD NAME
     * @var string
     */
    public $WEB_SITE_AD_NAME = '';

    /**
     * 缓存时间
     * @var number
     */
    public $WEB_SITE_CACHE = 0;

    /**
     * 最大文件上传
     * @var number
     */
    public $WEB_MAX_FILE_SIZE = 0;

    /**
     * 上传文件类型
     * @var string
     */
    public $WEB_FILE_TYPE = '';

    /**
     * 首页标题
     * @var string
     */
    public $WEB_SITE_INDEX_TITLE = '';

    /**
     * META关键字
     * @var string
     */
    public $WEB_META_KEY = '';

    /**
     * META描述
     * @var string
     */
    public $WEB_META_DESCRIBE = '';

    /**
     * 版权信息
     * @var string
     */
    public $WEB_COPY_RIGHT = '';

    /**------ 邮件服务 ------**/

    /**
     * SMTP服务器
     * @var string
     */
    public $SYS_EMAIL_HOST = '';

    /**
     * SMTP端口号
     * @var number
     */
    public $SYS_EMAIL_PORT = 465;

    /**
     * 发件人邮箱
     * @var string
     */
    public $SYS_EMAIL_USERNAME = '';

    /**
     * 发件人昵称
     * @var string
     */
    public $SYS_EMAIL_NICKNAME = '';

    /**
     * 邮箱登入密码
     * @var string
     */
    public $SYS_EMAIL_PASSWORD = '';

    /**
     * SSL 加密
     * @var string
     */
    public $SYS_EMAIL_ENCRYPTION = '';

    public function init()
    {
        $this -> WEB_SITE_TITLE       = Yii::$app -> config -> get('WEB_SITE_TITLE');
        $this -> WEB_SITE_LOGO_NAME   = Yii::$app -> config -> get('WEB_SITE_LOGO_NAME');
        $this -> WEB_SITE_AD_NAME     = Yii::$app -> config -> get('WEB_SITE_AD_NAME');
        $this -> WEB_SITE_DOMAIN      = Yii::$app -> config -> get('WEB_SITE_DOMAIN') ?
                                        Yii::$app -> config -> get('WEB_SITE_DOMAIN') : Yii::$app -> request -> hostInfo;
        $this -> WEB_SITE_CACHE       = Yii::$app -> config -> get('WEB_SITE_CACHE') ?
                                        Yii::$app -> config -> get('WEB_SITE_CACHE') : 0;
        $this -> WEB_MAX_FILE_SIZE    = Yii::$app -> config -> get('WEB_MAX_FILE_SIZE') ?
                                        Yii::$app -> config -> get('WEB_MAX_FILE_SIZE') : 0;
        $this -> WEB_FILE_TYPE        = Yii::$app -> config -> get('WEB_FILE_TYPE');
        $this -> WEB_SITE_INDEX_TITLE = Yii::$app -> config -> get('WEB_SITE_INDEX_TITLE');
        $this -> WEB_META_KEY         = Yii::$app -> config -> get('WEB_META_KEY');
        $this -> WEB_META_DESCRIBE    = Yii::$app -> config -> get('WEB_META_DESCRIBE');
        $this -> WEB_COPY_RIGHT       = Yii::$app -> config -> get('WEB_COPY_RIGHT');
        $this -> SYS_EMAIL_HOST       = Yii::$app -> config -> get('SYS_EMAIL_HOST');
        $this -> SYS_EMAIL_PORT       = Yii::$app -> config -> get('SYS_EMAIL_PORT') ?
                                        Yii::$app -> config -> get('SYS_EMAIL_PORT') : 465;
        $this -> SYS_EMAIL_USERNAME   = Yii::$app -> config -> get('SYS_EMAIL_USERNAME');
        $this -> SYS_EMAIL_NICKNAME   = Yii::$app -> config -> get('SYS_EMAIL_NICKNAME');
        $this -> SYS_EMAIL_PASSWORD   = Yii::$app -> config -> get('SYS_EMAIL_PASSWORD');
        $this -> SYS_EMAIL_ENCRYPTION = Yii::$app -> config -> get('SYS_EMAIL_ENCRYPTION') ?
                                        Yii::$app -> config -> get('SYS_EMAIL_ENCRYPTION') : 0;

        parent::init();
    }


    
    /**
     * 批量更新配置值
     * @Author OceanicKang 2018-11-05
     * @param  array      $post      [description]
     * @return bool                 [description]
     */
    public static function updateValues($post)
    {
        $sql = '';

        foreach ($post['Setting'] as $name => $value) {

            $sql .= "UPDATE `of_sys_config` SET `value` = '{$value}' WHERE `name` = '{$name}';";

        }

        $result = Yii::$app -> db -> createCommand($sql) -> execute();

        Yii::$app -> config -> getAll(false);

        return true;
    }

}