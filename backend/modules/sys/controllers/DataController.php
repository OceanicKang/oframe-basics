<?php
namespace oframe\basics\backend\modules\sys\controllers;

use Yii;
use oframe\basics\common\helpers\MySQLHelper;
use oframe\basics\common\helpers\SysArrayHelper;
use oframe\basics\common\helpers\AjaxHelper;
use oframe\basics\common\helpers\SystemHelper;

class DataController extends \backend\controllers\BController
{
    private $sql; // MySQLHelper

    private $code = AjaxHelper::AJAX_UNKNOW; // ajax 状态

    private $message; // ajax 提示

    // 初始化
    public function init()
    {
        $sql = new MySQLHelper;

        $sql -> setDbname();

        $this -> sql = $sql;

        $this -> message = AjaxHelper::$behavior[$this -> code];

        return parent::init();
    }

    /**
     * 数据管理
     *
     * @return string [<description>]
     */
    public function actionIndex()
    {
        // 数据表
        $models = Yii::$app -> db -> createCommand('SHOW TABLE STATUS') -> queryAll();

        $models = array_map('array_change_key_case', $models);

        return $this -> render('index', [
            'models' => $models,
            'files' => $list
        ]);
    }

    /**
     * 备份文件
     *
     * @return string 
     */
    public function actionBackupFiles()
    {
        // 备份文件
        $path = $this -> sql -> config['path'];

        $fileArr = $this -> myScandir($path);

        $list = [];

        foreach ($fileArr as $key => $value) {

            if ($key > 1) {

                // 获取文件创建时间
                $fileTime = filemtime($path . $value);

                // 获取文件大小
                $fileSize = filesize($path . $value);

                // 获取文件类型
                $fileType = SystemHelper::getFileType($value);

                // 构建数组
                $list[] = [

                    'name' => $value,

                    'time' => $fileTime,

                    'type' => $fileType,

                    'size' => $fileSize

                ];

            }

        }

        $list = SysArrayHelper::sort($list, 'time', 'desc');

        return $this -> render('backup-files', [
            'files' => $list
        ]);
    }

    /**
     * 优化表
     *
     * @return string 
     */
    public function actionOptimize($table = '')
    {
        try {

            $this -> sql -> optimize($table);

            $this -> code = AjaxHelper::AJAX_SUCCESS;

            $this -> message = $table ? ( is_array($table) ? '数据表优化成功' : "数据表 `{$table}` 优化成功" ) : '优化成功';

        } catch (\Exception $e) {

            $this -> message = $e -> getMessage();

        }

        $response = Yii::$app -> response;

        $response -> data = AjaxHelper::formatData($this -> code, $this -> message);

        $response -> send();
    }

    /**
     * 修复表
     */
    public function actionRepair($table = '')
    {
        try {

            $this -> sql -> repair($table);

            $this -> code = AjaxHelper::AJAX_SUCCESS;

            $this -> message = $table ? ( is_array($table) ? '数据表修复成功' : "数据表 `{$table}` 修复成功" ) : '修复成功';

        } catch (\Exception $e) {

            $this -> message = $e -> getMessage();

        }

        $response = Yii::$app -> response;

        $response -> data = AjaxHelper::formatData($this -> code, $this -> message);

        $response -> send();

    }

    /**
     * 备份数据库
     */
    public function actionBackup()
    {

        try {

            $this -> sql -> backup();

            $this -> code = AjaxHelper::AJAX_SUCCESS;

            $this -> message = '备份成功';

        } catch (\Exception $e) {

            $this -> message = $e -> getMessage();

        }

        $response = Yii::$app -> response;

        $response -> data = AjaxHelper::formatData($this -> code, $this -> message);

        $response -> send();

    }

    /**
     * 删除备份文件
     */
    public function actionDelete($fileName)
    {

        $result = unlink($this -> sql -> config['path'] . $fileName);

        return $result ?
                $this -> message('删除成功', $this -> redirect(['backup-files'])) :
                $this -> message('删除失败', $this -> redirect(['backup-files']), 'error');

    }

    /**
     * 还原数据库
     */
    public function actionRecover($fileName)
    {

        try {

            $this -> sql -> recover($fileName);

        } catch (\Exception $e) {

            return $this -> message($e -> getMessage(), $this -> redirect(['backup-files']), 'error');

        }

        return $this -> message('还原成功', $this -> redirect(['index']));

    }

    /**
     * 下载
     */
    public function actionDownload($fileName)
    {

        $this -> download($this -> sql -> config['path'] . $fileName);

    }

    /**
     * 获取备份目录下的文件路径
     *
     * @return array 
     */
    private function myScandir($filePath = './', $order = 0)
    {
        $filePath = opendir($filePath);

        while ($fileName = readdir($filePath)) {

            $fileArr[] = $fileName;

        }

        0 == $order ? sort($fileArr) : rsort($fileArr);

        return $fileArr;
    }
}