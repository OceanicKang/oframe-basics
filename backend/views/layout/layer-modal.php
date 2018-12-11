<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;

AppAsset::register($this);
?>

<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app -> language ?>">
<head>
    <?php $this->head() ?>
</head>
<body id="backend">
    
<?php $this->beginBody() ?>


<div class="layer-modal-content" style="padding:20px;overflow: -webkit-paged-x;">

    <?= $content ?>

</div>


<?php $this->endBody() ?>

<script>
    layui.config({
        base: '/resources/backend/' //静态资源所在路径
    }).use(['table', 'form'], function () {
        var form = layui.form;
        form.render(); //更新全部
    });
</script>

</body>
</html>
<?php $this->endPage() ?>
