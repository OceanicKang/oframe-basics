<?php
use yii\helpers\Html;
?>
<style type="text/css">
    a {
        text-decoration: none
    }
</style>

<div class="of-txt-center" style="<?php echo $containerDivStyle; ?>">

    <div id="avatar" class="layui-upload-drag" data-toggle="modal" data-target="#avatar-modal">

        <img src="<?php echo $value ?>" />

        <?php echo Html::input('hidden', $name, $value, [ 'id' => $id]); ?>

    </div>

    <a class="layui-btn layui-btn-xs" style="margin: 10px 0;" data-toggle="modal" data-target="#avatar-modal"> 图片修改 </a>

</div>
