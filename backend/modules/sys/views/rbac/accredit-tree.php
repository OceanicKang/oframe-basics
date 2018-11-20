<?php foreach ($models['child'] as $model): ?>

    <tr class="<?php echo $pid ?>" style="<?php echo 2 == $model['level'] && $model['child'] ? 'background-color: #f2f2f2;' : ''; ?>" level="<?php echo $model['level'] ?>">

        <td class="of-txt-center">
            <?php if ($model['child']): ?>
                <a href="javascript:(0);" id="<?php echo $model['id']; ?>" onclick="fold(this)" >
                    <i class="zmdi zmdi-minus"></i>
                </a>
            <?php endif; ?>
        </td>

        <td>
            <?php if ($model['level'] < 3) :  ?>
                <a  href="<?php echo \yii\helpers\Url::to([ 'accredit-edit',
                                                            'id'      => 0,
                                                            'pid'     => $model['id'],
                                                            'level'   => $model['level'] + 1,
                                                            'p_title' => $model['description'],
                                                            'p_name'  => $model['name']]); ?>"
                    class="layui-icon layui-icon-add-circle-fine model" title="添加子权限"></a>
            <?php endif; ?>
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

                <button  href="<?php echo \yii\helpers\Url::to(['accredit-del', 'id' => $model['id']]) ?>"
                    class="layui-btn <?php echo in_array($model['name'], Yii::$app -> params['notDelRbacUrl']) ? 'layui-btn-disabled' : 'layui-btn-primary'; ?> layui-btn-sm of-txt-danger"
                    title="删除"
                    <?php echo in_array($model['name'], Yii::$app -> params['notDelRbacUrl']) ? '' : 'onclick="delDanger(this);return false;"'; ?>
                    >
                    <i class="layui-icon layui-icon-delete"></i>
                </button>

            </div>

        </td>
        
    </tr>

    <?php echo $this -> render('accredit-tree', [

            'models'  => $model,
            'pid'     => $model['id'] . ' ' . $pid,
            'p_title' => $model['description'],
            'p_name'  => $model['name'],
            
        ]); ?>

<?php endforeach; ?>