<?php
use yii\helpers\Url;

$this -> title = "网站设置";
$this -> params['breadcrumbs'][] = ['label' => $this -> title];
?>

<div class="layui-col-md12">

    <div class="layui-card">
        <div class="layui-card-body">

            <div class="layui-tab layui-tab-brief" lay-filter="component-tabs-hash">

                <ul class="layui-tab-title">

                    <?php foreach ($configs as $key =>  $config): ?>
                        <li class="<?php echo 0 == $key ? 'layui-this' : '' ?>" lay-id="<?php echo $config['id'] ?>"><?php echo $config['title'] ?></li>
                    <?php endforeach; ?>

                </ul>

                <div class="layui-tab-content">

                    <?php foreach ($configs as $key => $config): ?>
                        <div class="layui-tab-item <?php echo 0 == $key ? 'layui-show' : '' ?>">

                            <?php echo $this -> render('tree', [
                                                    'configs' => $config['child'],
                                                    'anchor'  => $config['id']
                                                ]) ?>
                            
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>
    </div>

</div>