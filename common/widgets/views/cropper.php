<?php
use yii\helpers\Html;
?>

<style type="text/css">
    .of-circle, .of-circle img {
        border-radius: 100%;
        width: 15em;
        height: 15em;
        display: block;
        margin: auto;
        padding: 0px;
    }
    .of-txt-center > a {
        text-decoration: none
    }
</style>

<div <?php if ($containerDivOptions) foreach ($containerDivOptions as $k => $v) echo $k . '="' . $v . '" '; ?>>

    <div class="layui-upload-drag of-circle">

        <img src="<?php echo $value ?>" />

    </div>

    <a class="layui-btn layui-btn-xs" style="margin: 10px 0;" data-toggle="modal" data-target="#avatar-modal"> 图片修改 </a>

</div>

<div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" data-backdrop="false" role="dialog" tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form class="avatar-form">

                <div class="modal-header">

                    <button class="close" data-dismiss="modal" type="button">&times;</button>

                    <h4 class="modal-title" id="avatar-modal-label">上传图片</h4>

                </div>

                <div class="modal-body">

                    <div class="avatar-body">

                        <div class="avatar-upload">

                            <input class="avatar-src" name="avatar_src" type="hidden">

                            <input class="avatar-data" name="avatar_data" type="hidden">

                            <button class="layui-btn layui-btn-normal"  type="button" style="height: 35px;" onClick="$('input[id=<?php echo $id ?>]').click();">图片选择</button>

                            <span id="avatar-name" style="display: none"></span>

                            <input class="avatar-input hide" id="<?php echo $id ?>" name="<?php echo $name ?>" value="<?php echo $value ?>" type="file" accept="image/*"></div>

                        <div class="row">

                            <div class="col-md-9">

                                <div class="avatar-wrapper"></div>

                            </div>

                            <div class="col-md-3">

                                <div class="avatar-preview preview-lg" id="imageHead"></div>

                                <div class="avatar-preview preview-md"></div>

                                <div class="avatar-preview preview-sm"></div>

                            </div>

                        </div>

                        <div class="row avatar-btns">

                            <div class="col-md-3">

                                <span class="layui-btn layui-btn-primary layui-btn-sm fa fa-undo" data-method="rotate" data-option="-90" title="向左旋转90°"> 
                                    <i class="zmdi zmdi-undo"></i>
                                    左旋转
                                </span>

                                <span class="layui-btn layui-btn-primary layui-btn-sm fa fa-repeat" data-method="rotate" data-option="90" title="向右旋转90°">
                                    <i class="zmdi zmdi-redo"></i>
                                    右旋转
                                </span>

                            </div>

                            <div class="col-md-6" style="text-align: right;">

                                <div class="layui-btn layui-btn-primary layui-btn-sm fa fa-arrows" data-method="setDragMode" data-option="move" title="移动">
                                    <i class="zmdi zmdi-arrows"></i>
                                    移动
                                </div>

                                <div class="layui-btn layui-btn-primary layui-btn-sm fa fa-crop" data-method="setDragMode" data-option="crop" title="裁剪">
                                    <i class="zmdi zmdi-crop"></i>
                                    裁剪
                                </div>

                                <div class="layui-btn layui-btn-primary layui-btn-sm fa fa-search-plus" data-method="zoom" data-option="0.1" title="放大图片">
                                    <i class="zmdi zmdi-zoom-in"></i>
                                    放大
                                 </div>

                                <div class="layui-btn layui-btn-primary layui-btn-sm fa fa-search-minus" data-method="zoom" data-option="-0.1" title="缩小图片"> 
                                    <i class="zmdi zmdi-zoom-out"></i>
                                    缩小
                                </div>

                                <div type="button" class="layui-btn layui-btn-primary layui-btn-sm fa fa-refresh" data-method="reset" title="重置图片">
                                    <i class="zmdi zmdi-refresh-alt"></i>
                                    重置
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="layui-btn layui-btn-primary" data-dismiss="modal">关闭</button>

                    <button type="button" class="layui-btn avatar-save" data-dismiss="modal">保存</button>

                </div>

            </form>

        </div>

    </div>

</div>




<script type="text/javascript">
    $(document).on("show.bs.modal", ".modal", function () {
        $(this).parent().append("<div class=\"modal-backdrop fade in\"></div>");
    });

    $(document).on("hide.bs.modal", ".modal", function () {
        $(".modal-backdrop").remove();
    })
</script>

