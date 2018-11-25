<?php 
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;

$this -> title = '后台用户管理';
$this -> params['breadcrumbs'][] = ['label' => '系统管理', 'url' => Url::to(['main/setting'])];
$this -> params['breadcrumbs'][] = ['label' => $this -> title];
?>

<div class="layui-fluid">   
    <div class="layui-card">
        <div class="layui-form layui-card-header layuiadmin-card-header-auto">
            <div class="layui-form-item">
                <?php $form = ActiveForm::begin([
                        'id' => 'search',
                        'method' => 'get',
                        'fieldConfig' => [
                            'template' => ' {label}
                                            <div class="layui-input-block">
                                                {input}
                                            </div>',
                            'options' => ['class' => 'layui-inline'],
                            'labelOptions' => ['class' => 'layui-form-label'],
                            'inputOptions' => ['class' => 'layui-input'],
                        ]
                    ]); ?>

                <!-- 登录名 -->
                <?php echo $form -> field($search , 'username') -> textInput([
                                'placeholder' => '请输入',
                            ]) -> label('登录名'); ?>

                <!-- 手机号 -->
                <?php echo $form -> field($search , 'mobile_phone') -> textInput([
                                'placeholder' => '请输入',
                            ]) -> label('手机'); ?>

                <!-- 邮箱 -->
                <?php echo $form -> field($search , 'email') -> textInput([
                                'placeholder' => '请输入',
                            ]) -> label('邮箱'); ?>

                <!-- 角色 -->
                <?php echo $form -> field($search, 'role_id') -> dropDownList($roles, [
                                'prompt' => '请选择'
                            ]) -> label('角色'); ?>

                <div class="layui-inline">

                    <?php echo Html::submitButton('<i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>', [
                                    'class' => 'layui-btn layui-btn-fluid',
                                    'lay-submit' => '',
                                ]) ?>

                </div>

                <?php ActiveForm::end(); ?>
            </div>

        </div>
      
        <div class="layui-card-body">

            <div style="padding-bottom: 10px;">
                <button href="<?php echo Url::to(['edit', 'id' => 0]) ?>" class="layui-btn layuiadmin-btn-admin model" data-type="add" title="添加用户"> 添加 </button>
            </div>

            <style type="text/css">
                .layui-table-view {border-bottom-width: 0px !important;}
            </style>
            
            <div class="layui-form layui-border-box layui-table-view">
                <div class="layui-table-box">
                    <div class="layui-table-header" style="width: 100%; overflow-x: auto;">
                        <table class="layui-table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">
                                        <div class="layui-table-cell" align="center">
                                            <span>ID</span>
                                        </div>
                                    </th>
                                    <th style="width: 5%;">
                                        <div class="layui-table-cell" align="center">
                                            <span>头像</span>
                                        </div>
                                    </th>
                                    <th style="width: 10%;">
                                        <div class="layui-table-cell">
                                            <span>登录名</span>
                                        </div>
                                    </th>
                                    <th style="width: 10%;">
                                        <div class="layui-table-cell">
                                            <span>昵称</span>
                                        </div>
                                    </th>
                                    <th style="width: 14%;">
                                        <div class="layui-table-cell">
                                            <span>手机</span>
                                        </div>
                                    </th>
                                    <th style="width: 14%;">
                                        <div class="layui-table-cell">
                                            <span>邮箱</span>
                                        </div>
                                    </th>
                                    <th style="width: 14%;">
                                        <div class="layui-table-cell">
                                            <span>角色</span>
                                        </div>
                                    </th>
                                    <th style="width: 14%;">
                                        <div class="layui-table-cell">
                                            <span>加入时间</span>
                                        </div>
                                    </th>
                                    <th class="layui-table-col-special" style="width: 14%;border-right-width: 0px;">
                                        <div class="layui-table-cell" align="center">
                                            <span>操作</span>
                                        </div>
                                    </th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php foreach ($models as $model): ?>
                                <tr>
                                    <td>
                                        <div class="layui-table-cell" align="center"><?php echo $model['id']; ?></div>
                                    </td>
                                    <td>
                                        <div class="layui-table-cell" align="center">
                                            <img style="display: inline-block; width: auto; height: 100%;" src="<?php echo $model['head_img'] ?>">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="layui-table-cell"><?php echo $model['username']; ?></div>
                                    </td>
                                    <td>
                                        <div class="layui-table-cell"><?php echo $model['nickname'] ?: $model['username']; ?></div>
                                    </td>
                                    <td>
                                        <div class="layui-table-cell"><?php echo $model['mobile_phone'] ?: '提醒该用户及时登记'; ?></div>
                                    </td>
                                    <td>
                                        <div class="layui-table-cell"><?php echo $model['email'] ?: '提醒该用户及时登记'; ?></div>
                                    </td>
                                    <td>
                                        <div class="layui-table-cell"><?php echo $model['roleName']['item_name'] ?? '提醒权限管理员及时分配';  ?></div>
                                    </td>
                                    <td>
                                        <div class="layui-table-cell"><?php echo date('Y/m/d H:i', $model['append']); ?></div>
                                    </td>
                                    
                                    <td align="center" class="layui-table-col-special" style="border-right: none;">
                                        <div class="layui-table-cell">
                                            <a href="<?php echo Url::to(['edit', 'id' => $model['id']]) ?>" class="layui-btn layui-btn-normal layui-btn-xs model" lay-event="edit" title="编辑 - <?php echo $model['username'] ?>">
                                                <i class="layui-icon layui-icon-edit"></i>编辑
                                            </a>
                                            <a  href="<?php echo Url::to(['delete', 'id' => $model['id']]) ?>"
                                                class="layui-btn <?php echo in_array($model['id'], Yii::$app -> params['adminAccount']) ? 'layui-btn-disabled' : 'layui-btn-danger'; ?>  layui-btn-xs"
                                                title="删除"
                                                <?php echo in_array($model['id'], Yii::$app -> params['adminAccount']) ? '' : 'onclick="delDanger(this);return false;"'; ?>
                                                >
                                                <i class="layui-icon layui-icon-delete"></i>删除
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>

                            </tbody>
                        </table>

                    </div>

                </div>

            </div>


            <?= LinkPager::widget([
                'pagination'        => $pages,
                'maxButtonCount'    => 5,
                'firstPageLabel'    => '首页',
                'lastPageLabel'     => '尾页',
                'nextPageLabel'     => '下一页',
                'prevPageLabel'     => "上一页",
                'activeLinkOptions' => ['style' => 'background-color:#1E9FFF;'],
            ]);?>


        </div>
    </div>
</div>
