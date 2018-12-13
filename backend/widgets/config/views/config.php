<?php
use yii\helpers\Html;
?>

<?php if ($config['type'] == 'text'): ?>

<div class="layui-form-item">
    <label class="layui-form-label" for="<?php echo $config['id']; ?>" title="<?php echo $config['name']; ?>"><?php echo $config['title'] ?></label>
    <div class="layui-input-inline" style="width: 30%;">
        <?php echo Html::input('text', 'Setting[' . $config['name'] . ']', $config['value'], ['id' => $config['id'],'class' => 'layui-input']); ?>
    </div>
    <div class="layui-form-mid layui-word-aux layui-col-md6"><?php echo $config['describe'] ?></div>
</div>

<?php elseif ($config['type'] == 'number'): ?>

<div class="layui-form-item">
    <label class="layui-form-label" for="<?php echo $config['id']; ?>" title="<?php echo $config['name']; ?>"><?php echo $config['title'] ?></label>
    <div class="layui-input-inline" style="width: 80px;">
        <?php echo Html::input('number', 'Setting[' . $config['name'] . ']', $config['value'], ['id' => $config['id'],'class' => 'layui-input', 'lay-verify' => 'number']); ?>
    </div>
    <div class="layui-form-mid layui-word-aux"><?php echo $config['describe'] ?></div>
</div>

<?php elseif ($config['type'] == 'password'): ?>

<div class="layui-form-item">
    <label class="layui-form-label" for="<?php echo $config['id']; ?>" title="<?php echo $config['name']; ?>"><?php echo $config['title'] ?></label>
    <div class="layui-input-inline" style="width: 30%;">
        <?php echo Html::input('password', 'Setting[' . $config['name'] . ']', $config['value'], ['id' => $config['id'],'class' => 'layui-input']); ?>
    </div>
    <div class="layui-form-mid layui-word-aux"><?php echo $config['describe'] ?></div>
</div>

<?php elseif ($config['type'] == 'secretKeyText'): ?>


<?php elseif ($config['type'] == 'textarea'): ?>

<div class="layui-form-item">
    <label class="layui-form-label" for="<?php echo $config['id']; ?>" title="<?php echo $config['name']; ?>"><?php echo $config['title'] ?></label>
    <div class="layui-input-block" style="width: 70%;">
        <?php echo Html::textarea('Setting[' . $config['name'] . ']', $config['value'], ['id' => $config['id'],'class' => 'layui-textarea', 'placeholder' => $config['describe']]); ?>
    </div>
</div>

<?php elseif ($config['type'] == 'dropDownList'): ?>


<?php elseif ($config['type'] == 'radioList'): ?>

<div class="layui-form-item">
    <label class="layui-form-label" for="<?php echo $config['id']; ?>" title="<?php echo $config['name']; ?>"><?php echo $config['title'] ?></label>
    <div class="layui-input-block">

        <?php foreach ($config['extra'] as $value => $title): ?>
        <input type="radio"
               name="Setting[<?php echo $config['name'] ?>]"
               value="<?php echo $value ?>"
               title=" <?php echo $title ?>"
               <?php echo ($config['value'] == $value) ? 'checked' : ''; ?> >
        <?php endforeach; ?>

    </div>
</div>

<?php elseif ($config['type'] == 'statusRadio'): ?>

<div class="layui-form-item">
    <label class="layui-form-label" for="<?php echo $config['id']; ?>" title="<?php echo $config['name']; ?>"><?php echo $config['title'] ?></label>
    <div class="layui-input-inline" style="width: 80px;">
        <input type="hidden" name="<?php echo 'Setting[' . $config['name'] . ']'; ?>" value="0">
        <input type="checkbox" name="<?php echo 'Setting[' . $config['name'] . ']'; ?>" lay-skin="switch" lay-text="ON|OFF" value="1" <?php echo $config['value'] ? 'checked' : '' ?>>
    </div>
    <div class="layui-form-mid layui-word-aux"><?php echo $config['describe'] ?></div>
</div>

<?php elseif ($config['type'] == 'image'): ?>


<?php elseif ($config['type'] == 'images'): ?>


<?php elseif ($config['type'] == 'file'): ?>


<?php elseif ($config['type'] == 'files'): ?>
    

<?php endif; ?>