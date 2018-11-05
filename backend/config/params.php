<?php
return [
    'adminEmail' => 'admin@example.com',

    'Author_Info' => [
        'name' => 'OceanicKang',
        'home_url' => 'https://blog.oceanickang.com',
        'docs_url' => 'https://oceanickang.github.io/OceanicFrame',
        'demo_url' => '#',
    ],

    /** ------ 配置管理类型 ------ **/
    'configTypeList' => [
        ''              => '无',
        'text'          => "文本框",
        'password'      => "密码框",
        'secretKeyText' => "密钥文本框",
        'textarea'      => "文本域",
        'dropDownList'  => "下拉文本框",
        'radioList'     => "单选按钮",
        'editor'        => "编辑器",
        'image'         => "图片上传",
        'images'        => "多图上传",
        'file'          => "文件上传",
        'files'         => "多文件上传",
    ],

    /** ------ 默认禁止删除的配置标识 ------ **/
    'defaultNotDelConfigName' => [

    ],

    /** ------ 默认禁止删除的菜单路由 ------ **/
    'defaultNotDelMenuUrl' => [

    ],


    /** ------ 默认无需RBAC验证的路由 ------ **/
    'defaultNotAuthRoute' => [

    ],

    /** ------ 默认无需RBAC验证的方法 ------ **/
    'defaultNotAuthAction' => [

    ],
    
];
