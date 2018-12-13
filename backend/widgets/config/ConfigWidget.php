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
        $config = $this -> config;

        if ($config['extra']) {

            $config['extra'] = explode(',', $config['extra']);

            foreach ($config['extra'] as $key => $value) {

                $config['extra'][$key] = explode('=>', $value);

                $config['extra'][$config['extra'][$key][0]] = $config['extra'][$key][1];

                unset($config['extra'][$key]);

            }

        }

        return $this -> render('config', [
            'config' => $config
        ]);
    }
}