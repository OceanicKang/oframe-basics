
<?php foreach ($configs['child'] as $config): ?>

<tr class="<?php echo $pid ?>" style="<?php echo 2 == $config['level'] ? 'background-color: #f2f2f2;' : ''; ?>">

    <th class="of-width-30 of-txt-center">
        
        <?php if ($config['child']): ?>
            <a href="javascript:(0);" id="<?php echo $config['id']; ?>" onclick="fold(this)" >
                <i class="zmdi zmdi-minus"></i>
            </a>
        <?php endif; ?>

    </th>

    <th class="of-width-20 of-txt-center">
        
        <?php if ($config['level'] < 3) :  ?>
            <a  href="<?php echo \yii\helpers\Url::to([ 'edit', 
                                                        'id'      => 0,
                                                        'pid'     => $config['id'],
                                                        'level'   => $config['level'] + 1,
                                                        'p_name'  => $config['name'],
                                                        'p_title' => $config['title'],
                                                        'anchor'  => $anchor]); ?>"
                class="layui-icon layui-icon-add-circle-fine model" title="添加子配置"></a>
        <?php endif; ?>

    </th>

    <th class="of-width-20 of-txt-center"><?php echo $config['level']; ?></th>

    <th class="of-txt-nowrap"><?php echo $config['title']; ?></th>

    <th class="of-txt-nowrap"><?php echo $config['name']; ?></th>

    <th class="of-txt-nowrap"><?php echo Yii::$app -> params['configTypeList'][$config['type']]; ?></th>

    <th class="of-txt-nowrap">
        <div class="layui-form layui-input-inline">
            <input  type="number" name="" class="layui-input" min="0"
                    value="<?php echo $config['sort'] ?>"
                    onchange="rfSort(this, <?php echo $config['id']; ?>)">
        </div>
    </th>

    <th><?php echo $config['describe']; ?></th>

    <th class="of-txt-nowrap">
        <div class="layui-form">
            <input  type="checkbox" name="switch" lay-skin="switch" lay-text="ON|OFF" lay-filter="status"
                    status="<?php echo $config['status']; ?>" id="<?php echo $config['id'] ?>"
                    <?php echo \common\enums\StatusEnum::STATUS_ON == $config['status'] ? 'checked' : ''; ?>>
        </div>
    </th>

    <th class="of-txt-nowrap">

        <div class="layui-btn-group">
            <a  href="<?php echo \yii\helpers\Url::to([ 'edit', 
                                                        'id'      => $config['id'],
                                                        'pid'     => $config['pid'],
                                                        'level'   => $config['level'],
                                                        'p_name'  => $p_name,
                                                        'p_title' => $p_title,
                                                        'anchor'  => $anchor]); ?>" 
                class="layui-btn layui-btn-primary layui-btn-sm model" title="编辑">
                <i class="layui-icon layui-icon-edit"></i>
            </a>

            <a  href="<?php echo \yii\helpers\Url::to(['status-del', 'id' => $config['id'], 'anchor' => $anchor]) ?>"
                class="layui-btn layui-btn-primary layui-btn-sm of-txt-danger" title="删除" onclick="delDanger(this);return false;">
                <i class="layui-icon layui-icon-delete"></i>
            </a>
        </div>

    </th>
</tr>

<?php echo $this -> render('tree', [
                'configs' => $config,
                'pid'     => $config['id'] . ' ' . $pid,
                'p_title' => $config['title'],
                'p_name'  => $config['name'],
                'anchor'  => $anchor
            ]) ?>

<?php endforeach; ?>
