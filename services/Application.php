<?php
namespace oframe\basics\services;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;

class Application
{

    public $childService;

    public $_childService;

    public function __construct($config = [])
    {

        Yii::$service = $this;

        $this -> childService = $config;

    }

    /**
     * 得到 services 里面配置的子服务 childService 的实例
     */
    public function getChildService($childServiceName)
    {

        if (!$this -> _childService[$childServiceName]) {

            $childService = $this -> childService;

            if (isset($childService[$childServiceName])) {

                $service = $childService[$childServiceName];

                $this -> _childService[$childServiceName] = Yii::createObject($service);

            } else {

                throw new InvalidConfigException('Child SService [' . $childServiceName . '] is not find in ' . get_called_class() . ', you must config it !');

            }

        }

        return $this -> _childService[$childServiceName];

    }

    public function __get($attr)
    {

        return $this -> getChildService($attr);

    }

}