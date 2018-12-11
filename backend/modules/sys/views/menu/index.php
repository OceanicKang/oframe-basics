<?php
use yii\helpers\Url;
use oframe\basics\common\models\backend\Menu;

$this -> title = Menu::$typeExplain[$type] . '管理';
$this -> params['breadcrumbs'][] = ['label' => '系统管理', 'url' => Url::to(['/sys/main/setting'])];
$this -> params['breadcrumbs'][] = ['label' => $this -> title];
?>

<div class="layui-col-md12">

    <div class="layui-card">

        <div class="layui-card-body">

            <div class="layui-btn-container">

                <div class="of-float-r">
                    <a class="layui-btn layui-btn-normal layer-modal" title="添加新菜单" href="<?php echo Url::to(['edit',
                                                                                                            'id' => 0,
                                                                                                            'p_title' => '无',
                                                                                                            'p_url' => '无',
                                                                                                            'pid' => 0,
                                                                                                            'type' => $type,
                                                                                                            'level' => 1]); ?>">
                        <i class="layui-icon layui-icon-add-circle-fine" style="margin-right: 5px !important;"></i>添加新菜单
                    </a>
                    <a class="layui-btn layui-btn-primary layer-modal" title="回收站" href="<?php echo Url::to(['recycle', 'type' => $type]); ?>">
                        <i class="ali-icon ali-icon-dustbin" style="margin-right: 5px;"></i>回收站
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
                        <th class="of-width-30 of-txt-center">折叠</th>
                        <th class="of-width-30 of-txt-center">图标</th>
                        <th class="of-width-20 of-txt-center"></th>
                        <th class="of-width-20 of-txt-center">LV</th>
                        <th class="of-txt-nowrap">标题</th>
                        <th class="of-txt-nowrap">路由</th>
                        <th class="of-txt-nowrap">排序</th>
                        <th>描述</th>
                        <th class="of-txt-nowrap">状态</th>
                        <th class="of-txt-nowrap">操作</th>
                    </tr> 
                </thead>
                <tbody>

                    <?php echo $this -> render('tree', [

                                'menus' => $menus,
                                'pid' => 0,
                                'p_title' => '无',
                                'p_url' => '无'

                            ]); ?>
                    
                </tbody>
            </table>

        </div>
        
    </div>
    
</div>

