<?php
use yii\helpers\Url;

$this -> title = '系统信息';
$this -> params['breadcrumbs'][] = ['label' => '系统管理', 'url' => ['main/setting']];
$this -> params['breadcrumbs'][] = ['label' => $this -> title];
?>

<div class="layui-row layui-col-space15">

    <div class="layui-col-md4">

        <div class="layui-card">

            <div class="layui-card-header">
                <i class="zmdi zmdi-code zmdi-hc-fw"></i> 系统
            </div>

            <div class="layui-card-body layui-text">

                <table class="layui-table">
                    <tbody>
                        <tr>
                            <td>系统名称</td>
                            <td><?php echo Yii::$app -> params['Author_Info']['system_name'] ?></td>
                        </tr>
                        <tr>
                            <td>系统版本</td>
                            <td><?php echo Yii::$app -> params['Author_Info']['system_version'] ?></td>
                        </tr>
                        <tr>
                            <td>Yii版本</td>
                            <td>V <?php echo Yii::getVersion(); ?></td>
                        </tr>
                        <tr>
                            <td>Layui版本</td>
                            <td> <script type="text/html" template=""> V {{ layui.v }} </script> </td>
                        </tr>
                        <tr>
                            <td>作者</td>
                            <td><?php echo Yii::$app -> params['Author_Info']['author_name']; ?></td>
                        </tr>
                        <tr>
                            <td>博客</td>
                            <td>
                                <a href="//<?php echo Yii::$app -> params['Author_Info']['home_url']; ?>" target="_black"><?php echo Yii::$app -> params['Author_Info']['home_url']; ?></a>
                            </td>
                        </tr>
                        <tr>
                            <td>文档</td>
                            <td>
                                <a href="//<?php echo Yii::$app -> params['Author_Info']['docs_url']; ?>" target="_black"><?php echo Yii::$app -> params['Author_Info']['docs_url']; ?></a>
                            </td>
                        </tr>
                        <tr>
                            <td>Gitee</td>
                            <td>
                                <a href="//<?php echo Yii::$app -> params['Author_Info']['gitee_url'] ?>" target="_black"><?php echo Yii::$app -> params['Author_Info']['gitee_url'] ?></a>
                            </td>
                        </tr>
                        <tr>
                            <td>GitHub</td>
                            <td>
                                <a href="//<?php echo Yii::$app -> params['Author_Info']['github_url'] ?>" target="_black"><?php echo Yii::$app -> params['Author_Info']['github_url'] ?></a>
                            </td>
                        </tr>
                        <tr>
                            <td>官方QQ群</td>
                            <td>
                                <a href="//<?php echo Yii::$app -> params['Author_Info']['qq_group']['url'] ?>" target="_blank"><?php echo Yii::$app -> params['Author_Info']['qq_group']['name'] ?></a>
                            </td>
                        </tr>

                    </tbody>
                </table>
                
            </div>
            
        </div>
        
    </div>

    <div class="layui-col-md8">

        <div class="layui-card">

            <div class="layui-card-header">
                <i class="zmdi zmdi-flag zmdi-hc-fw"></i> 环境
            </div>

            <div class="layui-card-body">

                <table class="layui-table">
                    <tbody>
                        <tr>
                            <td>PHP版本</td>
                            <td style="width: 85%;"><?php echo phpversion(); ?></td>
                        </tr>
                        <tr>
                            <td>MySQL版本</td>
                            <td><?php echo Yii::$app -> db -> pdo -> getAttribute(\PDO::ATTR_SERVER_VERSION); ?></td>
                        </tr>
                        <tr>
                            <td>解析引擎</td>
                            <td><?php echo $_SERVER['SERVER_SOFTWARE']; ?></td>
                        </tr>
                        <tr>
                            <td>数据库大小</td>
                            <td><?php echo Yii::$app -> formatter -> asShortSize($mysql_size); ?></td>
                        </tr>
                        <tr>
                            <td>附件目录</td>
                            <td><?php echo Yii::$app -> request -> hostInfo . Yii::getAlias('@attachurl'); ?></td>
                        </tr>
                        <tr>
                            <td>附件总量</td>
                            <td><?php echo Yii::$app -> formatter -> asShortSize($attachment_size); ?></td>
                        </tr>
                        <tr>
                            <td>文件上传限制</td>
                            <td>
                                服务器限制：<?php echo ini_get('upload_max_filesize') ?> <br>
                                系统限制：<?php echo Yii::$app -> config -> get('WEB_MAX_FILE_SIZE'); ?>KB（0表示不限制）<br>
                                最多同时能上传 <?php echo ini_get('max_file_uploads') ?> 份
                            </td>
                        </tr>
                        <tr>
                            <td>超时时间</td>
                            <td><?php echo ini_get('max_execution_time'); ?> 秒</td>
                        </tr>
                        <tr>
                            <td>客户端信息</td>
                            <td><?php echo $_SERVER['HTTP_USER_AGENT']; ?></td>
                        </tr>
                    </tbody>
                </table>
                

            </div>
            
        </div>
        
    </div>

    <div class="layui-col-md12">

        <div class="layui-card">

            <div class="layui-card-header">
                <i class="zmdi zmdi-label zmdi-hc-fw"></i> PHP 信息
            </div>

            <div class="layui-card-body">

                <table class="layui-table">
                    <tbody>
                        <tr>
                            <td>运行模式</td>
                            <td><?php echo php_sapi_name(); ?></td>
                        </tr>
                        <tr>
                            <td>启用扩展</td>
                            <td>
                                <?php foreach (Yii::$app -> params['extension_loaded'] as $extend): ?>

                                <span class="layui-badge <?php echo extension_loaded($extend) ? 'layui-bg-blue' : 'layui-bg-gray' ?>"><?php echo $extend; ?></span>

                                <?php endforeach; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>禁用函数</td>
                            <td>
                                <?php if ($disable_functions): ?>
                                <?php foreach ($disable_functions as $function): ?>

                                    <span class="layui-badge layui-bg-gray"><?php echo $function; ?></span>

                                <?php endforeach; ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>脚本内存限制</td>
                            <td><?php echo ini_get('memory_limit'); ?></td>
                        </tr>
                        <tr>
                            <td>Socket超时时间</td>
                            <td><?php echo ini_get('default_socket_timeout'); ?> 秒</td>
                        </tr>
                        <tr>
                            <td>POST最大数据量</td>
                            <td><?php echo ini_get('post_max_size'); ?></td>
                        </tr>

                    </tbody>
                </table>

            </div>
            
        </div>
        
    </div>


</div>