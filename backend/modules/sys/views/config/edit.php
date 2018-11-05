<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this -> context -> layout = '@basics/backend/views/layout/model';
?>

<div id="lay-breadcrumbs" style="box-shadow: none;">
    <span>上级模块：<?php echo $p_title ?></span>
    <span class="of-float-r">上级标识：<?php echo $p_name ?></span>
</div>

<div class="layui-form layui-form-pane" >

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

    <!-- 配置名称 -->
    <?php echo $form -> field($model , 'title') -> textInput([
                    'placeholder' => '请填写配置名称',
                    'lay-verify' => 'required',
                ]) -> label('配置名称'); ?>

    <!-- 配置标识 -->
    <?php echo $form -> field($model , 'name') -> textInput([
                    'placeholder' => '请填写配置标识',
                    'lay-verify' => 'required',
                    'disabled' => in_array($model -> name, Yii::$app -> params['notDelConfigName'])
                ]) -> label('配置标识'); ?>

    <!-- 配置选项 -->
    <?php echo $form -> field($model , 'extra') -> textInput([
                    'placeholder' => 'key1=>value1,key2=>value2,...（英文字符)',
                ]) -> label('配置选项'); ?>

    <!-- 配置类型 -->
    <?php echo $form -> field($model, 'type') -> dropDownList(Yii::$app -> params['configTypeList'], [
                    'prompt' => '请选择配置类型'
                ]) ?>

    <!-- 配置说明 -->
    <?php echo $form -> field($model, 'describe', [
                    'options' => ['class' => 'layui-form-text']
                ]) -> textarea([
                    'class' => 'layui-textarea',
                    'placeholder' => '请添加配置说明'
                ]) -> label('配置说明'); ?>

    <!-- pid -->
    <?php echo $form -> field($model, 'pid', [
                    'template' => '{input}'
                ]) -> hiddenInput([
                    'value' => $pid
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

</div>

<?php ActiveForm::end(); ?>