<?php
namespace oframe\basics\common\widgets;

use Yii;
use yii\helpers\Html;

class CropperModalWidget extends \yii\base\Widget
{   

    public function run()
    {
        return $this -> render('cropper-modal');
    }
}