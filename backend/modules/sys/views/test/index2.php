<?php
use yii\helpers\Url;

$this -> title = '二级测试页';
$this -> params['breadcrumbs'][] = ['label' =>  '一级测试页', 'url' => Url::to(['/sys/test/index1'])];
$this -> params['breadcrumbs'][] = ['label' =>  $this -> title];
?>

二级测试页