<?php
use yii\helpers\Url;
use yii\helpers\Html;
use backend\assets\AppAsset;

AppAsset::addECharts($this);

$this -> title = '服务器信息';
$this -> params['breadcrumbs'][] = ['label' => '系统管理', 'url' => ['main/setting']];
$this -> params['breadcrumbs'][] = ['label' => $this -> title];
?>

<div class="layui-row layui-col-space15">

    <div class="layui-col-md12">

        <div class="layui-card">

            <div class="layui-card-header">
                <i class="zmdi zmdi-label zmdi-hc-fw"></i> 基本参数
            </div>

            <div class="layui-card-body">

                <table class="layui-table">
                    <tbody>

                        <tr>
                            <td>服务器域名</td>
                            <td><?php echo $environment['domain'] ?> - <?php echo $environment['ip'] ?></td>
                            <td>服务端口</td>
                            <td><?php echo $environment['port'] ?></td>
                        </tr>

                        <tr>
                            <td>服务器版本</td>
                            <td><?php echo $environment['version'] ?></td>
                            <td>服务器运行时长</td>
                            <td><?php echo $data['uptime'] ?></td>
                            
                        </tr>

                        <tr>
                            <td>操作系统</td>
                            <td><?php echo $environment['os'] ?></td>
                        </tr>

                        <tr>
                            <td>解析引擎</td>
                            <td><?php echo $environment['engine'] ?></td>
                            <td>站点路径</td>
                            <td><?php echo $environment['path'] ?></td>
                        </tr>

                        <tr>
                            <td>系统语言</td>
                            <td><?php echo $environment['language'] ?></td>
                            <td>当前时间</td>
                            <td id="divTime"></td>
                        </tr>

                    </tbody>
                </table>

            </div>
            
        </div>
        
    </div>

    <div class="layui-col-md3">
        <div class="layui-card">

            <div class="layui-card-header"> 实时监控 </div>

            <div class="layui-card-body layadmin-takerates">

                <div class="layui-progress" lay-showpercent="yes">
                    <h3 id="hard_disk_used">（ <?php echo $data['hard_disk']['used'] ?>G / <?php echo $data['hard_disk']['total'] ?>G ）硬盘使用率</h3>
                    <div id="hard_disk_used_rate" class="layui-progress-bar 
                                <?php if ($data['hard_disk']['used_rate'] >= 90) { echo 'layui-bg-red'; }
                                else if ($data['hard_disk']['used_rate'] >= 50) { echo 'layui-bg-orange'; } ?>"
                         lay-percent="<?php echo $data['hard_disk']['used_rate'] ?>%"
                         style="width: <?php echo $data['hard_disk']['used_rate'] ?>%;">
                        <span class="layui-progress-text"><?php echo $data['hard_disk']['used_rate'] ?>%</span>
                    </div>
                </div>

                <div class="layui-progress" lay-showpercent="yes">
                    <h3 id="memory_used">（ <?php echo round($data['memory']['used'] / 1024, 0); ?>MB / <?php echo round($data['memory']['total'] / 1024, 0); ?>MB ）内存使用率</h3>
                    <div id="memory_used_rate" class="layui-progress-bar 
                                <?php if ($data['memory']['used_rate'] >= 90) { echo 'layui-bg-red'; }
                                else if ($data['memory']['used_rate'] >= 50) { echo 'layui-bg-orange'; } ?>"
                         lay-percent="<?php echo $data['memory']['used_rate'] ?>%"
                         style="width: <?php echo $data['memory']['used_rate'] ?>%;">
                        <span class="layui-progress-text"><?php echo $data['memory']['used_rate'] ?>%</span>
                    </div>
                </div>

                <div class="layui-progress" lay-showpercent="yes">
                    <h3>CPU使用率</h3>
                    <div id="cpu_use_rate" class="layui-progress-bar 
                                <?php if ($data['cpu_use_rate'] >= 90) { echo 'layui-bg-red'; }
                                else if ($data['cpu_use_rate'] >= 50) { echo 'layui-bg-orange'; } ?>"
                         lay-percent="<?php echo $data['cpu_use_rate'] ?>%"
                         style="width: <?php echo $data['cpu_use_rate'] ?>%;">
                        <span class="layui-progress-text"><?php echo $data['cpu_use_rate'] ?>%</span>
                    </div>
                </div>

                <div class="layui-progress" lay-showpercent="yes">
                    <h3>系统空闲率</h3>
                    <div id="free_time_rate" class="layui-progress-bar 
                                <?php if ($data['free_time_rate'] <= 10) { echo 'layui-bg-red'; }
                                else if ($data['free_time_rate'] <= 50) { echo 'layui-bg-orange'; } ?>"
                         lay-percent="<?php echo $data['free_time_rate'] ?>%"
                         style="width: <?php echo $data['free_time_rate'] ?>%;">
                        <span class="layui-progress-text"><?php echo $data['free_time_rate'] ?>%</span>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <div class="layui-col-md5">

        <div class="layui-card">

            <div class="layui-card-header"> CPU 信息 </div>

            <div class="layui-card-body">

                <table class="layui-table">
                    <tbody>

                        <?php foreach ($data['cpu_info'] as $key =>  $value): ?>
                            <tr>
                                <td>CPU<?php echo $key; ?></td>
                                <td><?php echo
                                            $value['model'] . '<br>' .
                                            '频率:' . $value['mhz'] . ' MHz | ' .
                                            '二级缓存:' . $value['cache'] . ' | ' .
                                            'Bogomips:' . $value['bogomips'];
                                    ?>
                                                    
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>

            </div>
            
        </div>
        
    </div>

    <div class="layui-col-md4">

        <div class="layui-card">

            <div class="layui-card-header"> 负载情况 </div>

            <div class="layui-card-body">

                <table class="layui-table">
                    <tbody>

                        <tr>
                            <td>平均负载（1分钟 | 5分钟 | 15分钟）</td>
                            <td id="lavg"><?php echo $data['loadavg']['lavg_1'] ?> | <?php echo $data['loadavg']['lavg_5'] ?> | <?php echo $data['loadavg']['lavg_15'] ?></td>
                        </tr>

                        <tr>
                            <td>正在运行的进程数 / 进程总数</td>
                            <td id="nr_running"><?php echo $data['loadavg']['nr_running'] ?> / <?php echo $data['loadavg']['nr_threads'] ?></td>
                        </tr>

                        <tr>
                            <td>最近运行的进程 ID</td>
                            <td id="last_pid"><?php echo $data['loadavg']['last_pid'] ?></td>
                        </tr>

                    </tbody>
                </table>

            </div>
            
        </div>
        
    </div>

    <div class="layui-col-md12">

        <div class="layui-card">

            <div class="layui-card-header"> 网络流量 </div>

            <div class="layui-card-body">

                <table class="layui-table">
                    <tbody>

                        <table class="layui-table">
                            <tbody>

                                <tr>
                                    <td>下行速度</td>
                                    <td id="all_in_speed"><?php echo $data['network']['all_in_speed']; ?> KB / S</td>
                                    <td>上行速度</td>
                                    <td id="all_out_speed"><?php echo $data['network']['all_out_speed']; ?> KB / S</td>
                                </tr>

                                <tr>
                                    <td>总接收</td>
                                    <td id="all_receive"><?php echo $data['network']['all_receive']; ?></td>
                                    <td>总发送</td>
                                    <td id="all_transmit"><?php echo $data['network']['all_transmit']; ?></td>
                                </tr>

                            </tbody>
                        </table>

                    </tbody>
                </table>


                <div id="NetWork" class="layui-carousel layadmin-carousel layadmin-dataview" style="margin: 15px 10px;">
                    <div><i class="layui-icon layui-icon-loading1 layadmin-loading"></i></div>
                </div>


            </div>
            
        </div>
        
    </div>

</div>

<script type="text/javascript">

    function setTime() {
        var d = new Date(), str = '';
        str += d.getFullYear() + ' 年 '; // 获取当前年份
        str += d.getMonth() + 1 + ' 月 '; // 获取当前月份（0——11）
        str += d.getDate() + ' 日  ';
        str += d.getHours() + ' 时 ';
        str += d.getMinutes() + ' 分 ';
        str += d.getSeconds() + ' 秒 ';
        $("#divTime").text(str);
    }

    $(document).ready(function() {
        setTime();
        setInterval(setTime, 1000);
        setInterval(getServerInfo, 3000);
    });

</script>

<script type="text/javascript">

    var time_x = [0, '<?php echo $data['time'] ?>'];

    var all_in_speed = [0, '<?php echo $data['network']['all_in_speed'] ?>'];

    var all_out_speed = [0, '<?php echo $data['network']['all_out_speed'] ?>'];

    var dom = document.getElementById("NetWork");

    var myChart = echarts.init(dom, 'light');

    function NetWorkOption() {

        var option = {
                title: {
                    text: '单位 KB/S',
                    textStyle: {
                        fontWeight: 'normal',
                        fontSize: '15'
                    }
                },
                tooltip : {
                    trigger: 'axis',
                    axisPointer: {
                        type: 'cross',
                        label: {
                            backgroundColor: '#6a7985'
                        }
                    }
                },
                legend: {
                    data:['下行速度', '上行速度']
                },
                toolbox: {
                    show: false
                },
                grid: {
                    top: '12%',
                    left: '1%',
                    right: '2%',
                    bottom: '0%',
                    containLabel: true
                },
                xAxis : [
                    {
                        type : 'category',
                        boundaryGap : false,
                        axisTick: {
                            alignWithLabel: true
                        },
                        data : time_x
                    }
                ],
                yAxis : [
                    {
                        type : 'value'
                    }
                ],
                series : [
                    {
                        name:'下行速度',
                        type:'line',
                        smooth: true,
                        areaStyle: {
                            color: 'rgba(82,169,255, 1)'
                        },
                        data: all_in_speed
                    },
                    {
                        name:'上行速度',
                        type:'line',
                        smooth: true,
                        areaStyle: {
                            color: 'rgba(247,184,81, 0.5)'
                        },
                        data: all_out_speed
                    },
                    
                ]
            };

        return option;

    }

    var option = NetWorkOption();

    if (option && typeof option === "object") {
        myChart.setOption(option, true);
    }
    
</script>

<script type="text/javascript">

    function getServerInfo() {

        $.ajax({
            type: 'get',
            url: '<?php echo Url::to(['server']) ?>',
            dataType: 'json',
            success: function (data) {

                if (200 == data.code) {

                    var classText = '';
                    var data = data.data;

                    // 网络流量
                    $('#all_in_speed').text(data.network.all_in_speed + ' KB / S');
                    $('#all_out_speed').text(data.network.all_out_speed + ' KB / S');
                    $('#all_receive').text(data.network.all_receive);
                    $('#all_transmit').text(data.network.all_transmit);
                    if (time_x.length >= 15 && all_in_speed.length >= 15 && all_out_speed.length >= 15) {
                        time_x.shift(); all_in_speed.shift();all_out_speed.shift();
                    }
                    time_x.push(data.time); all_in_speed.push(data.network.all_in_speed); all_out_speed.push(data.network.all_out_speed);
                    myChart.setOption(NetWorkOption(), true);

                    // 负载情况
                    $('#lavg').text(data.loadavg.lavg_1 + ' | ' + data.loadavg.lavg_5 + ' | ' + data.loadavg.lavg_15);
                    $('#nr_running').text(data.loadavg.nr_running + ' / ' + data.loadavg.nr_threads);
                    $('#last_pid').text(data.loadavg.last_pid);
                    
                    // 硬盘使用率
                    // if (data.hard_disk.used_rate >= 90) { classText = 'layui-bg-red'; }
                    // else if (data.hard_disk.used_rate >= 50) { classText = 'layui-bg-orange'; }
                    // $('#hard_disk_used').text('（ ' + data.hard_disk.used + 'G / ' + data.hard_disk.total + 'G ）硬盘使用率');
                    // $('#hard_disk_used_rate > span').text(data.hard_disk.used_rate + '%');
                    // $('#hard_disk_used_rate').removeClass('layui-bg-red layui-bg-orange')
                    //                          .addClass(classText)
                    //                          .attr('lay-percent', data.hard_disk.used_rate + '%')
                    //                          .attr('style', 'width:' + data.hard_disk.used_rate + '%;');

                    // 内存使用率
                    if (data.memory.used_rate >= 90) { classText = 'layui-bg-red'; }
                    else if (data.memory.used_rate >= 50) { classText = 'layui-bg-orange'; }
                    else classText = '';
                    $('#memory_used').text('（ ' + (data.memory.used / 1024).toFixed(0) + 'MB / ' + (data.memory.total / 1024).toFixed(0) + 'MB ）内存使用率');
                    $('#memory_used_rate > span').text(data.memory.used_rate + '%');
                    $('#memory_used_rate').removeClass('layui-bg-red layui-bg-orange')
                                          .addClass(classText)
                                          .attr('lay-percent', data.memory.used_rate + '%')
                                          .attr('style', 'width:' + data.memory.used_rate + '%;');

                    // CPU 使用率
                    if (data.cpu_use_rate >= 90) { classText = 'layui-bg-red'; }
                    else if (data.cpu_use_rate >= 50) { classText = 'layui-bg-orange'; }
                    else classText = '';
                    $('#cpu_use_rate > span').text(data.cpu_use_rate + '%');
                    $('#cpu_use_rate').removeClass('layui-bg-red layui-bg-orange')
                                      .addClass(classText)
                                      .attr('lay-percent', data.cpu_use_rate + '%')
                                      .attr('style', 'width:' + data.cpu_use_rate + '%;');

                    // 系统空闲率
                    if (data.free_time_rate <= 10) { classText = 'layui-bg-red'; }
                    else if (data.free_time_rate <= 50) { classText = 'layui-bg-orange'; }
                    else classText = '';
                    $('#free_time_rate > span').text(data.free_time_rate + '%');
                    $('#free_time_rate').removeClass('layui-bg-red layui-bg-orange')
                                        .addClass(classText)
                                        .attr('lay-percent', data.free_time_rate + '%')
                                        .attr('style', 'width:' + data.free_time_rate + '%;');

                }

            }
        });

    }

</script>
