<?php
use yii\helpers\Url;

$this -> title = '角色管理';
$this -> params['breadcrumbs'][] = ['label' => '系统管理', 'url' => Url::to(['main/setting'])];
$this -> params['breadcrumbs'][] = ['label' => $this -> title];
?>

<div class="layui-col-md12">

    <div class="layui-card">

        <div class="layui-card-body">

            <div class="layui-btn-container">

                <div class="of-float-r">
                    
                    <a class="layui-btn layui-btn-normal model" title="添加新角色" href="<?php echo Url::to(['role-edit', 'id' => 0]); ?>" >
                        <i class="layui-icon layui-icon-add-circle-fine" style="margin-right: 5px !important;"></i> 添加新角色
                    </a>

                </div>

            </div>

        </div>
        
    </div>

    <div class="layui-card">

        <div class="layui-card-body">

            <table class="layui-table" lay-skin="line">
                <thead>
                    <tr>
                        <th class="of-width-20 of-txt-center">#</th>
                        <th class="of-txt-nowrap">角色名称</th>
                        <th class="of-txt-nowrap">角色说明</th>
                        <th class="of-txt-nowrap">创建时间</th>
                        <th class="of-txt-nowrap">更新时间</th>
                        <th class="of-txt-nowrap">排序</th>
                        <th class="of-txt-nowrap">操作</th>
                    </tr> 
                </thead>
                <tbody>

                    <?php foreach ($models as $model): ?>



                    <?php endforeach; ?>
                    
                </tbody>
            </table>

        </div>
        
    </div>

</div>

