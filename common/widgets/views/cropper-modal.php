<?php
use yii\helpers\Url;
?>

<div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form class="avatar-form">

                <div class="modal-header">

                    <a class="close" data-dismiss="modal" type="button">&times;</a>

                    <h4 class="modal-title" id="avatar-modal-label">上传图片</h4>

                </div>

                <div class="modal-body">

                    <div class="avatar-body">

                        <div class="avatar-upload">

                            <input class="avatar-src" name="avatar_src" type="hidden">

                            <input class="avatar-data" name="avatar_data" type="hidden">

                            <a class="layui-btn layui-btn-normal" type="button" onClick="$('input[id=avatarInput]').click();">图片选择</a>

                            <span id="avatar-name" style="display: none"></span>

                            <input class="avatar-input hide" id="avatarInput" name="avatar_file" type="file" accept="image/*"></div>

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

                    <a type="button" class="layui-btn layui-btn-primary" data-dismiss="modal">关闭</a>

                    <a type="button" class="layui-btn avatar-save" data-dismiss="modal">保存</a>

                </div>

            </form>

        </div>

    </div>

</div>

<script type="text/javascript">
    // 简单验证
    $('#avatarInput').on('change', function (e) {

        var max_file_size = <?php echo Yii::$app -> config -> get('WEB_MAX_FILE_SIZE'); ?>; // KB

        var target = $(e.target);

        var size = target[0].files[0].size; // KB

        if (max_file_size && size > max_file_size) {

            layer.msg('图片过大，请重新选择!');

            $(".avatar-wrapper").children().remove();

            return false;
        }

        if (!this.files[0].type.match(/image.*/)) {

            layer.msg('请选择正确的图片!');

        } else {

            var file_name = document.querySelector('#avatar-name');

            var texts = document.querySelector('#avatarInput').value;

            var teststr = texts;

            testend = teststr.match(/[^\\]+\.[^\(]+/i);

            file_name.innerHTML = testend;

        }

    });

    $('.avatar-save').on('click', function () {

        var img_lg = document.getElementById('imageHead');

        // 截图小的显示框内的内容
        html2canvas(img_lg, {

            allowTaint: true,

            taintTest: false,

            onrendered: function (canvas) {

                canvas.id = 'mycanvas';

                var dataUrl = canvas.toDataURL();

                var base64 = dataUrl.split(',');

                imagesAjax(base64[1]);

            }

        });

    });

    function imagesAjax(src) {

        var data = {};

        data.image = src;

        data.jid = $('#jid').val();

        $.ajax({

            url: '<?php echo Url::to(['/upload/base64-img']); ?>',

            type: 'post',

            dataType: 'json',

            data: data,

            success: function (data) {

                if (200 == data.code) {

                    data = data.data;

                    $('#avatar > img').attr('src', data.urlPath);

                    $('#avatar > input').val(data.urlPath);

                }

            }

        });

    }
</script>


