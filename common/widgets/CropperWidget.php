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
    public $containerDivStyle = '';

    public function run()
    {
        $this -> registerClientScript();
        
        $attribute = str_replace('[]', '', $this -> attribute);

        if (!$this -> id) {
            $this -> id = $this -> hasModel() ? Html::getInputId($this -> model, $this -> attribute) : $this -> id;
        }

        if (!$this -> name) {
            $this -> name = $this -> hasModel() ? Html::getInputName($this -> model, $this -> attribute) : $this -> name;
        }

        if (!$this -> value) {
            $this -> value = $this -> hasModel() ? Html::getAttributeValue($this -> model, $this -> attribute) : $this -> value;
        }

        return $this -> render('cropper', [
            'model' => $this -> model,
            'id' => $this -> id,
            'name' => $this -> name,
            'value' => $this -> value,
            'containerDivStyle' => $this -> containerDivStyle,
        ]);
    }

    protected function registerClientScript()
    {
        CropperAsset::register($this -> getView());
    }
}