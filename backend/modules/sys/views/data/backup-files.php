<?php
use yii\helpers\Url;

$this -> title = '备份文件';
$this -> params['breadcrumbs'][] = ['label' => '系统管理', 'url' => Url::to(['main/setting'])];
$this -> params['breadcrumbs'][] = ['label' => '数据库管理', 'url' => Url::to(['index'])];
$this -> params['breadcrumbs'][] = ['label' => $this -> title];
?>

<div class="layui-col-md12">

    <div class="layui-card">

        <div class="layui-card-body">

            <div class="layui-btn-container">

                <div class="of-float-r">
                    
                    <a class="layui-btn layui-btn-normal" title="返回" href="<?php echo Url::to(['index']); ?>" > 返回 </a>

                </div>

            </div>

        </div>
        
    </div>

    <div class="layui-card">

        <div class="layui-card-body">

            <table class="layui-table" lay-skin="line">
                <thead>
                    <tr>
                        <th class="of-txt-nowrap">备份记录</th>
                        <th class="of-txt-nowrap">文件类型</th>
                        <th class="of-txt-nowrap">文件大小</th>
                        <th class="of-txt-nowrap">备份日期</th>
                        <th class="of-txt-nowrap">操作</th>
                    </tr> 
                </thead>
                <tbody>

                    <?php foreach ($files as $file): ?>

                    <tr>
                        <td><?php echo $file['name']; ?></td>
                        <td><?php echo $file['type']; ?></td>
                        <td><?php echo Yii::$app -> formatter -> asShortSize($file['size']); ?></td>
                        <td><?php echo date('Y-m-d H:i:s', $file['time']); ?></td>
                        <td>

                            <a  href=""
                                class="layui-btn layui-btn-primary layui-btn-xs" lay-event="edit" title="优化">
                                <i class="zmdi zmdi-code-setting zmdi-hc-fw"></i>优化
                            </a>

                            <a  href=""
                                class="layui-btn layui-btn-primary layui-btn-xs"
                                title="修复">
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




