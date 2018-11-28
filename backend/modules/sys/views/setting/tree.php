
<style type="text/css">
    .layui-tab-title > .layui-this {
        margin: 0px !important;
        padding: 0 15px !important;
    }
</style>

<div class="layui-tab layui-tab-card">
    <ul class="layui-tab-title">

        <?php foreach ($configs as $key =>  $config): ?>
            <li class="<?php echo 0 == $key ? 'layui-this' : '' ?>"><?php echo $config['title'] ?></li>
        <?php endforeach; ?>

    </ul>
    <div class="layui-tab-content">

        <?php foreach ($configs as $key => $config): ?>
            <div class="layui-tab-item <?php echo 0 == $key ? 'layui-show' : '' ?>">

                <?php echo '<pre>'; print_r($config['child']); ?>
                
            </div>
        <?php endforeach; ?>

    </div>
</div>
