<?php
namespace oframe\basics\backend\components;

use oframe\basics\backend\components\server\ServerInfoLinux;
use oframe\basics\backend\components\server\ServerInfoWindows;

/**
 * Class ServerHelper
 * @package oframe\basics\common\components\server
 */
class ServerInfo
{
    /**
     * 系统类
     */
    protected $server;

    /**
     * cpu 状态描述
     */
    public static $cpuExplain = [
        'idle'    => 'CPU空闲',
        'user'    => '用户进程',
        'sys'     => '内核进程',
        'iowait'  => '等待I/O',
        'nice'    => '更改优先级',
        'irq'     => '系统中断',
        'softirq' => '软件中断'
    ];

    /**
     * 选择服务器类
     * @Author OceanicKang 2018-12-01
     */
    public function __construct()
    {
        switch (PHP_OS) {
            case 'Linux':
                $this -> server = new ServerInfoLinux(); break;
            case 'WINNT':
                $this -> server = new ServerInfoWindows(); break;
        }
    }

    /**
     * 获取 cpu 信息
     * @Author OceanicKang 2018-12-01
     * @return array [<description>]
     */
    public function getCpu()
    {
        return $this -> server -> getCpu();
    }

    /**
     * 获取 cpu 使用率
     * @Author OceanicKang 2018-12-01
     * @return array [<description>]
     */
    public function getCpuUse()
    {
        return $this -> server -> getCpuUse();
    }

    /**
     * 获取网络情况 字节
     * @Author OceanicKang 2018-12-01
     * @return array [<description>]
     */
    public function getNetwork()
    {
        return $this -> server -> getNetwork();
    }

    /**
     * 获取运行时间 秒
     * @Author OceanicKang 2018-12-01
     * @return string [<description>]
     */
    public function getUptime()
    {
        return $this -> server -> getUptime();
    }

    /**
     * 系统空闲率
     * @Author OceanicKang 2018-12-01
     * @return string [<description>]
     */
    public function getFreeTimeRate()
    {
        return $this -> server -> getFreeTimeRate();
    }

    /**
     * 获取内存情况 KB
     * @Author OceanicKang 2018-12-01
     * @return array [description]
     */
    public function getMemory()
    {
        return $this -> server -> getMemory();
    }

    /**
     * 获取负载情况
     * @Author OceanicKang 2018-12-01
     * @return array [description]
     */
    public function getLoadavg()
    {
        return $this -> server -> getLoadavg();
    }

    /**
     * 获取环境信息
     * @Author OceanicKang 2018-12-01
     * @return array [description]
     */
    public function getEnvironment()
    {
        $environment = [];

        // 服务器域名
        $environment['domain'] = $_SERVER['SERVER_NAME'];

        // 服务器IP地址
        $environment['ip'] = $_SERVER['SERVER_ADDR'] ?: gethostbyname($_SERVER['SERVER_NAME']);

        // 服务端口
        $environment['port'] = $_SERVER['SERVER_PORT'];

        // 服务器版本
        $environment['version'] = php_uname('s') . ' ' . php_uname('r');

        // 服务器操作系统
        $environment['os'] = php_uname();

        // 服务器解析引擎
        $environment['engine'] = $_SERVER['SERVER_SOFTWARE'];

        // 服务器语言
        $environment['language'] = $_SERVER['HTTP_ACCEPT_LANGUAGE'];

        // 运行路径
        $environment['path'] = $_SERVER['DOCUMENT_ROOT'] ?
                               str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']) :
                               str_replace('\\', '/', dirname(__FILE__));

        return $environment;
    }

    /**
     * 获取硬盘情况
     * @Author OceanicKang 2018-12-01
     * total 总量
     * free 空闲
     * used 已用
     * use_rate 使用率
     * @return array 
     */
    public function getHardDisk()
    { 
        $hardDisk['total'] = round(@disk_total_space('.') / (1024 * 1024 * 1024), 2); // 总量 G

        $hardDisk['free'] = round(@disk_free_space('.') / (1024 * 1024 * 1024), 2); // 空闲 G

        $hardDisk['used'] = round($hardDisk['total'] - $hardDisk['free'], 2); // 已用 G

        $hardDisk['used_rate'] = (0 != $hardDisk['total']) ? round($hardDisk['used'] / $hardDisk['total'] * 100, 2) : 0; // 使用率

        return $hardDisk;
    }

    /**
     * 判断是否为 Linux
     * @Author OceanicKang 2018-12-01
     * @return boolean     [description]
     */
    private function isLinux()
    {
        return '/' == DIRECTORY_SEPARATOR ? true : false;
    }

}