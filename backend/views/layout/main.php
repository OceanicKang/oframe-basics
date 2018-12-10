<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert2;
use oframe\basics\backend\widgets\pages\HeaderWidget;
use oframe\basics\backend\widgets\pages\MenuWidget;
use common\enums\StatusEnum;

AppAsset::register($this);
?>

<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app -> language ?>">
<head>
    <meta charset="<?= Yii::$app -> charset ?>">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <?= Html::csrfMetaTags() ?>

    <title><?= Html::encode($this->title) ?></title>

    <?php $this->head() ?>
</head>
<body layadmin-themealias="default" id="backend">
    
<?php $this->beginBody() ?>

<div class="layui-fluid layui-anim layui-anim-upbit" data-anim="layui-anim-upbit" style="padding-bottom: 100px;">
    <div class="layui-row layui-col-space15">


        <div id="lay-breadcrumbs">

        <?php echo Breadcrumbs::widget([
                        'options' => [
                            'class' => 'layui-breadcrumb',
                            'lay-separator' => '/',
                        ],
                        'homeLink' => [
                            'label' => Yii::$app -> config -> get('WEB_SITE_AD_NAME'),
                            'url' => Url::to(['/sys/main/index'])
                        ],
                        'tag' => 'span',
                        'itemTemplate' => '{link}',
                        'activeItemTemplate'=>"<a><cite>{link}</cite></a>",
                        'links' => isset($this -> params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ]) ?>
        </div>
        
        <?= Alert2::widget() ?>

        <div class="layui-layout layui-layout-admin">

            <?= $content ?>

        </div>
    </div>
</div>

<?php $this->endBody() ?>

<script>
    layui.config({
        base: '/resources/backend/' //静态资源所在路径
    }).extend({
        index: '/lib/index' //主入口模块
    }).use(['index', 'table', 'form', 'set'], function () {
        var $ = layui.$
        ,admin = layui.admin
        ,element = layui.element
        ,form = layui.form
        ,router = layui.router();

        // 监控 状态 input
        form.on('switch(status)', function(data) {
            var id = $(data.elem).attr('id');
            rfStatus(data.elem, id);
        });
        
        //弹出一个 model 层
        $('.model').on('click', function () {

            var self = this;

            var title = $(self).attr('title');
            var href = $(self).attr('href');

            // 加载动画
            var ii = layer.load();

            $.ajax({
                type: 'GET',
                url: href,
                success: function (str) {

                    layer.close(ii);

                    layer.open({

                        type: 1,

                        area: ['600px', 'auto'],

                        maxmin: true,

                        shadeClose: true, //点击遮罩关闭层

                        title: title,

                        content: str //注意，如果str是object，那么需要字符拼接。

                    });

                },
                error: function (str) {

                    layer.close(ii);

                    layer.open({

                        type: 1,

                        area: ['600px', 'auto'],

                        maxmin: true,

                        shadeClose: true, //点击遮罩关闭层

                        title: title,

                        content: str.responseText //注意，如果str是object，那么需要字符拼接。

                    });

                }

            });

            return false;
        });

        /* Hash地址的定位 */
        var layid = router.hash.replace(/^#layid=/, '');
        layid && element.tabChange('component-tabs-hash', layid);
        
        element.on('tab(component-tabs-hash)', function(elem){
            location.hash = '/'+ '#layid=' + $(this).attr('lay-id');
        });

    });
</script>

<script type="text/javascript">
    /**
     * 全局排序
     */
    function rfSort(obj, id) {

        var sort = $(obj).val();

        if (isNaN(sort) || '' == sort) {

            layer.msg('排序只能为数字', {icon: 5});
            return false;

        } else {

            $.ajax({

                type: 'get',

                url: '<?php echo Url::to(['ajax-update']); ?>',

                dataType: 'json',

                data: {id:id,sort:sort},

                success: function (data) {

                    if (data.code != 200) 
                        layer.msg(data.message, {icon: 5});

                }

            })

        }

    }

    /**
     * 全局修改状态
     */
    function rfStatus(obj, id) {

        var status = <?php echo StatusEnum::STATUS_OFF; ?>; self = $(obj);

        if (<?php echo StatusEnum::STATUS_OFF; ?> == self.attr('status')) {

            status = <?php echo StatusEnum::STATUS_ON; ?>

        } else {

            status = <?php echo StatusEnum::STATUS_OFF; ?>;

        }

        $.ajax({

            type: 'get',

            url: '<?php echo Url::to(['ajax-update']); ?>',

            dataType: 'json',

            data: {id:id,status:status},

            success: function (data) {

                if (200 == data.code) {

                    self.attr('status', status);

                }

            }

        })

    }

    /**
     * 删除警告
     */
    function delDanger(obj) {

        var href = $(obj).attr('href');

        layer.confirm('真的删除吗？', function() {

            window.location.href = href;

            layer.msg('正在删除', {icon: 16}, function() {});

        });
    }
    
</script>

<script type="text/javascript">
    
    function fold (element) {

        var tr = $('tr.' + $(element).attr('id'));

        var type = $(element).children().attr('class');

        if ('zmdi zmdi-minus' == type) {

            tr.hide();

            tr.children('td.of-txt-center').find('i.zmdi-minus').addClass('zmdi-plus');
            tr.children('td.of-txt-center').find('i.zmdi-plus').removeClass('zmdi-minus');

            $(element).children().addClass('zmdi-plus');
            $(element).children().removeClass('zmdi-minus');

        } else {

            tr.show();

            tr.children('td.of-txt-center').find('i.zmdi-plus').addClass('zmdi-minus');
            tr.children('td.of-txt-center').find('i.zmdi-minus').removeClass('zmdi-plus');

            $(element).children().addClass('zmdi-minus');
            $(element).children().removeClass('zmdi-plus');

        }

    }

</script>


</body>
</html>
<?php $this->endPage() ?>
