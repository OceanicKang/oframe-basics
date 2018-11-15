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
                        <th class="of-txt-nowrap" style="width: 200px;">操作</th>
                    </tr> 
                </thead>
                <tbody>

                    <?php foreach ($models as $model): ?>

                        <tr>

                            <td class="of-txt-center"></td>

                            <td class="of-txt-nowrap"><?php echo $model['name']; ?></td>

                            <td class="of-txt-nowrap"><?php echo $model['description']; ?></td>

                            <td class="of-txt-nowrap"><?php echo date('Y/m/d H:i', $model['append']); ?></td>

                            <td class="of-txt-nowrap"><?php echo date('Y/m/d H:i', $model['updated']); ?></td>

                            <td>
                                <div class="layui-form layui-input-inline">
                                    <input  type="number" name="" class="layui-input" min="0"
                                            value="<?php echo $model['sort'] ?>" style="height: 30px;"
                                            onchange="rfSort(this, <?php echo $model['id']; ?>)">
                                </div>
                            </td>

                            <td class="of-txt-nowrap">

                                <div class="layui-btn-group">

                                    <a  href="<?php echo Url::to(['role-edit', 'id' => $model['id']]); ?>" 
                                        class="layui-btn layui-btn-primary layui-btn-sm model" title="编辑">
                                        <i class="layui-icon layui-icon-edit"></i>
                                    </a>

                                    <button  href="<?php echo Url::to(['role-del', 'id' => $model['id']]) ?>"
                                        class="layui-btn <?php echo in_array($model['name'], Yii::$app -> params['defaultNotDelRoleName']) ? 'layui-btn-disabled' : 'layui-btn-primary'; ?> layui-btn-sm of-txt-danger"
                                        title="删除"
                                        <?php echo in_array($model['name'], Yii::$app -> params['defaultNotDelRoleName']) ? '' : 'onclick="delDanger(this);return false;"'; ?>
                                        >
                                        <i class="layui-icon layui-icon-delete"></i>
                                    </button>

                                </div>

                                <a  href="<?php echo Url::to(['accredit-assign', 'parent' => $model['name']]) ?>"
                                    class="layui-btn layui-btn-primary layui-btn-sm" title="分配权限">
                                    分配权限
                                </a>

                            </td>
                            
                        </tr>

                    <?php endforeach; ?>
                    
                </tbody>
            </table>

        </div>
        
    </div>

</div>

