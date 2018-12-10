<?php
namespace oframe\basics\common\widgets;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use oframe\basics\common\widgets\assets\CropperAsset;

class CropperWidget extends \yii\widgets\InputWidget
{
    public $id = '';

    public $name = '';

    public $value = '';

    /**
     * 容器 div
     * @var array
     */
    public $containerDivOptions = [];

    public function init()
    {
        $_containerDivOptions = [
            'class' => 'of-txt-center'
        ];

        $this -> containerDivOptions = ArrayHelper::merge($_containerDivOptions, $this -> containerDivOptions);
    }

    public function run()
    {
        $this -> registerClientScript();
        
        $attribute = str_replace('[]', '', $this -> attribute);

        if (!$id = $this -> id) {
            $id = $this -> hasModel() ? Html::getInputId($this -> model, $this -> attribute) : $this -> id;
        }

        if (!$name = $this -> name) {
            $name = $this -> hasModel() ? Html::getInputName($this -> model, $this -> attribute) : $this -> name;
        }

        if (!$value = $this -> value) {
            $value = $this -> hasModel() ? Html::getAttributeValue($this -> model, $this -> attribute) : $this -> value;
        }

        return $this -> render('cropper', [
            'model' => $this -> model,
            'id' => $id,
            'name' => $name,
            'value' => $value,
            'containerDivOptions' => $this -> containerDivOptions
        ]);
    }

    protected function registerClientScript()
    {
        CropperAsset::register($this -> getView());
    }
}