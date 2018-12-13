<?php
namespace oframe\basics\common\helpers;

use Yii;
use yii\imagine\Image;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use oframe\basics\common\helpers\SystemHelper;

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

    public static $prefixForMergeCache = 'upload:file:guid:';

    /**
     * 初始化
     * @Author OceanicKang 2018-12-17
     * @param  array       $config    post数据，可直接传入 Yii::$app -> request -> post()
     * @param  string      $type      上传类型
     */
    public function __construct(array $config, $type)
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
                    'originalName'    => (bool)$configs['UPLOAD_IMAGES_ORIGIN_NAME'],        // 原名
                    'fullPath'        => (bool)$configs['UPLOAD_IMAGES_FULL_PATH'],          // 完整路径
                    'takeOverAction'  => $configs['UPLOAD_IMAGES_ACTION'],                   // 上传方法
                    'maxSize'         => $configs['UPLOAD_IMAGES_MAX_SIZE'] * 1024 * 1024,   // 字节
                    'extensions'      => explode(',', $configs['UPLOAD_IMAGES_EXTENSIONS']), // 扩展名
                    'path'            => $configs['UPLOAD_IMAGES_MAIN_PATH'],                // 主目录
                    'subName'         => $configs['UPLOAD_IMAGES_SUB_PATH'],                 // 子目录
                    'prefix'          => $configs['UPLOAD_IMAGES_PREFIX'],                   // 前缀
                    'compress'        => (bool)$configs['UPLOAD_IMAGES_COMPRESS'],           // 压缩
                    'compressibility' => $compress_rules                                     // 压缩规则
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

        // 解密 json
        foreach ($config as &$item) {

            if (!empty($item) && !is_numeric($item) && !is_array($item))

                !empty(json_decode($item)) && $item = json_decode($item, true);

        }

        $this -> config = ArrayHelper::merge($_config, $config);

        !empty($this -> config['takeOverAction']) && $this -> takeOverAction = $this -> config['takeOverAction'];

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


    public function verifyRemote($imgUrl)
    {
        $imgUrl = str_replace('&amp;', '&', htmlspecialchars($imgUrl));

        // http 开头验证
        if (0 !== strpos($imgUrl, 'http'))
            throw new NotFoundHttpException('请输入以http/https开头的URL地址');

        preg_match('/(^https?:\/\/[^:\/]+)/', $imgUrl, $matches);
        // 带协议的 host
        $host_with_protocol = count($matches) > 1 ? $matches[1] : '';

        // 判断是否为合法 URL
        if (!filter_var($host_with_protocol, FILTER_VALIDATE_URL))
            throw new NotFoundHttpException('URL 不合法');

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
        $extend = SystemHelper::getFileTypeToEN($imgUrl);
        if (!empty($this -> config['extensions']) && !in_array($extend, $this -> config['extensions']))
            throw new NotFoundHttpException('文件类型不允许');

        // 打开输出缓冲区，并获取远程图片


    }

}