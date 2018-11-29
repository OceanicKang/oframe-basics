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

                    <?php foreach ($configs as $key =>  $Level_1): ?>
                        <li class="<?php echo 0 == $key ? 'layui-this' : '' ?>" lay-id="<?php echo $Level_1['id'] ?>"><?php echo $Level_1['title'] ?></li>
                    <?php endforeach; ?>

                </ul>

                <div class="layui-tab-content">

                    <?php foreach ($configs as $key => $Level_1): ?>
                        <div class="layui-tab-item <?php echo 0 == $key ? 'layui-show' : '' ?>">

                            <?php echo $this -> render('tree', [
                                                    'Level_2' => $Level_1['child'],
                                                    'anchor'  => $Level_1['id']
                                                ]) ?>
                            
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript">
    
$('.layui-form-label').click(function () {

    $('.of-ibox input').val($(this).attr('title'));

    $('.of-ibox p span').text($(this).text());

});

</script>

