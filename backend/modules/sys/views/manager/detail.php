<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use oframe\basics\common\widgets\CropperWidget;

$this -> title = '用户信息 -- ' . $model['username'];
$this -> params['breadcrumbs'][] = ['label' => '系统管理', 'url' => Url::to(['main/setting'])];
$this -> params['breadcrumbs'][] = ['label' => '后台用户管理', 'url' => Url::to(['index'])];
$this -> params['breadcrumbs'][] = ['label' => $this -> title];
?>

<?php $form = ActiveForm::begin(); ?>

<div class="layui-row layui-col-space15">

    <div class="layui-col-md3">

        <div class="layui-card">

            <div class="layui-card-header">头像</div>
            
            <div class="layui-card-body">

                <?php echo $form -> field($model, 'avatar') -> widget(CropperWidget::className(), [
                                
                            ]) -> label(false); ?>

                <hr>

                <p>最后登录IP：<span></span></p>
                
                <p>最后登录日期：<span></span></p>

            </div>

        </div>

    </div>

    <div class="layui-col-md9">

        <div class="layui-card">
            
            <div class="layui-card-body">



            </div>

        </div>

    </div>

</div>

<?php ActiveForm::end(); ?>

