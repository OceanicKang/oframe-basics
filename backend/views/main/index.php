<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use oframe\basics\backend\widgets\pages\HeaderWidget;
use oframe\basics\backend\widgets\pages\MenuWidget;

AppAsset::register($this);
?>

<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app -> language ?>">
<head>
    <meta charset="<?= Yii::$app -> charset ?>">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <?= Html::csrfMetaTags() ?>

    <title><?php echo Yii::$app -> config -> get('WEB_SITE_TITLE') ?></title>

    <?php $this->head() ?>

</head>
<body class="layui-layout-body" id="backend">
    
<?php $this->beginBody() ?>

<div id="LAY_app">
    <div class="layui-layout layui-layout-admin">
        
        <!-- 头部区域 -->
        <?php echo HeaderWidget::widget() ?>
      
        <!-- 侧边菜单 -->
        <?php echo MenuWidget::widget() ?>
      

        <!-- 页面标签 -->
        <div class="layadmin-pagetabs" id="LAY_app_tabs">
            <div class="layui-icon layadmin-tabs-control layui-icon-prev" layadmin-event="leftPage"></div>
            <div class="layui-icon layadmin-tabs-control layui-icon-next" layadmin-event="rightPage"></div>
            <div class="layui-icon layadmin-tabs-control layui-icon-down">
                <ul class="layui-nav layadmin-tabs-select" lay-filter="layadmin-pagetabs-nav">
                    <li class="layui-nav-item" lay-unselect>
                        <a href="javascript:;"></a>
                        <dl class="layui-nav-child layui-anim-fadein">
                            <dd layadmin-event="closeThisTabs"><a href="javascript:;">关闭当前标签页</a></dd>
                            <dd layadmin-event="closeOtherTabs"><a href="javascript:;">关闭其它标签页</a></dd>
                            <dd layadmin-event="closeAllTabs"><a href="javascript:;">关闭全部标签页</a></dd>
                        </dl>
                    </li>
                </ul>
            </div>
            <div class="layui-tab" lay-unauto lay-allowClose="true" lay-filter="layadmin-layout-tabs">
                <ul class="layui-tab-title" id="LAY_app_tabsheader">
                    <li lay-id="<?php echo Url::to(['sys/main/index']) ?>" lay-attr="<?php echo Url::to(['sys/main/index']) ?>" class="layui-this"><i class="layui-icon layui-icon-home"></i></li>
                </ul>
            </div>

        </div>
      
        <!-- 主体内容 -->
        <div class="layui-body" id="LAY_app_body">

            <div class="layadmin-tabsbody-item layui-show">

                <iframe src="<?php echo Url::to(['sys/main/index']) ?>" frameborder="0" class="layadmin-iframe"></iframe>

            </div>

        </div>
      
        <!-- 辅助元素，一般用于移动设备下遮罩 -->
        <div class="layadmin-body-shade" layadmin-event="shade"></div>

    </div>
</div>


<?php $this->endBody() ?>

<script>
    layui.config({
        base: '/resource/backend/' //静态资源所在路径
    }).extend({
        index: '/lib/index' //主入口模块
    }).use('index');
</script>

</body>
</html>
<?php $this->endPage() ?>
