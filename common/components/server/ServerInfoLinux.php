<?php
namespace oframe\basics\common\components\server;

/**
 * Class ServerInfoLinux
 * @package oframe\basics\common\components\server
 */
class ServerInfoLinux
{
    /**
     * 获取 cpu 信息
     * @Author OceanicKang 2018-12-01
     * @return array [<description>]
     */
    public function getCpu()
    {
        $info = [];

        // 获取 cpu 名称 && 获取 cpu 频率 && 获取 cpu 缓存 && bogomips
        exec('cat /proc/cpuinfo | grep "model name" &&
              cat /proc/cpuinfo | grep "cpu MHz" &&
              cat /proc/cpuinfo | grep "cache size" &&
              cat /proc/cpuinfo | grep "bogomips"', $data);

        foreach ($data as $key => $value) {

            $data[$key] = explode(':', $data[$key]);

            $txt = trim($data[$key][0]);

            if ('model name' == $txt) $data['model'][] = trim($data[$key][1]);

            else if ('cpu MHz' == $txt) $data['mhz'][] = trim($data[$key][1]);

            else if ('cache size' == $txt) $data['cache'][] = trim($data[$key][1]);

            else if ('bogomips' == $txt) $data['bogomips'][] = trim($data[$key][1]);

            foreach ($data['model'] as $key => $model) {

                $info[$key] = [

                    'model'    => $model,

                    'mhz'      => $data['mhz'][$key],

                    'cache'    => $data['cache'][$key],

                    'bogomips' => $data['bogomips'][$key]

                ];

            }

            unset($data[$key]);
        }

        unset($data);

        return $info;
    }

    /**
     * 获取 cpu 使用率
     * @Author OceanicKang 2018-12-01
     * @return array [<description>]
     */
    public function getCpuUse()
    {
        $data = file('/proc/stat'); // 获取 cpu 运行数据

        foreach ($data as $line) {

            if(stripos($line, 'cpu') === 0) {

                $info = explode(' ', $line);

                if (!$info[1]) array_splice($info, 1, 1);

                $cores[$info[0]] = [
                    'user'    => $info[1],     // 从系统启动开始累计到当前时刻，处于用户态的运行时间，不包含 nice值为负的进程
                    'nice'    => $info[2],     // 从系统启动开始累计到当前时刻，nice值为负的进程所占用的CPU时间
                    'system'  => $info[3],     // 从系统启动开始累计到当前时刻，处于核心态的运行时间
                    'idle'    => $info[4],     // 从系统启动开始累计到当前时刻，除IO等待时间以外的其它等待时间
                    'iowait'  => $info[5],     // 从系统启动开始累计到当前时刻，IO等待时间
                    'irq'     => $info[6],     // 从系统启动开始累计到当前时刻，硬中断时间
                    'softirq' => $info[7],     // 从系统启动开始累计到当前时刻，软中断时间
                    'stealstolen' => $info[8], //这是在虚拟环境中运行时在其他操作系统中花费的时间
                    'guest'   => $info[9],     // 这是在Linux内核的控制下为访客操作系统运行虚拟CPU所花费的时间
                ];

            }

        }

        unset($data);

        return $cores;
    }

    /**
     * 获取网络情况 字节
     * @Author OceanicKang 2018-12-01
     * @return array [<description>]
     */
    public function getNetwork()
    {
        $data = file('/proc/net/dev');

        $info['all_receive'] = 0; // 接收量

        $info['all_transmit'] = 0;  // 传送量
        
        for ($i = 2; $i < count($data); $i++) {

            $data[$i] = preg_split("/[:,\s]+/", trim($data[$i]));

            $info['part'][$data[$i][0]] = [

                'receive' => $data[$i][1],

                'transmit' => $data[$i][9],

            ];

            $info['all_receive'] += $data[$i][1];

            $info['all_transmit'] += $data[$i][9];

        }

        unset($data);

        return $info;
    }

    /**
     * 获取运行时间
     * @Author OceanicKang 2018-12-01
     * @return string [<description>]
     */
    public function getUptime()
    {
        $info = '获取失败';

        if ($uptime = file('/proc/uptime')) {

            $uptime = explode(' ', implode('', $uptime));

            $sec = trim($uptime[0]); // 秒

            $days = floor($sec / 60 / 60 / 24); // 天

            $hours = floor(($sec / 60 / 60) - ($days * 24)); // 小时

            $min = floor(($sec / 60) - ($days * 24 * 60) - ($hours * 60));

            $info = $days . ' 天 ' . $hours . ' 小时 ' . $min . ' 分钟 ';

        }

        unset($uptime);

        return $info;
    }

    /**
     * 系统空闲率
     * @Author OceanicKang 2018-12-01
     * @return string [<description>]
     */
    public function getFreeTimeRate()
    {
        $info = 0;

        $cpu_num = substr_count(implode('', file('/proc/cpuinfo')), 'processor');

        if (($uptime = file('/proc/uptime')) && $cpu_num) {
            
            $str = explode(' ', implode('', $uptime));

            $run_time = $str[0];

            $free_time = $str[1];

            $info = round($free_time / ($run_time * $cpu_num) * 100, 2);

        }

        unset($uptime);

        unset($cpu_num);

        return $info;
    }

    /**
     * 获取内存情况 KB
     * @Author OceanicKang 2018-12-01
     * @return array [description]
     */
    public function getMemory()
    {
        $info = [];

        exec('free -k | sed -n \'2p\'', $mem); // 内存总量

        $mem = array_values(array_filter(explode(' ', $mem[0])));

        $info = [
            'total' => $mem[1],
            'used' => $mem[2],
            'used_rate' => round($mem[2] * 100 / $mem[1], 2)
        ];

        unset($mem);

        return $info;
    }

    /**
     * 获取负载情况
     * @Author OceanicKang 2018-12-01
     * @return array [description]
     */
    public function getLoadavg()
    {
        $info = [];

        if ($loadavg = file('/proc/loadavg')) {

            $loadavg[0] = str_replace('/', ' ', $loadavg[0]);

            $loadavg = explode(' ', implode('', $loadavg));

            $info = [

                'lavg_1'     => $loadavg[0], // 1 分钟平均进程数

                'lavg_5'     => $loadavg[1], // 5 分钟平均进程数

                'lavg_15'    => $loadavg[2], // 15 分钟平均进程数

                'nr_running' => $loadavg[3], // 正在运行的进程数

                'nr_threads' => $loadavg[4], // 进程总数

                'last_pid'   => $loadavg[5], // 最近运行的进程 ID

            ];

        }

        unset($loadavg);

        return $info;
    }

}