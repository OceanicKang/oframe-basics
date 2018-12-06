<?php
namespace oframe\basics\backend\modules\sys\controllers;

use Yii;
use oframe\basics\common\helpers\SystemHelper;
use oframe\basics\common\components\ServerInfo;
use oframe\basics\common\helpers\AjaxHelper;

class SystemController extends \backend\controllers\BController
{
    private $server;

    public function init()
    {
        $this -> server = new ServerInfo;

        return parent::init();
    }

    // 系统信息 =====================================
    
    public function actionInfo()
    {
        $db = Yii::$app -> db;

        $models = $db -> createCommand('SHOW TABLE STATUS') -> queryAll();

        $models = array_map('array_change_key_case', $models);

        // 数据库大小
        $mysql_size = 0;
        foreach ($models as $model) $mysql_size += $model['data_length'];

        // 禁用函数
        $disable_functions = ini_get('disable_functions');

        $disable_functions = $disable_functions ?: '未禁用';

        $disable_functions = explode(',', $disable_functions);

        // 附件大小
        $attachment_size = SystemHelper::getDirSize(Yii::getAlias('@attachment'));

        return $this -> render('info', [
            'mysql_size' => $mysql_size,
            'attachment_size' => $attachment_size,
            'disable_functions' => $disable_functions
        ]);
    }

    // 服务器信息 ===================================
    
    public function actionServer()
    {
        $server = $this -> server;

        $time_speed = 3;

        if (!Yii::$app -> request -> isAjax) {

            $data['uptime'] = $server -> getUptime(); // 运行时长

            $data['cpu_info'] = $server -> getCpu(); // cpu 信息

            $data['hard_disk'] = $server -> getHardDisk(); // 硬盘使用

            // 网络情况 横坐标
            $data['time_x'] = [];

            for ($i = 20; $i > 0; $i--) $data['time_x'][] = time() - $i * $time_speed;
        }

        $data['loadavg'] = $server -> getLoadavg(); // 负载状态

        $data['free_time_rate'] = $server -> getFreeTimeRate(); // 系统空闲率

        $data['cpu_use'] = $server -> getCpuUse(); // cpu 使用

        $data['memory'] = $server -> getMemory(); // 内存信息

        $data['network'] = $server -> getNetwork(); // 网络情况

        $data['time'] = time(); // 记录时间

        // 计算 cpu 使用率 + 计算网络速度 + 图表时间轴
        $oldServerInfo = Yii::$app -> cache -> get('server:info');

        if (!empty($oldServerInfo) && PHP_OS == 'Linux') {

            // cpu 使用率
            $user_pass = $data['cpu_use']['cpu']['user'] - $oldServerInfo['cpu_use']['cpu']['user'];

            $system_pass = $data['cpu_use']['cpu']['system'] - $oldServerInfo['cpu_use']['cpu']['system'];

            $idle_pass = $data['cpu_use']['cpu']['idle'] - $oldServerInfo['cpu_use']['cpu']['idle'];

            $data['cpu_use_rate'] = round(($user_pass + $system_pass) * 100 / ($user_pass + $system_pass + $idle_pass), 2);

            // 网络速度
            $time = time() - $oldServerInfo['time'];

            empty($time) && $time = 1;

            $data['network']['all_in_speed'] = round(($data['network']['all_receive'] - $oldServerInfo['network']['all_receive']) / $time, 2);

            $data['network']['all_out_speed'] = round(($data['network']['all_transmit'] - $oldServerInfo['network']['all_transmit']) / $time, 2);

            // x 轴
            $data['time_x'] = $oldServerInfo['time_x'];

            array_push($data['time_x'], end($data['time_x']) + $time_speed);

            array_shift($data['time_x']);

        }

        Yii::$app -> cache -> set('server:info', $data, 10);

        $data['network']['all_in_speed'] = round($data['network']['all_in_speed'] / 1024, 2);

        $data['network']['all_out_speed'] = round($data['network']['all_out_speed'] / 1024, 2);

        $data['network']['all_receive'] = str_replace('i', '',
                                            str_replace(',', '.',
                                                Yii::$app -> formatter -> asShortSize($data['network']['all_receive'], 2)));

        $data['network']['all_transmit'] = str_replace('i', '',
                                            str_replace(',', '.',
                                                Yii::$app -> formatter -> asShortSize($data['network']['all_transmit'], 2)));

        $data['time_x'] = array_map(function ($time) {
                              return date('H:i:s', $time);
                          }, $data['time_x']);

        if (Yii::$app -> request -> isAjax) return AjaxHelper::formatData(200, '', $data);

        return $this -> render('server', [
            'environment' => $server -> getEnvironment(),
            'data' => $data
        ]);
    }

}
