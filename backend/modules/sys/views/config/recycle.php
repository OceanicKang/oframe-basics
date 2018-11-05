<?php
use yii\helpers\Url;

$this -> context -> layout = '@basics/backend/views/layout/model';
?>

<table class="layui-table" lay-skin="line">
    <thead>
        <tr>
            <th class="of-txt-nowrap">标题</th>
            <th class="of-txt-nowrap">标识</th>
            <th>描述</th>
            <th class="of-txt-nowrap">操作</th>
        </tr> 
    </thead>
    <tbody>

        <?php foreach ($configs as $config): ?>

        <tr>

            <td class="of-txt-nowrap"><?php echo $config['title'] ?></td>

            <td class="of-txt-nowrap"><?php echo $config['name'] ?></td>

            <td><?php echo $config['describe'] ?></td>

            <td class="of-txt-nowrap">


                <div class="layui-btn-group">

                    <a  href="<?php echo \yii\helpers\Url::to(['restore', 'id' => $config['id']]); ?>" 
                        class="layui-btn layui-btn-primary layui-btn-sm model" title="还原">
                        <i class="zmdi zmdi-mail-reply"></i>
                    </a>

                    <a  href="<?php echo \yii\helpers\Url::to(['delete', 'id' => $config['id']]) ?>"
                        class="layui-btn layui-btn-primary layui-btn-sm of-txt-danger" title="删除" onclick="delDanger(this);return false;">
                        <i class="layui-icon layui-icon-delete"></i>
                    </a>

                </div>

            </td>
            
        </tr>

        <?php endforeach; ?>
        
    </tbody>
</table>