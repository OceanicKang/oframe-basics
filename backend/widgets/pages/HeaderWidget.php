<?php
namespace oframe\basics\backend\widgets\pages;

use Yii;
use common\models\backend\Manager;

class HeaderWidget extends \yii\base\Widget
{
    public function run()
    {
        $id = Yii::$app -> user -> id;

        $user = Manager::find()
                -> where(['id' => $id])
                -> asArray()
                -> one();

        return $this -> render('header', [
            'user' => $user,
        ]);
    }
}