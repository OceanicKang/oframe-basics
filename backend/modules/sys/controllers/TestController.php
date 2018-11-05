<?php
namespace oframe\basics\backend\modules\sys\controllers;

use Yii;

class TestController extends \backend\controllers\BController
{
    /**
     * 测试页
     *
     * @return string [<description>]
     */
    public function actionIndex()
    {
        return $this -> render('index', [

        ]);
    }

    /**
     * 一级测试页
     *
     * @return string [<description>]
     */
    public function actionIndex1()
    {
        return $this -> render('index1', [

        ]);
    }

    /**
     * 二级测试页
     *
     * @return string [<description>]
     */
    public function actionIndex2()
    {
        return $this -> render('index2', [

        ]);
    }
}