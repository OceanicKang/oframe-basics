<?php
namespace oframe\basics\common\helpers;

use Yii;
use yii\captcha\CaptchaAction;

/**
 * captcha 接口帮助类
 * Class YiiCaptchaHelper
 */
class CaptchaHelper extends CaptchaAction
{
    /**
     * 默认配置
     * @Author OceanicKang 2018-11-03
     */
    public static $config = [
        'minLength' => 5,        // 最少显示个数
        'maxLength' => 5,        // 最大显示个数
        'padding'   => 5,        // 间距
        'backColor' => 0xffffff, // 背景颜色
        'foreColor' => 0x1ab394, // 字体颜色
        'width'     => 80,       // 宽度
        'height'    => 40,       // 高度
        'offset'    => 4,        // 设置字符偏移量
    ];

    public function __construct($config = [])
    {
        $this -> init();
        self::$config = array_merge(self::$config, $config);
        $this -> fixedVerifyCode = YII_ENV_TEST ? 'testme' : null;
        $this -> minLength = self::$config['minLength']; // 最少显示个数
        $this -> maxLength = self::$config['maxLength']; // 最大显示个数
        $this -> padding   = self::$config['padding'];   // 间距
        $this -> backColor = self::$config['backColor']; // 背景颜色
        $this -> foreColor = self::$config['foreColor']; // 字体颜色
        $this -> width     = self::$config['width'];     // 宽度
        $this -> height    = self::$config['height'];    // 高度
        $this -> offset    = self::$config['offset'];    // 设置字符偏移量
        
        // $this -> imageLibrary = "gd";//or $this->imageLibrary = "imagick";
    }

    public static function base64()
    {
        if (self::getPhrase()) {

            return Yii::$app -> session['captcha.base64'] = 'data:image/png;base64,' . base64_encode((new self(self::$config)) -> renderImage(self::getPhrase()));

        }

        return Yii::$app -> session['captcha.base64'] = "data:image/png;base64," . base64_encode((new self(self::$config)) -> renderImage(self::setPhrase()));
    }

    public static function setPhrase()
    {

        return Yii::$app -> session['captcha.verifyCode'] = (new self(self::$config)) -> generateVerifyCode();

    }

    public static function getPhrase()
    {

        if (Yii::$app -> session['captcha.verifyCode']) {

            return Yii::$app -> session['captcha.verifyCode'];

        }

        return false;
    }


}