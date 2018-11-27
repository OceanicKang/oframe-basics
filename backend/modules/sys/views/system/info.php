<?php
use yii\helpers\Url;

$this -> title = '系统信息';
$this -> params['breadcrumbs'][] = ['label' => '系统管理', 'url' => ['main/setting']];
$this -> params['breadcrumbs'][] = ['label' => $this -> title];
?>

<div class="layui-row layui-col-space15">

    <div class="layui-col-md6">

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
                            <td>V<?php echo Yii::getVersion(); ?></td>
                        </tr>
                        <tr>
                            <td>Layui版本</td>
                            <td> <script type="text/html" template=""> V{{ layui.v }} </script> </td>
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

    <div class="layui-col-md6">

        <div class="layui-card">

            <div class="layui-card-header">
                <i class="zmdi zmdi-flag zmdi-hc-fw"></i> 环境
            </div>

            <div class="layui-card-body">

                
                

            </div>
            
        </div>
        
    </div>

    <div class="layui-col-md12">

        <div class="layui-card">

            <div class="layui-card-header">
                <i class="zmdi zmdi-label zmdi-hc-fw"></i> PHP 信息
            </div>

            <div class="layui-card-body">

                
                

            </div>
            
        </div>
        
    </div>


</div>