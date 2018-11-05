<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this -> title = "网站设置";
$this -> params['breadcrumbs'] = ['label' => $this -> title];
?>

<div class="layui-col-md12">
    <div class="layui-card">

        <div class="layui-card-header">网站设置</div>

        <div class="layui-card-body" pad15>

            <?php $form = ActiveForm::begin([
                        'options' => ['class' => 'layui-form', 'wid100' => '', 'lay-filter' => ''],
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

            <!-- 网站名称 -->
            <?php echo $form -> field($model , 'WEB_SITE_TITLE') -> textInput() -> label($config['WEB_SITE_TITLE']['title']); ?>

            <!-- 网站域名 -->
            <?php echo $form -> field($model , 'WEB_SITE_DOMAIN') -> textInput([
                            'lay-verify' => 'url'
                        ]) -> label($config['WEB_SITE_DOMAIN']['title']); ?>

            <!-- 缓存时间 -->
            <?php echo $form -> field($model , 'WEB_SITE_CACHE', [
                            'template' => " <div class=\"layui-form-item\">
                                                {label}
                                                <div class=\"layui-input-inline\" style=\"width: 80px;\">
                                                    {input}
                                                </div>
                                                <div class=\"layui-input-inline layui-input-company\">分钟</div>
                                                <div class=\"layui-form-mid layui-word-aux\">{$config['WEB_SITE_CACHE']['describe']}</div>
                                            </div>"

                        ]) -> textInput([
                            'type' => 'number',
                            'lay-verify' => 'number',
                        ]) -> label($config['WEB_SITE_CACHE']['title']); ?>

            <!-- 最大文件上传 -->
            <?php echo $form -> field($model , 'WEB_MAX_FILE_SIZE', [
                            'template' => " <div class=\"layui-form-item\">
                                                {label}
                                                <div class=\"layui-input-inline\" style=\"width: 80px;\">
                                                    {input}
                                                </div>
                                                <div class=\"layui-input-inline layui-input-company\">KB</div>
                                                <div class=\"layui-form-mid layui-word-aux\">{$config['WEB_MAX_FILE_SIZE']['describe']}</div>
                                            </div>"

                        ]) -> textInput([
                            'type' => 'number',
                            'lay-verify' => 'number',
                        ]) -> label($config['WEB_MAX_FILE_SIZE']['title']); ?>

            <!-- 上传文件类型 -->
            <?php echo $form -> field($model , 'WEB_FILE_TYPE') -> textInput() -> label($config['WEB_FILE_TYPE']['title']); ?>

            <!-- 首页标题 -->
            <?php echo $form -> field($model , 'WEB_SITE_INDEX_TITLE') -> textInput() -> label($config['WEB_SITE_INDEX_TITLE']['title']); ?>


            <!-- META关键词 -->
            <?php echo $form -> field($model, 'WEB_META_KEY', [
                            'options' => ['class' => 'layui-form-item layui-form-text']
                        ]) -> textarea([
                            'class' => 'layui-textarea',
                            'placeholder' => '多个关键词用英文状态 , 号分割',
                        ]) -> label($config['WEB_META_KEY']['title']); ?>

            <!-- META描述 -->
            <?php echo $form -> field($model, 'WEB_META_DESCRIBE', [
                            'options' => ['class' => 'layui-form-item layui-form-text']
                        ]) -> textarea([
                            'class' => 'layui-textarea',
                        ]) -> label($config['WEB_META_DESCRIBE']['title']); ?>

            <!-- 版权信息 -->
            <?php echo $form -> field($model, 'WEB_COPY_RIGHT', [
                            'options' => ['class' => 'layui-form-item layui-form-text']
                        ]) -> textarea([
                            'class' => 'layui-textarea',
                        ]) -> label($config['WEB_COPY_RIGHT']['title']); ?>


            <div class="layui-form-item">

                <div class="layui-input-block">
                    <?php echo Html::submitButton('确认保存', [
                                    'class' => 'layui-btn',
                                    'lay-submit' => '',
                                    'lay-filter' => 'set_website'
                                ]) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>