<?php
namespace oframe\basics\backend\widgets\config;

use Yii;
use yii\helpers\Html;

class ConfigWidget extends \yii\base\Widget
{   
    /**
     * 配置数据
     * @var array
     */
    public $config = [];

    public function run()
    {
        return $this -> render('config', [
            'config' => $this -> config
        ]);
    }
}