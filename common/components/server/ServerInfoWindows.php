<?php
namespace oframe\basics\common\components\server;

/**
 * Class ServerInfoWindows
 * @package oframe\basics\common\components\server
 */
class ServerInfoWindows
{
    /**
     * 获取 cpu 信息
     * @Author OceanicKang 2018-12-01
     * @return array [<description>]
     */
    public function getCpu()
    {
        return '暂无';
    }

    /**
     * 获取 cpu 使用率
     * @Author OceanicKang 2018-12-01
     * @return array [<description>]
     */
    public function getCpuUse()
    {
        return '暂无';
    }

    /**
     * 获取网络情况
     * @Author OceanicKang 2018-12-01
     * @return array [<description>]
     */
    public function getNetwork()
    {
        return '暂无';
    }

    /**
     * 获取运行时间
     * @Author OceanicKang 2018-12-01
     * @return string [<description>]
     */
    public function getUptime()
    {
        return '暂无';
    }

    /**
     * 系统空闲率
     * @Author OceanicKang 2018-12-01
     * @return string [<description>]
     */
    public function getFreeTimeRate()
    {
        return '暂无';
    }

    /**
     * 获取内存情况
     * @Author OceanicKang 2018-12-01
     * @return array [description]
     */
    public function getMemory()
    {
        return '暂无';
    }

    /**
     * 获取负载情况
     * @Author OceanicKang 2018-12-01
     * @return array [description]
     */
    public function getLoadavg()
    {
        return '暂无';
    }
}