<?php foreach ($menus as $k => $menu): ?>

    <tr class="<?php echo $pid ?>" style="<?php echo 1 == $menu['level'] && $menu['child'] ? 'background-color: #f2f2f2;' : ''; ?>">

        <td class="of-txt-center">
            <?php if ($menu['child']): ?>
                <a href="javascript:(0);" id="<?php echo $menu['id']; ?>" onclick="fold(this)" >
                    <i class="zmdi zmdi-minus"></i>
                </a>
            <?php endif; ?>
        </td>

        <td class="of-txt-center"><i class="<?php echo $menu['icon_class'] ?>"></i></td>

        <td>
            <?php if (  (\oframe\basics\common\models\backend\Menu::TYPE_SIDE == $menu['type'] && $menu['level'] < 3) ||
                        (\oframe\basics\common\models\backend\Menu::TYPE_SYS == $menu['type'] && $menu['level'] < 2)) :  ?>
                <a  href="<?php echo \yii\helpers\Url::to([ 'edit',
                                                            'id'      => 0,
                                                            'p_title' => $menu['title'],
                                                            'p_url'   => $menu['url'],
                                                            'pid'     => $menu['id'],
                                                            'type'    => $menu['type'],
                                                            'level'   => $menu['level'] + 1 ]); ?>"
                    class="layui-icon layui-icon-add-circle-fine layer-modal" title="添加子菜单"></a>
            <?php endif; ?>
        </td>

        <td class="of-txt-center"><?php echo $menu['level']; ?></td>

        <td class="of-txt-nowrap">
            <?php
                $level = $menu['level'];
                while($level--) echo '|---';
                echo '&nbsp;&nbsp;' . $menu['title'];
            ?>
        </td>

        <td class="of-txt-nowrap">
            <?php echo $menu['url']; ?>
        </td>

        <td>
            <div class="layui-form layui-input-inline">
                <input  type="number" name="" class="layui-input" min="0"
                        value="<?php echo $menu['sort'] ?>" style="height: 30px;"
                        onchange="rfSort(this, <?php echo $menu['id']; ?>)">
            </div>
        </td>

        <td>
            <?php echo $menu['describe'] ?>
        </td>

        <td>
            <div class="layui-form">
                <input  type="checkbox" name="switch" lay-skin="switch" lay-text="ON|OFF" lay-filter="status"
                        status="<?php echo $menu['status']; ?>" id="<?php echo $menu['id'] ?>"
                        <?php echo \common\enums\StatusEnum::STATUS_ON == $menu['status'] ? 'checked' : ''; ?>>
            </div>
        </td>

        <td class="of-txt-nowrap">


            <div class="layui-btn-group">

                <a  href="<?php echo \yii\helpers\Url::to([ 'edit',
                                                            'id'      => $menu['id'],
                                                            'p_title' => $p_title,
                                                            'p_url'   => $p_url,
                                                            'pid'     => $menu['pid'],
                                                            'type'    => $menu['type'],
                                                            'level'   => $menu['level'] ]); ?>" 
                    class="layui-btn layui-btn-primary layui-btn-sm layer-modal" title="编辑">
                    <i class="layui-icon layui-icon-edit"></i>
                </a>

                <button  href="<?php echo \yii\helpers\Url::to(['status-del', 'id' => $menu['id']]) ?>"
                    class="layui-btn <?php echo in_array($menu['url'], Yii::$app -> params['notDelMenuUrl']) ? 'layui-btn-disabled' : 'layui-btn-primary'; ?> layui-btn-sm of-txt-danger"
                    title="删除"
                    <?php echo in_array($menu['url'], Yii::$app -> params['notDelMenuUrl']) ? '' : 'onclick="delDanger(this);return false;"'; ?>
                    >
                    <i class="layui-icon layui-icon-delete"></i>
                </button>

            </div>

        </td>
        
    </tr>

    <?php echo $this -> render('tree', [

            'menus'   => $menu['child'],
            'pid'     => $menu['id'] . ' ' . $pid,
            'p_title' => $menu['title'],
            'p_url'   => $menu['url']
            
        ]); ?>

<?php endforeach; ?>