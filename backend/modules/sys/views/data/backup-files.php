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

                            <a  href="<?php echo Url::to(['recover', 'fileName' => $file['name']]) ?>"
                                class="layui-btn layui-btn-primary layui-btn-xs" lay-event="edit" title="还原数据库"
                                onclick="message(this);return false;">
                                <i class="zmdi zmdi-refresh zmdi-hc-fw"></i>还原
                            </a>

                            <a  href="<?php echo Url::to(['download', 'fileName' => $file['name']]); ?>"
                                class="layui-btn layui-btn-primary layui-btn-xs"
                                title="下载">
                                <i class="zmdi zmdi-download zmdi-hc-fw"></i>下载
                            </a>

                            <a  href="<?php echo Url::to(['delete', 'fileName' => $file['name']]); ?>"
                                class="layui-btn layui-btn-danger layui-btn-xs"
                                title="删除"
                                onclick="delDanger(this);return false;">
                                <i class="layui-icon layui-icon-delete"></i>删除
                            </a>

                        </td>
                    </tr>

                    <?php endforeach; ?>
                    
                </tbody>
            </table>

        </div>
        
    </div>

</div>

<script type="text/javascript">
    /**
     * 提示框
     */
    function message(obj) {

        var self = $(obj);

        layer.confirm('是否' + self.attr('title') + '？', function() {

            window.location.href = self.attr('href');

            layer.msg('正在还原，请稍后', {icon: 16});

        });
    }
</script>




