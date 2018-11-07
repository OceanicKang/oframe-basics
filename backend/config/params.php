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
        ''              => "无",
        'text'          => "文本框",
        'number'        => "数字框",
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

        'SYS',
        'WEB_SITE',
        'WEB_SITE_TITLE',
        'WEB_SITE_LOGO_NAME',
        'WEB_SITE_AD_NAME',
        'WEB_SITE_DOMAIN',
        'WEB_SITE_CACHE',
        'WEB_MAX_FILE_SIZE',
        'WEB_FILE_TYPE',
        'WEB_SITE_INDEX_TITLE',
        'WEB_META_KEY',
        'WEB_META_DESCRIBE',
        'WEB_COPY_RIGHT',

        'SYS_EMAIL',
        'SYS_EMAIL_HOST',
        'SYS_EMAIL_PORT',
        'SYS_EMAIL_USERNAME',
        'SYS_EMAIL_NICKNAME',
        'SYS_EMAIL_PASSWORD',
        'SYS_EMAIL_ENCRYPTION',

    ],

    /** ------ 默认禁止删除的菜单路由 ------ **/
    'defaultNotDelMenuUrl' => [

        'SYS',
        '/sys/setting/web',
        '/sys/setting/email',

        'RBAC',
        '/sys/rbac/role',
        '/sys/rbac/accredit',

    ],


    /** ------ 默认无需RBAC验证的路由 ------ **/
    'defaultNotAuthRoute' => [

    ],

    /** ------ 默认无需RBAC验证的方法 ------ **/
    'defaultNotAuthAction' => [

    ],
    
];
