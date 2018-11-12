<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this -> context -> layout = '@basics/backend/views/layout/model';
?>

<div id="lay-breadcrumbs" style="box-shadow: none;">
    <span>上级分类：<?php echo $p_title ?></span>
    <span class="of-float-r">上级标识：<?php echo $p_name ?></span>
</div>

<div class="layui-form layui-form-pane">

    <?php $form = ActiveForm::begin([
                    'fieldConfig' => [
                        'template' => ' <div class="layui-form-item">
                                            {label}
                                            <div class="layui-input-block">
                                                {input}
                                            </div>
                                            {error}
                                        </div>',
                        'labelOptions' => ['class' => 'layui-form-label'],
                        'inputOptions' => ['class' => 'layui-input']
                    ]
                ]); ?>

    <!-- 权限名称 -->
    <?php echo $form -> field($model , 'description') -> textInput([
                    'placeholder' => '请填写权限名称',
                    'lay-verify' => 'required',
                ]) -> label('权限名称'); ?>

    <!-- 路由 -->
    <?php echo $form -> field($model , 'name') -> textInput([
                    'placeholder' => '请填写权限路由',
                    'lay-verify' => 'required',
                    'disabled' => in_array($model -> name, Yii::$app -> params['notDelRbacUrl'])
                ]) -> label('权限路由'); ?>

    <!-- pid -->
    <?php echo  $form -> field($model, 'pid', [
                    'template' => '{input}'
                ]) -> hiddenInput([
                    'value' => $pid
                ]) -> label(false); ?>

    <!-- type -->
    <?php echo  $form -> field($model, 'type', [
                    'template' => '{input}'
                ]) -> hiddenInput([
                    'value' => \common\models\backend\AuthItem::AUTH
                ]) -> label(false); ?>

    <!-- level -->
    <?php echo $form -> field($model, 'level', [
                    'template' => '{input}'
                ]) -> hiddenInput([
                    'value' => $level
                ]) -> label(false); ?>


    <div class="layui-form-item">

        <?php echo Html::submitButton($model -> id ? '更&nbsp&nbsp新' : '添&nbsp&nbsp加', [
                        'class' => 'layui-btn layui-btn-fluid',
                        'lay-submit' => '',
                    ]) ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>
