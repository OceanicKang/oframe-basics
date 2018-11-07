<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this -> title = "邮件服务";
$this -> params['breadcrumbs'] = ['label' => $this -> title];
?>

<div class="layui-col-md12">
    <div class="layui-card">

        <div class="layui-card-header">邮件服务</div>

        <div class="layui-card-body">

            <?php $form = ActiveForm::begin([
                        'options' => ['class' => 'layui-form', 'wid100' => '', 'lay-filter' => ''],
                        'fieldConfig' => [
                            'template' => " <div class=\"layui-form-item\">
                                                {label}
                                                <div class=\"layui-input-inline\">
                                                    {input}
                                                </div>
                                                {error}
                                            </div>",
                            'labelOptions' => ['class' => 'layui-form-label'],
                            'inputOptions' => ['class' => 'layui-input']
                        ]
                    ]); ?>

            <!-- SMTP服务器 -->
            <?php echo $form -> field($model , 'SYS_EMAIL_HOST', [
                            'template' => " <div class=\"layui-form-item\">
                                                {label}
                                                <div class=\"layui-input-inline\">
                                                    {input}
                                                </div>
                                                <div class=\"layui-form-mid layui-word-aux\">{$config['SYS_EMAIL_HOST']['describe']}</div>
                                            </div>"

                        ]) -> textInput() -> label($config['SYS_EMAIL_HOST']['title']); ?>

            <!-- SMTP端口号 -->
            <?php echo $form -> field($model , 'SYS_EMAIL_PORT', [
                            'template' => " <div class=\"layui-form-item\">
                                                {label}
                                                <div class=\"layui-input-inline\" style=\"width: 80px;\">
                                                    {input}
                                                </div>
                                                <div class=\"layui-form-mid layui-word-aux\">{$config['SYS_EMAIL_PORT']['describe']}</div>
                                            </div>"

                        ]) -> textInput([
                            'type' => 'number',
                            'lay-verify' => 'number'
                        ]) -> label($config['SYS_EMAIL_PORT']['title']); ?>

            <!-- 发件人邮箱 -->
            <?php echo $form -> field($model , 'SYS_EMAIL_USERNAME') -> textInput([
                            'lay-verify' => 'email'
                        ]) -> label($config['SYS_EMAIL_USERNAME']['title']); ?>

            <!-- 发件人邮箱 -->
            <?php echo $form -> field($model , 'SYS_EMAIL_NICKNAME') -> textInput() -> label($config['SYS_EMAIL_NICKNAME']['title']); ?>

            <!-- 邮箱登入密码 -->
            <?php echo $form -> field($model , 'SYS_EMAIL_PASSWORD') -> passwordInput() -> label($config['SYS_EMAIL_PASSWORD']['title']); ?>

            <!-- SSL 加密 -->
            <div class="layui-form-item">
                <label class="layui-form-label" for="setting-sys_email_encryption"><?php echo $config['SYS_EMAIL_ENCRYPTION']['title'] ?></label>
                <div class="layui-input-inline">
                    <input type="hidden" name="Setting[SYS_EMAIL_ENCRYPTION]" value="0">
                    <input type="checkbox" name="Setting[SYS_EMAIL_ENCRYPTION]" lay-skin="switch" lay-text="ON|OFF" value="1" <?php echo $config['SYS_EMAIL_ENCRYPTION']['value'] ? 'checked' : '' ?>>
                </div>
            </div>



            <div class="layui-form-item">

                <div class="layui-input-block">
                    <?php echo Html::submitButton('确认保存', [
                                    'class' => 'layui-btn',
                                    'lay-submit' => '',
                                ]) ?>

                    <a class="layui-btn layui-btn-primary" href="<?php echo Url::to(['send-email']) ?>">发送测试邮件</a>

                </div>

            </div>


            <?php ActiveForm::end(); ?>

        </div>

    </div>
</div>
