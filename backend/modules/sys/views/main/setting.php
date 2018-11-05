<?php
use yii\helpers\Url;

$this -> title = '系统管理';
$this -> params['breadcrumbs'][] = ['label' => $this -> title];
?>

<div class="layui-col-md12">

    <div class="layui-card">

        <div class="layui-card-header">
            <i class="zmdi zmdi-view-dashboard"></i> 扩展
        </div>

        <div class="layui-card-body">

            <div class="layui-btn-container btn-container">

                <a href="<?php echo Url::to(['/sys/menu/side-menu']) ?>" title="侧边菜单" class="layui-btn layui-btn-lg">
                    <i class="zmdi zmdi-view-quilt"></i><span>侧边菜单</span>
                </a>

                <a href="<?php echo Url::to(['/sys/menu/sys-menu']) ?>" title="侧边菜单" class="layui-btn layui-btn-lg">
                    <i class="zmdi zmdi-view-stream"></i><span>系统菜单</span>
                </a>

                <a href="<?php echo Url::to(['/sys/config/index']) ?>" title="配置管理" class="layui-btn layui-btn-lg">
                    <i class="zmdi zmdi-settings"></i><span>配置管理</span>
                </a>

            </div>

        </div>
        
    </div>


    <?php foreach ($menus as $Level_1): ?>

    <div class="layui-card">

        <div class="layui-card-header">
            <i class="<?php echo $Level_1['icon_class'] ?>"></i> <?php echo $Level_1['title'] ?>
        </div>

        <div class="layui-card-body">

            <div class="layui-btn-container btn-container">

                <?php foreach ($Level_1['child'] as $Level_2): ?>

                <a href="<?php echo Url::to([$Level_2['url']]) ?>" title="<?php echo $Level_2['title'] ?>" class="layui-btn layui-btn-lg">
                    <i class="<?php echo $Level_2['icon_class'] ?>"></i><span><?php echo $Level_2['title'] ?></span>
                </a>

                <?php endforeach; ?>

            </div>

        </div>
        
    </div>

    <?php endforeach; ?>
    
</div>