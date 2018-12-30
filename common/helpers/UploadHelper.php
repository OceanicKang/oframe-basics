<?php
namespace oframe\basics\common\helpers;

use Yii;
use yii\imagine\Image;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;

/**
 * 上传助手类
 *
 * Class UploadHelper
 * @package oframe\basics\common\helpers
 */
class UploadHelper
{
    /**
     * 上传配置
     * @var array 
     */
    public $config = [];

    /**
     * 上传路径
     * @var array
     */
    public $paths = [];

    /**
     * 上传文件基础信息
     * @var array
     */
    public $fileBaseInfo = [];

    /**
     * Yii2 上传类
     * @var object
     */
    public $uploadedFile;

    /**
     * $_File 名称
     * @var string
     */
    public $uploadFileName = 'file';

    /**
     * 上传类型
     * @var string
     */
    public $type = 'image';

    /**
     * 上传方法
     * @var string
     */
    public $takeOverAction = 'local';

    /**
     * 文件名称
     * @var string
     */
    public $fileName;

    /**
     * 切片合并缓存前缀
     *
     * @var string
     */
    public static $prefixForMergeCache = 'upload:file:guid:';

    /**
     * 初始化
     * @Author OceanicKang 2018-12-17
     * @param  array       $config    post数据，可直接传入 Yii::$app -> request -> post()
     * @param  string      $type      上传类型
     */
    public function __construct(array $config, $type)
    {
        $this -> filter($config, $type);

        $this -> type = $type;
    }

    /**
     * 验证是否符合上传
     * @Author OceanicKang 2018-12-17
     * @param  array       $fileBaseInfo Array([name] => temp.jpg, [size] => 1024, [extension] => 'jpg')
     * @throws NotFoundHttpException
     * @return true
     */
    public function verify($fileBaseInfo = [])
    {
        if (empty($fileBaseInfo)) {

            $uploadedFile = UploadedFile::getInstanceByName($this -> uploadFileName);

            $fileBaseInfo = [

                'size' => $uploadedFile -> size,

                'name' => $uploadedFile -> getBaseName(),

                'extension' => $uploadedFile -> getExtension()

            ];

            $this -> uploadedFile = $uploadedFile;

        }

        if ($fileBaseInfo['size'] > $this -> config['maxSize'])
            throw new NotFoundHttpException('文件过大，请小于' . $this -> config['maxSize'] / 1024 / 1024 . 'M');

        if (!empty($this -> config['extensions']) && !in_array($fileBaseInfo['extension'], $this -> config['extensions']))
            throw new NotFoundHttpException('文件类型不允许，请选择（' . implode(',', $this -> config['extensions']) . '）类型的文件');

        $this -> fileBaseInfo = $fileBaseInfo;

        unset($uploadedFile, $uploadedFile);

        return true;
    }


    /**
     * 验证远程图片是否符合上传
     * @Author OceanicKang 2018-12-19
     * @param  [type]      $imgUrl    远程图片地址
     * @throws NotFoundHttpException
     * @return true
     */
    public function verifyRemote($imgUrl)
    {
        $imgUrl = str_replace('&amp;', '&', htmlspecialchars($imgUrl));

        // http 开头验证
        if (0 !== strpos($imgUrl, 'http')) throw new NotFoundHttpException('请输入以http/https开头的URL地址');

        preg_match('/(^https?:\/\/[^:\/]+)/', $imgUrl, $matches);

        // 带协议的 host
        $host_with_protocol = count($matches) > 1 ? $matches[1] : '';

        // 判断是否为合法 URL
        if (!filter_var($host_with_protocol, FILTER_VALIDATE_URL)) throw new NotFoundHttpException('URL 不合法');

        preg_match('/^https?:\/\/(.+)/', $host_with_protocol, $matches);

        // 不带协议的 host
        $host_without_protocol = count($matches) > 1 ? $matches[1] : '';

        // 获取 IP
        $ip = gethostbyname($host_without_protocol);

        // 获取请求头
        $heads = get_headers($imgUrl, 1);

        //检测死链
        if (!(stristr($heads[0], '200') && stristr($heads[0], 'OK')))
            throw new NotFoundHttpException('文件获取失败');

        // Content-Type 验证
        if (!isset($heads['Content-Type']) || !stristr($heads['Content-Type'], 'image'))
            throw new NotFoundHttpException('格式验证失败');

        // 验证文件类型
        $extend = FileHelper::getFileTypeToEN($imgUrl);
        if (!empty($this -> config['extensions']) && !in_array($extend, $this -> config['extensions']))
            throw new NotFoundHttpException('文件类型不允许');

        // 打开输出缓冲区，并获取远程图片
        ob_start();

        $context = stream_context_create(
            [
                'http' => [
                    'follow_location' => false // don't follow redirects
                ]

            ]
        );

        readfile($imgUrl, false, $context);

        $img = ob_get_contents(); // 读取缓冲区

        ob_end_clean();

        preg_match("/[\/]([^\/]*)[\.]?[^\.\/]*$/", $imgUrl, $m);

        $size = strlen($img);

        if ($size > $this -> config['maxSize'])
            throw new NotFoundHttpException('文件过大，请小于' . $this -> config['maxSize'] / 1024 / 1024 . 'M');

        $this -> fileBaseInfo = [

            'size' => $size,

            'name' => $m ? $m[1] : '',

            'extension' => $extend

        ];

        $this -> config['image'] = $img;

        return true;
    }

    /**
     * 直接上传
     * @Author OceanicKang 2018-12-19
     * @param  string      $takeOverAction 上传方法
     * @throws NotFoundHttpException 
     * @return string
     */
    public function save($takeOverAction = '')
    {
        $takeOverAction = $takeOverAction ?: $this -> takeOverAction;

        // 获取附件路径
        $paths = $this -> getPaths();
        // 文件名.扩展名
        $fileName = $this -> fileName . '.' . $this -> fileBaseInfo['extension'];
        // 文件绝对路径
        $fileAbsolutePath = $paths['absolutePath'] . $fileName;

        switch ($takeOverAction) {

            // 本地上传
            case 'local':
                $url = $this -> local($fileName, $fileAbsolutePath);

                // 图片继续执行
                if ('images' == $this -> type) {

                    // 图片水印
                    $this -> watermark($fileAbsolutePath);

                    // 图片压缩
                    $this -> compress($fileAbsolutePath);

                    // 创建缩略图
                    $this -> thumb($fileAbsolutePath);

                }

                return $this -> getUrl($url);
                break;

            // 阿里 oss 上传
            case 'oss':
                break;

            // 七牛上传
            case 'qiniu':
                break;

            // base64 上传
            case 'base64':
                break;

            // 远程拉取
            case 'remote':
                break;

            default:
                throw new NotFoundException('找不到上传方法');
                break;
        }

    }

    /* ----------------------------------------------- 这是一条华丽的分割线 ----------------------------------------------- */

    /**
     * 创建文件路径
     * @Author OceanicKang 2018-12-19
     * @throws NotFoundException
     * @return array
     */
    protected function getPaths()
    {
        if (!empty($this -> paths)) return $this -> paths;

        $config = $this -> config;

        $this -> fileName = $config['prefix'] . StringHelper::randomNum(time());

        // 保留原名
        if (true == $config['originalName'] && !empty($this -> fileBaseInfo['name'])) $this -> fileName = $this -> fileBaseInfo['name'];

        // 文件路径
        $filePath = $config['path'] . date($config['subName'], time()) . '/';

        // 缩略图
        $thumbPath = $this -> config['thumb']['path'] . date($config['subName'], time()) . '/';

        $paths = [
            'relativePath' => Yii::getAlias('@attachurl/') . $filePath,  // 相对路径
            'absolutePath' => Yii::getAlias('@attachment/') . $filePath, // 绝对路径
            'thumbRelativePath' => Yii::getAlias('@attachurl/') . $thumbPath, // 缩略图相对路径
            'thumbAbsolutePath' => Yii::getAlias('@attachment/') . $thumbPath // 缩略图绝对路径
        ];

        $this -> paths = $paths;

        // 创建目录
        unset($paths['relativePath'], $paths['thumbRelativePath'], $paths['tmpRelativePath']);

        foreach ($paths as $key => $path) {

            if (!FileHelper::mkdirs($path)) throw new NotFoundHttpException('文件创建失败，请确认是否开启attachment文件夹写入权限');

        }

        unset($paths);

        return $this -> paths;
    }

    /**
     * 获取文件最终地址
     * @Author OceanicKang 2018-12-30
     * @param  string      $url       文件URL
     * @return string
     */
    protected function getUrl($url)
    {
        if (true == $this -> config['fullPath']) $url = Yii::$app -> request -> hostInfo . $url;

        return $url;
    }

    /**
     * 本地上传
     * @Author OceanicKang 2018-12-20
     * @param  string      $fileName         文件名
     * @param  string      $fileAbsolutePath 文件绝对路径
     * @return string                        文件相对路径+文件名
     */
    protected function local($fileName, $fileAbsolutePath)
    {
        $fileAbsolutePath = StringHelper::iconvForWindows($fileAbsolutePath);

        if (!$this -> uploadedFile -> saveAs($fileAbsolutePath))
            throw new NotFoundException('文件上传失败');

        return $this -> path['relativePath'] . $fileName;
    }

    /**
     * 图片水印
     * @param string $fullPathName 文件绝对路径
     * @return bool 
     */
    protected function watermark($fullPathName)
    {
        if (!($this -> config['watermark']['status'])) return true;

        // 水印位置
        $local = $this -> config['watermark']['local'];

        // 水印图片
        $watermarkImg = FileHelper::getLocalFilePath($this -> config['watermark']['img']);

        if ($coordinate = DebrisHelper::getWatermarkLocation($fullPathName, $watermarkImg, $local)) {

            Image::watermark($fullPathName, $watermarkImg, $coordinate) -> save($fullPathName, ['quality' => 100]);

        }

        return true;
    }

    /**
     * 图片压缩
     * @Author OceanicKang 2018-12-30
     * @param  string      $fullPathName 文件绝对路径
     * @return bool
     */
    protected function compress($fullPathName)
    {
        if (true != $this -> config['compress']) return false;

        $imgInfo = getimagesize($fullPathName);

        $compressibility = $this -> config['compressibility'];

        $tmpMinSize = 0;

        foreach ($compressibility as $key => $item) {

            if ($this -> fileBaseInfo['size'] <= $tmpMinSize && $this -> fileBaseInfo['size'] < $key && $item < 100) {

                Image::thumbnail($fullPathName, $imgInfo[0], $imgInfo[1]) -> save($fullPathName, ['quality' => $item]);

            }

            $tmpMinSize = $key;

        }

        return true;
    }

    /**
     * 创建缩略图
     * @Author OceanicKang 2018-12-30
     * @param  string      $fullPathName 文件绝对路径
     * @return bool                    
     */
    protected function thumb($fullPathName)
    {
        if (empty($this -> config['thumb']['size'])) return true;

        $fileName = $this -> fileName . '.' . $this -> fileBaseInfo['extension'];

        foreach ($this -> config['thumb']['size'] as $item) {

            $value = explode('*', $item); // 长*宽

            if (!$value[0] || !$value[1]) continue;

            $thumbPath = $this -> paths['thumbAbsolutePath'] . $fileName;

            $thumbPath = StringHelper::createThumbUrl($thumbPath, $value[0], $value[1]);

            // 裁剪：从坐标 [0, 60]，裁剪一张 300*20 的图片，不设置坐标则从 [0, 0] 开始
            // Image::crop($path, 300, 20, [0, 60]) -> save($path, ['quality' => 100]);
            Image::thumbnail($fullPathName, $value[0], $value[1]) -> save($thumbPath);

        }

        return true;
    }

    /**
     * 生成配置并过滤数据
     * @Author OceanicKang 2018-12-30
     * @param  array       $config
     * @param  string      $type
     */
    protected function filter($config, $type)
    {
        $configs = Yii::$app -> config -> getAll();
        
        switch ($type) {
            // 图片配置
            case 'images':

                $compress_rules = explode(',', $configs['UPLOAD_IMAGES_COMPRESS_RULES']);

                foreach ($compress_rules as $key => $value) {

                    if ($value) {

                        $compress_rules[$key] = explode('=>', $value);

                        $compress_rules[$key][0] = array_product(explode('*', $compress_rules[$key][0]));

                        $compress_rules[$compress_rules[$key][0]] = $compress_rules[$key][1];

                    }

                    if (empty($compress_rules[$key][0]) || empty($compress_rules[$key][1])) unset($compress_rules[$compress_rules[$key][0]]);

                    unset($compress_rules[$key]);

                }

                $_config = [
                    'originalName'    => (bool)$configs['UPLOAD_IMAGES_ORIGIN_NAME'],        // 是否保留原名
                    'fullPath'        => (bool)$configs['UPLOAD_IMAGES_FULL_PATH'],          // 是否返回完整路径
                    'takeOverAction'  => $configs['UPLOAD_IMAGES_ACTION'],                   // 上传方法
                    'maxSize'         => $configs['UPLOAD_IMAGES_MAX_SIZE'] * 1024 * 1024,   // 字节
                    'extensions'      => explode(',', $configs['UPLOAD_IMAGES_EXTENSIONS']), // 扩展名
                    'path'            => $configs['UPLOAD_IMAGES_MAIN_PATH'],                // 主目录
                    'subName'         => $configs['UPLOAD_IMAGES_SUB_PATH'],                 // 子目录
                    'prefix'          => $configs['UPLOAD_IMAGES_PREFIX'],                   // 前缀
                    'compress'        => (bool)$configs['UPLOAD_IMAGES_COMPRESS'],           // 是否开启压缩
                    'compressibility' => $compress_rules                                     // 压缩规则
                    'thumb'           => [
                        'path'        => $configs['UPLOAD_IMAGES_THUMB_PATH'],                  // 缩略图主目录
                        'size'        => explode('|', $configs['UPLOAD_IMAGES_THUMB_SIZE'])     // 多张缩略图尺寸
                    ],
                    'watermark'       => [
                        'status'      => (bool)$configs['UPLOAD_IMAGES_WATERMARK'],          // 是否开启水印
                        'local'       => $configs['UPLOAD_IMAGES_WATERMARK_LOCAL'],          // 水印位置
                        'img'         => $configs['UPLOAD_IMAGES_WATERMARK_IMG']             // 水印图片
                    ]
                ];

                break;
            // 视频配置
            case 'videos': break;
            // 语音配置
            case 'voices': break;
            // 文件配置
            case 'files': break;
            // 默认
            default: throw new NotFoundHttpException('上传配置错误，请联系管理员'); break;

        }

        try {

            // 解密 json
            foreach ($config as $key => &$item) {

                if (!empty($item) && !is_numeric($item) && !is_array($item))

                    !empty(json_decode($item)) && $item = json_decode($item, true);

            }

            $this -> config = ArrayHelper::merge($_config, $config);

        } catch (\Exception $e) {

            $this -> config = $_config;

        }

        !empty($this -> config['takeOverAction']) && $this -> takeOverAction = $this -> config['takeOverAction'];
    }

}