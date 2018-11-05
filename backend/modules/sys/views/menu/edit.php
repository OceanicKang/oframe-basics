<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this -> context -> layout = '@basics/backend/views/layout/model';
?>

<div id="lay-breadcrumbs" style="box-shadow: none;">
    <span>上级菜单：<?php echo $p_title ?></span>
    <span class="of-float-r">上级路由：<?php echo $p_url ?></span>
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

    <!-- 菜单名称 -->
    <?php echo $form -> field($model , 'title') -> textInput([
                    'placeholder' => '请填写菜单名称',
                    'lay-verify' => 'required',
                ]) -> label('菜单名称'); ?>

    <!-- 路由 -->
    <?php echo $form -> field($model , 'url') -> textInput([
                    'placeholder' => '请填写路由',
                    'lay-verify' => 'required',
                    'disabled' => in_array($model -> url, Yii::$app -> params['notDelMenuUrl'])
                ]) -> label('路由名称'); ?>

    <!-- 图标 -->
    <?php echo $form -> field($model, 'icon_class', [
                    'template' => ' <div class="layui-form-item">
                                        {label}
                                        <div class="layui-input-block">
                                            {input}
                                        </div>
                                        <div class="layui-form-mid layui-word-aux of-txt-right" style="width: 100%;">图标库查看：<a href="https://oceanickang.github.io/OceanicFrame/#/develop/system/icon" target="_blank">https://oceanickang.github.io/OceanicFrame/#/develop/system/icon </a></div>
                                      </div>'
                ]) -> textInput([
                    'placeholder' => '如：zmdi zmdi-menu',
                ]) ?>

    <!-- 描述 -->
    <?php echo $form -> field($model, 'describe', [
                    'options' => ['class' => 'layui-form-text']
                ]) -> textarea([
                    'class' => 'layui-textarea',
                    'placeholder' => '请添加描述'
                ]) -> label('描述'); ?>

    <!-- pid -->
    <?php echo $form -> field($model, 'pid', [
                    'template' => '{input}'
                ]) -> hiddenInput([
                    'value' => $pid
                ]) -> label(false); ?>

    <!-- type -->
    <?php echo $form -> field($model, 'type', [
                    'template' => '{input}'
                ]) -> hiddenInput([
                    'value' => $type
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