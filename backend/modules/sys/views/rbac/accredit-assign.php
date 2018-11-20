<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this -> title = '分配权限 -- ' . $parent;
$this -> params['breadcrumbs'][] = ['label' => '系统管理', 'url' => Url::to(['main/setting'])];
$this -> params['breadcrumbs'][] = ['label' => '角色管理', 'url' => Url::to(['rbac/role'])];
$this -> params['breadcrumbs'][] = ['label' => $this -> title];
?>

<?php $form = ActiveForm::begin([
                'options' => ['class' => 'layui-form'],
                'fieldConfig' => [
                    'template' => '{input}'
                ]
            ]); ?>

<div class="layui-col-md12">

    <div class="layui-card">
        <div class="layui-card-body">
            <div class="layui-btn-container">
                <div class="of-float-r layui-btn-container">
                    
                    <?php echo Html::submitButton('保&nbsp;&nbsp;存', [
                        'class' => 'layui-btn layui-btn-normal',
                        'lay-submit' => '',
                    ]) ?>

                </div>
            </div>
        </div>
    </div>

    <?php foreach ($accredit as $Level_1): ?>
    <div class="layui-card">
        <div class="layui-card-header">
            <?php echo $Level_1['description'] ?>
            <a href="javascript:void(0);" class="layui-a-tips" onclick="selectAll(this);" value="0">全 选</a>
        </div>
        <div class="layui-card-body">
            <div class="layui-row layui-col-space10">

                <?php foreach ($Level_1['child'] as $Level_2): ?>

                <div class="layui-col-md4">
                    <div class="layui-card">

                        <?php if ($Level_2['child']): ?>

                        <div class="layui-card-header">
                            <?php echo $Level_2['description'] ?>
                            <a href="javascript:void(0);" class="layui-a-tips" onclick="selectAll(this);" value="0">全 选</a>
                        </div>
                        <div class="layui-card-body">

                            <?php foreach ($Level_2['child'] as $Level_3): ?>

                                <div class="layui-col-md4 checkbox">
                                    <input type="checkbox" name="child[]" title="<?php echo $Level_3['description'] ?>" value="<?php echo $Level_3['name'] ?>" lay-skin="primary" <?php echo in_array($Level_3['name'], $AuthItemChild) ? 'checked' : ''; ?>>
                                </div>

                            <?php endforeach; ?>

                        </div>

                        <?php else: ?>

                        <div class="layui-card-body">
                            <div class="checkbox">
                                <input type="checkbox" name="child[]" title="<?php echo $Level_2['description'] ?>" value="<?php echo $Level_2['name'] ?>" lay-skin="primary" <?php echo in_array($Level_2['name'], $AuthItemChild) ? 'checked' : ''; ?>> 
                            </div>
                        </div>

                        <?php endif; ?>
                        
                    </div>
                </div>

                <?php endforeach; ?>

            </div>
        </div>
    </div>
    <?php endforeach; ?>

</div>

<?php ActiveForm::end(); ?>

<script type="text/javascript">
    // 全选
    function selectAll(obj) {

        var self = $(obj);

        var checkbox = self.parent().parent().find('div.checkbox');

        if (self.attr('value') == 0) {

            self.attr('value', 1);
            self.text('取 消');
            checkbox.each(function () {
                checkbox.children('input').attr('checked', '');
                checkbox.children('div.layui-form-checkbox').addClass('layui-form-checked');
            });

        } else {

            self.attr('value', 0);
            self.text('全 选');
            checkbox.each(function () {
                checkbox.children('input').removeAttr('checked');
                checkbox.children('div.layui-form-checkbox').removeClass('layui-form-checked');
            });

        }

    }
</script>