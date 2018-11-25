<?php
use yii\helpers\Url;

$this -> title = '数据库管理';
$this -> params['breadcrumbs'][] = ['label' => '系统管理', 'url' => Url::to(['main/setting'])];
$this -> params['breadcrumbs'][] = ['label' => $this -> title];
?>

<div class="layui-col-md12">

    <div class="layui-card">

        <div class="layui-card-body">

            <div class="layui-btn-container">

                <a  class="layui-btn"
                    title="备份数据库" href="<?php echo Url::to(['backup-files']); ?>">
                     备份文件
                </a>

                <div class="of-float-r">
                    
                    <a  class="layui-btn layui-btn-normal"
                        title="备份数据库" href="" >
                         备份
                    </a>

                    <a  class="layui-btn layui-btn-normal"
                        title="优化所有表" href="" >
                         优化
                    </a>

                    <a  class="layui-btn layui-btn-normal"
                        title="修复所有表" href="" >
                         修复
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
                        <th class="of-txt-nowrap">数据表</th>
                        <th class="of-txt-nowrap">表引擎</th>
                        <th class="of-txt-nowrap">记录总数</th>
                        <th class="of-txt-nowrap">数据大小</th>
                        <th class="of-txt-nowrap">编码</th>
                        <th class="of-txt-nowrap">表说明</th>
                        <th class="of-txt-nowrap">创建时间</th>
                        <th class="of-txt-nowrap">操作</th>
                    </tr> 
                </thead>
                <tbody>

                    <?php foreach ($models as $model): ?>

                    <tr>
                        <td><?php echo $model['name']; ?></td>
                        <td><?php echo $model['engine']; ?></td>
                        <td><?php echo $model['rows']; ?></td>
                        <td><?php echo Yii::$app -> formatter -> asShortSize($model['data_length']); ?></td>
                        <td><?php echo $model['collation']; ?></td>
                        <td><?php echo $model['comment']; ?></td>
                        <td><?php echo $model['create_time']; ?></td>
                        <td>

                            <a  href=""
                                class="layui-btn layui-btn-primary layui-btn-xs" lay-event="edit" title="优化 - <?php echo $model['name'] ?>">
                                <i class="zmdi zmdi-code-setting zmdi-hc-fw"></i>优化
                            </a>

                            <a  href=""
                                class="layui-btn layui-btn-primary layui-btn-xs"
                                title="修复 - <?php echo $model['name'] ?>">
                                <i class="zmdi zmdi-wrench zmdi-hc-fw"></i>修复
                            </a>

                        </td>
                    </tr>

                    <?php endforeach; ?>
                    
                </tbody>
            </table>

        </div>
        
    </div>

</div>

