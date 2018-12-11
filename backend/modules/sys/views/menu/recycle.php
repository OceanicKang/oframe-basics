<?php
use yii\helpers\Url;

$this -> context -> layout = '@basics/backend/views/layout/layer-modal';
?>

<table class="layui-table" lay-skin="line">
    <thead>
        <tr>
            <th class="of-txt-nowrap">标题</th>
            <th class="of-txt-nowrap">路由</th>
            <th>描述</th>
            <th class="of-txt-nowrap">操作</th>
        </tr> 
    </thead>
    <tbody>

        <?php foreach ($menus as $menu): ?>

        <tr>

            <td class="of-txt-nowrap"><?php echo $menu['title'] ?></td>

            <td class="of-txt-nowrap"><?php echo $menu['url'] ?></td>

            <td><?php echo $menu['describe'] ?></td>

            <td class="of-txt-nowrap">


                <div class="layui-btn-group">

                    <a  href="<?php echo \yii\helpers\Url::to(['restore', 'id' => $menu['id']]); ?>" 
                        class="layui-btn layui-btn-primary layui-btn-sm" title="还原">
                        <i class="zmdi zmdi-mail-reply"></i>
                    </a>

                    <a  href="<?php echo \yii\helpers\Url::to(['delete', 'id' => $menu['id']]) ?>"
                        class="layui-btn layui-btn-primary layui-btn-sm of-txt-danger" title="删除" onclick="delDanger(this);return false;">
                        <i class="layui-icon layui-icon-delete"></i>
                    </a>

                </div>

            </td>
            
        </tr>

        <?php endforeach; ?>
        
    </tbody>
</table>