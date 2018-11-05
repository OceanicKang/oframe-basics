<?php 
use yii\helpers\Url;
?>

<div class="layui-side layui-side-menu">
    <div class="layui-side-scroll">

        <div class="layui-logo" lay-href="home/console.html">
            <span><?php echo Yii::$app -> params['System_Info']['en_name'] ?></span>
        </div>

        <ul class="layui-nav layui-nav-tree" lay-shrink="all" id="LAY-system-side-menu" lay-filter="layadmin-system-side-menu">

            <?php foreach ($menus as $Level_1): ?>

            <li data-name="<?php echo $Level_1['url']; ?>" class="layui-nav-item">

                <a  <?php echo !$Level_1['child'] && 0 === strpos($Level_1['url'], '/') ?
                                'lay-href="' . Url::to([$Level_1['url']]) . '"' :
                                'href="javascript:void(0);"' ?> 
                    lay-tips="<?php echo $Level_1['title'] ?>" lay-direction="2">

                    <i class="<?php echo $Level_1['icon_class'] ?>" style="line-height: 36px;"></i>

                    <cite><?php echo $Level_1['title'] ?></cite>

                    <?php if ($Level_1['child']): ?>
                        <span class="layui-nav-more"></span>
                    <?php endif; ?>
                </a>

                <?php if ($Level_1['child']): ?>
                <dl class="layui-nav-child">
                    <?php foreach ($Level_1['child'] as $Level_2): ?>
                        <?php if ($Level_2['child']): ?>
                        <dd data-name="<?php echo $Level_2['url'] ?>" class="">

                            <a href="<?php echo !$Level_2['child'] && 0 === strpos($Level_2['url'], '/') ?
                                        Url::to([$Level_2['url']]) :
                                        'javascript:void(0);' ?>">
                                <?php echo $Level_2['title'] ?>

                                <span class="layui-nav-more"></span>
                            </a>

                            <dl class="layui-nav-child">

                                <?php foreach ($Level_2['child'] as $Level_3): ?>
                                <dd><a lay-href="<?php echo Url::to([$Level_3['url']]) ?>"><?php echo $Level_3['title']; ?></a></dd>
                                <?php endforeach; ?>

                            </dl>

                        </dd>
                        <?php else: ?>
                        <dd>
                            <a lay-href="<?php echo Url::to([$Level_2['url']]) ?>"><?php echo $Level_2['title']; ?></a>  
                        </dd>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </dl>
                <?php endif; ?>

            </li>

            <?php endforeach; ?>

        </ul>
    </div>
</div>