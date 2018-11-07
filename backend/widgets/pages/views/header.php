<?php
use yii\helpers\Url;

?>


<div class="layui-header">

    <ul class="layui-nav layui-layout-left">

        <li class="layui-nav-item layadmin-flexible" lay-unselect>
            <a href="javascript:;" layadmin-event="flexible" title="侧边伸缩">
                <i class="layui-icon layui-icon-shrink-right" id="LAY_app_flexible"></i>
            </a>
        </li>

        <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="<?php echo Yii::$app -> config -> get('WEB_SITE_DOMAIN') ? Yii::$app -> config -> get('WEB_SITE_DOMAIN') : Yii::$app -> request -> hostInfo ?>" target="_blank" title="前台">
                <i class="layui-icon layui-icon-website"></i>
            </a>
        </li>

        <li class="layui-nav-item" lay-unselect>
            <a href="javascript:;" layadmin-event="refresh" title="刷新">
                <i class="layui-icon layui-icon-refresh-3"></i>
            </a>
        </li>

    </ul>

    <ul class="layui-nav layui-layout-right" lay-filter="layadmin-layout-right">

        <li class="layui-nav-item" lay-unselect>
            <a lay-tips="系统管理" lay-href="<?php echo Url::to(['sys/main/setting']) ?>" lay-direction="2">
                <i class="layui-icon layui-icon-set-fill zmdi zmdi-hc-spin"></i>
                <cite style="display: none;">系统管理</cite>
            </a>
        </li>

        <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="javascript:;" layadmin-event="theme">
                <i class="layui-icon layui-icon-theme"></i>
            </a>
        </li>

        <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="javascript:;" layadmin-event="fullscreen">
                <i class="layui-icon layui-icon-screen-full"></i>
            </a>
        </li>

        <li class="layui-nav-item" lay-unselect>
            <a href="javascript:;">
                <cite><?php echo $user['nickname'] ? $user['nickname'] : $user['username'] ?></cite>
            </a>
            <dl class="layui-nav-child">
                <dd><a lay-href="#">基本资料</a></dd>
                <dd><a lay-href="#">修改密码</a></dd>
                <hr>
                <dd style="text-align: center;"><a href="<?php echo Url::to(['logout']) ?>">退出</a></dd>
            </dl>
        </li>

        <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="javascript:;" layadmin-event="about"><i class="layui-icon layui-icon-more-vertical"></i></a>
        </li>

    </ul>

</div>