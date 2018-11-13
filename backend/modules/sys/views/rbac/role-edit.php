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
                ]) ?>

    <!-- 角色名称 -->
    <?php echo $form -> field($model , 'name') -> textInput([
                    'placeholder' => '请填写角色名称',
                    'lay-verify' => 'required',
                ]) -> label('角色名称'); ?>

    <!-- 角色说明 -->
    <?php echo $form -> field($model , 'description') -> textInput([
                    'placeholder' => '请填写角色说明',
                ]) -> label('角色说明'); ?>

    <!-- type -->
    <?php echo  $form -> field($model, 'type', [
                    'template' => '{input}'
                ]) -> hiddenInput([
                    'value' => \common\models\backend\AuthItem::ROLE
                ]) -> label(false); ?>

    <div class="layui-form-item">

        <?php echo Html::submitButton($model -> id ? '更&nbsp&nbsp新' : '添&nbsp&nbsp加', [
                        'class' => 'layui-btn layui-btn-fluid',
                        'lay-submit' => '',
                    ]) ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>