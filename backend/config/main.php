<?php

$config = [
    'modules' => [
        
    ],

    'components' => [

        /** ------ 后台操作日志 ------ **/
        // 'actionLog' => [

        //     'class' => 'common\models\sys\ActionLog',

        // ],

        /** ------ RBAC 配置 ------ **/
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // 认证类名称
            'ruleTable' => '{{%sys_auth_1_rule}}',
            'itemTable' => '{{%sys_auth_2_item}}', // 认证项表名称
            'assignmentTable' => '{{%sys_auth_3_assignment}}', // 认证项赋权关系
            'itemChildTable' => '{{%sys_auth_4_item_child}}', // 认证项父子关系
        ],

        /** ------ 资源替换 ------ **/
        'assetManager' => [
            'bundles' => [
                // 'yii\web\YiiAsset' => [
                //     'js' => [],            // 去除 yii.js
                //     'sourcePath' => null,  // 防止在 web/backend/asset 下生产文件
                // ],
                // 'yii\widgets\ActiveFormAsset' => [
                //     'js' => [],            // 去除 yii.activeForm.js
                //     'sourcePath' => null,  // 防止在 web/backend/asset 下生产文件
                // ],
                // 'yii\validators\ValidationAsset' => [
                //     'js' => [],            // 去除 yii.validation.js
                //     'sourcePath' => null,  // 防止在 web/backend/asset 下生产文件
                // ],
                'yii\web\JqueryAsset' => [
                    'jsOptions' => [
                        'position' => \yii\web\View::POS_HEAD
                    ],
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [],           // 去除 bootstrap.css
                    'sourcePath' => null,  // 防止在 web/backend/asset 下生产文件
                ],
                
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => [],            // 去除 bootstrap.js
                    'sourcePath' => null,  // 防止在 web/backend/asset 下生产文件
                ],
            ],
         ],

    ],
    

];

return $config;
