<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this -> context -> layout = '@basics/backend/views/layout/model';
?>

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

    <!-- 登录名 -->
    <?php echo $form -> field($model , 'username') -> textInput([
                    'placeholder' => '请填写用户名',
                    'lay-verify' => 'required',
                ]) -> label('用户名'); ?>

    <!-- 密码 -->
    <?php echo $form -> field($model, 'password_hash') -> passwordInput([
                    'placeholder' => '请填写密码',
                    'lay-verify' => 'required',
                ]) ?>

    <!-- 手机号 -->
    <?php echo $form -> field($model , 'mobile_phone') -> textInput([
                    'placeholder' => '请填写手机号',
                ]) -> label('手机号'); ?>

    <!-- 邮箱 -->
    <?php echo $form -> field($model , 'email') -> textInput([
                    'placeholder' => '请填写邮箱',
                ]) -> label('邮箱'); ?>

    <!-- 配置类型 -->
    <?php echo $form -> field($model, 'role_id') -> dropDownList($roles, [
                    'prompt' => '请分配角色',
                    'lay-verify' => 'required',
                ]) -> label('角色'); ?>

    <div class="layui-form-item">

        <?php echo Html::submitButton($model -> id ? '更&nbsp&nbsp新' : '添&nbsp&nbsp加', [
                        'class' => 'layui-btn layui-btn-fluid',
                        'lay-submit' => '',
                    ]) ?>

    </div>

    <?php ActiveForm::end(); ?>
</div>
