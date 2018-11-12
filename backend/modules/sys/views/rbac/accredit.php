<?php
use yii\helpers\Url;

$this -> title = "权限管理";
$this -> params['breadcrumbs'][] = ['label' => '系统管理', 'url' => Url::to(['main/setting'])];
$this -> params['breadcrumbs'][] = ['label' => $this -> title];
?>

<div class="layui-col-md12">

    <div class="layui-card">

        <div class="layui-card-body">

            <div class="layui-btn-container">

                <div class="of-float-r">
                    
                    <a class="layui-btn layui-btn-normal model" title="添加新菜单" href="<?php echo Url::to(['accredit-edit',
                                                                                                            'id' => 0,
                                                                                                            'pid' => 0,
                                                                                                            'level' => 1,
                                                                                                            'p_title' => '无',
                                                                                                            'p_name' => '无']); ?>" >
                        <i class="layui-icon layui-icon-add-circle-fine" style="margin-right: 5px !important;"></i> 添加新权限
                    </a>

                </div>

            </div>

        </div>
        
    </div>

    <?php foreach ($models as $key => $model): ?>

    <div class="layui-card">

        <div class="layui-card-body">

            <div class="layui-tab layui-tab-brief" lay-filter="component-tabs-hash">

                <ul class="layui-tab-title">

                        <li class="layui-this" lay-id="<?php echo $model['id'] ?>"><?php echo $model['description'] ?></li>

                </ul>

                <div class="layui-tab-content">

                        <div class="layui-tab-item layui-show">

                            <table class="layui-table" lay-skin="line">
                                <thead>
                                    <tr>
                                        <th class="of-width-30 of-txt-center">折叠</th>
                                        <th class="of-width-20 of-txt-center"></th>
                                        <th class="of-width-20 of-txt-center">LV</th>
                                        <th class="of-txt-nowrap">标题</th>
                                        <th class="of-txt-nowrap">权限路由</th>
                                        <th class="of-txt-nowrap">排序</th>
                                        <th class="of-txt-nowrap">操作</th>
                                    </tr> 
                                </thead>
                                <tbody>

                                    <tr level="<?php echo $model['level'] ?>">

                                        <td class="of-txt-center"></td>

                                        <td>
                                            <a  href="<?php echo \yii\helpers\Url::to([ 'accredit-edit',
                                                                                        'id'      => 0,
                                                                                        'pid'     => $model['id'],
                                                                                        'level'   => $model['level'] + 1,
                                                                                        'p_title' => $model['description'],
                                                                                        'p_name'  => $model['name']]); ?>"
                                                class="layui-icon layui-icon-add-circle-fine model" title="添加子权限"></a>
                                        </td>

                                        <td class="of-txt-center"><?php echo $model['level']; ?></td>

                                        <td class="of-txt-nowrap"><?php echo $model['description']; ?></td>

                                        <td class="of-txt-nowrap"><?php echo $model['name']; ?></td>

                                        <td>
                                            <div class="layui-form layui-input-inline">
                                                <input  type="number" name="" class="layui-input" min="0"
                                                        value="<?php echo $model['sort'] ?>" style="height: 30px;"
                                                        onchange="rfSort(this, <?php echo $model['id']; ?>)">
                                            </div>
                                        </td>

                                        <td class="of-txt-nowrap">


                                            <div class="layui-btn-group">

                                                <a  href="<?php echo \yii\helpers\Url::to([ 'accredit-edit',
                                                                                            'id'      => $model['id'],
                                                                                            'pid'     => $model['pid'],
                                                                                            'level'   => $model['level'],
                                                                                            'p_title' => $p_title,
                                                                                            'p_name'  => $p_name]); ?>" 
                                                    class="layui-btn layui-btn-primary layui-btn-sm model" title="编辑">
                                                    <i class="layui-icon layui-icon-edit"></i>
                                                </a>

                                                <a  href="<?php echo \yii\helpers\Url::to(['accredit-del', 'id' => $model['id']]) ?>"
                                                    class="layui-btn layui-btn-primary layui-btn-sm of-txt-danger" title="删除" onclick="delDanger(this);return false;">
                                                    <i class="layui-icon layui-icon-delete"></i>
                                                </a>

                                            </div>

                                        </td>
                                        
                                    </tr>

                                    <?php echo $this -> render('accredit-tree', [

                                                'models'  => $model,
                                                'pid'     => $model['id'],
                                                'p_title' => $model['description'],
                                                'p_name'  => $model['name'],

                                            ]); ?>
                                    
                                </tbody>
                            </table>

                        </div>

                </div>
            </div>

        </div>
        
    </div>

    <?php endforeach; ?>
    
</div>

