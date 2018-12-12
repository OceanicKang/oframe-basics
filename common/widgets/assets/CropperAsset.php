<?php
namespace oframe\basics\common\widgets\assets;

use yii\web\AssetBundle;

class CropperAsset extends AssetBundle
{
    public $basePath = '@webroot';

    public $baseUrl = '@web';

    public $css = [
        '/resources/backend/others/cropper/bootstrap.css',
        '/resources/backend/others/cropper/cropper.min.css',
        '/resources/backend/others/cropper/sitelogo.css'
    ];

    public $js = [
        '/resources/backend/others/cropper/bootstrap.min.js',
        '/resources/backend/others/cropper/cropper.js',
        '/resources/backend/others/cropper/sitelogo.js',
        '/resources/backend/others/cropper/html2canvas.min.js'
    ];

    /**
     * @inheritdoc
     */
    public $jsOptions = [
        'position' => \yii\web\View::POS_BEGIN,   // 这是设置所有js放置的位置
    ];
}