<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use oframe\basics\backend\widgets\config\ConfigWidget;
?>

<style type="text/css">
    .layui-tab-title > .layui-this {
        margin: 0px !important;
        padding: 0 15px !important;
    }
</style>

<div class="layui-row layui-col-space15">

    <div class="layui-col-md8">

        <div class="layui-tab layui-tab-card">

            <ul class="layui-tab-title">

                <?php foreach ($Level_2 as $key =>  $value): ?>
                    <li class="<?php echo 0 == $key ? 'layui-this' : '' ?>"><?php echo $value['title'] ?></li>
                <?php endforeach; ?>

            </ul>

            <div class="layui-tab-content">

                <?php foreach ($Level_2 as $key => $value): ?>
                    <div class="layui-tab-item <?php echo 0 == $key ? 'layui-show' : '' ?>">

                        <?php $form = ActiveForm::begin([
                            'action' => Url::to(['update', 'anchor' => $anchor]),
                            'options' => ['class' => 'layui-form', 'wid100' => '', 'lay-filter' => ''],
                        ]); ?>


                            <?php foreach ($value['child'] as $Level_3): ?>

                                <?php echo ConfigWidget::widget([
                                                'config' => $Level_3
                                            ]) ?>

                            <?php endforeach; ?>

                            <div class="layui-input-block">

                                <?php echo Html::submitButton('确认保存', [
                                                'class' => 'layui-btn',
                                                'lay-submit' => '',
                                            ]) ?>

                                <?php if ($value['name'] == 'SYS_EMAIL'): ?>
                                    <a class="layui-btn layui-btn-primary" href="<?php echo Url::to(['send-email']) ?>">发送测试邮件</a>
                                    <span>&nbsp;&nbsp;注：发送测试邮件之前请先保存</span>
                                <?php endif; ?>

                            </div>

                        <?php ActiveForm::end(); ?>

                    </div>
                <?php endforeach; ?>

            </div>

        </div>

    </div>

    <div class="layui-col-md4">

        <div class="layui-card of-ibox">

            <div class="layui-card-header of-ibox-header">单击【配置名称】获取【配置标识】</div>

            <div class="layui-card-body">

                <input type="text" class="layui-input of-ibox-header" style="border-color: #e6e6e6;" value="" readonly>

                <p style="margin-top: 5px;">当前显示 ： <span></span></p>

            </div>

        </div>

    </div>

</div>
