<?php
use yii\helpers\Url;

$this -> title = "配置管理";
$this -> params['breadcrumbs'][] = ['label' => '系统管理', 'url' => Url::to(['/sys/main/setting'])];
$this -> params['breadcrumbs'][] = ['label' => $this -> title];
?>

<div class="layui-col-md12">

    <div class="layui-card">

        <div class="layui-card-body">

            <div class="layui-btn-container">

                <div class="of-float-r">
                    <a class="layui-btn layui-btn-normal model" title="添加新模块" href="<?php echo Url::to(['edit', 
                                                                                                            'id' => 0,
                                                                                                            'pid' => 0,
                                                                                                            'level' => 1,
                                                                                                            'p_name' => '无',
                                                                                                            'p_title' => '无']) ?>">
                        <i class="layui-icon layui-icon-add-circle-fine" style="margin-right: 5px !important;"></i>添加新模块
                    </a>
                    <a class="layui-btn layui-btn-primary model" title="回收站" href="<?php echo Url::to(['recycle']) ?>">
                        <i class="ali-icon ali-icon-dustbin" style="margin-right: 5px;"></i>回收站
                    </a>
                </div>

            </div>

        </div>
        
    </div>


    <div class="layui-card">
        <div class="layui-card-body">

            <div class="layui-tab layui-tab-brief" lay-filter="component-tabs-hash">

                <ul class="layui-tab-title">

                    <?php foreach ($configs as $key =>  $config): ?>
                        <li class="<?php echo 0 == $key ? 'layui-this' : '' ?>" lay-id="<?php echo $config['id'] ?>"><?php echo $config['title'] ?></li>
                    <?php endforeach; ?>

                </ul>

                <div class="layui-tab-content">

                    <?php foreach ($configs as $key => $config): ?>
                        <div class="layui-tab-item <?php echo 0 == $key ? 'layui-show' : '' ?>">

                            <table class="layui-table" lay-skin="line">
                                <thead>
                                    <tr>
                                        <th class="of-width-30 of-txt-center">折叠</th>
                                        <th class="of-width-20 of-txt-center"></th>
                                        <th class="of-width-20 of-txt-center">LV</th>
                                        <th class="of-txt-nowrap">配置名称</th>
                                        <th class="of-txt-nowrap">配置标识</th>
                                        <th class="of-txt-nowrap">类型</th>
                                        <th class="of-txt-nowrap">排序</th>
                                        <th>描述</th>
                                        <th class="of-txt-nowrap">状态</th>
                                        <th class="of-txt-nowrap">操作</th>
                                    </tr> 
                                </thead>
                                <tbody>
                                    <tr>
                                        <th class="of-width-30 of-txt-center">
                                            <?php if ($config['child']): ?>
                                                <a href="javascript:(0);" id="<?php echo $config['id']; ?>" onclick="fold(this)" >
                                                    <i class="zmdi zmdi-minus"></i>
                                                </a>
                                            <?php endif; ?>
                                        </th>
                                        <th class="of-width-20 of-txt-center">
                                            
                                            <a  href="<?php echo \yii\helpers\Url::to([ 'edit', 
                                                                                        'id'      => 0,
                                                                                        'pid'     => $config['id'],
                                                                                        'level'   => $config['level'] + 1,
                                                                                        'p_name'  => $config['name'],
                                                                                        'p_title' => $config['title'],
                                                                                        'anchor'  => $config['id']]); ?>"
                                                class="layui-icon layui-icon-add-circle-fine model" title="添加子配置"></a>

                                        </th>
                                        <th class="of-width-20 of-txt-center"><?php echo $config['level']; ?></th>
                                        <th class="of-txt-nowrap"><?php echo $config['title']; ?></th>
                                        <th class="of-txt-nowrap"><?php echo $config['name']; ?></th>
                                        <th class="of-txt-nowrap"><?php echo Yii::$app -> params['configTypeList'][$config['type']]; ?></th>
                                        <th class="of-txt-nowrap">
                                            <div class="layui-form layui-input-inline">
                                                <input  type="number" name="" class="layui-input" min="0"
                                                        value="<?php echo $config['sort'] ?>" style="height: 30px;"
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
                                                                                            'p_name'  => '无',
                                                                                            'p_title' => '无',
                                                                                            'anchor'  => $config['id']]); ?>" 
                                                    class="layui-btn layui-btn-primary layui-btn-sm model" title="编辑">
                                                    <i class="layui-icon layui-icon-edit"></i>
                                                </a>

                                                <a  href="<?php echo \yii\helpers\Url::to(['status-del', 'id' => $config['id'], 'anchor' => $config['id']]) ?>"
                                                    class="layui-btn layui-btn-primary layui-btn-sm of-txt-danger" title="删除" onclick="delDanger(this);return false;">
                                                    <i class="layui-icon layui-icon-delete"></i>
                                                </a>

                                            </div>

                                        </th>
                                    </tr>

                                    <?php echo $this -> render('tree', [
                                                    'configs' => $config,
                                                    'pid'     => $config['id'],
                                                    'p_title' => $config['title'],
                                                    'p_name'  => $config['name'],
                                                    'anchor'  => $config['id']
                                                ]) ?>

                                </tbody>
                            </table>
                            
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>
    </div>

</div>