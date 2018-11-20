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
        'WEB_PAGE_SIZE',
        'WEB_SITE_CACHE',
        'WEB_MAX_FILE_SIZE',
        'WEB_FILE_TYPE',
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
        '/sys/manager/index',
        '/sys/rbac/role',
        '/sys/rbac/accredit',
        '/sys/rbac/rule',

    ],

    /** ------ 默认禁止删除的权限路由 ------ **/
    'defaultNotDelRbacUrl' => [

        'sys-extend',
        'sys-extend-menu',
        '/sys/menu/side-menu',
        '/sys/menu/sys-menu',
        '/sys/menu/edit',
        '/sys/menu/ajax-update',
        '/sys/menu/recycle',
        '/sys/menu/restore',
        '/sys/menu/status-del',
        '/sys/menu/delete',
        'sys-extend-config',
        '/sys/config/index',
        '/sys/config/edit',
        '/sys/config/ajax-update',
        '/sys/config/recycle',
        '/sys/config/restore',
        '/sys/config/status-del',
        '/sys/config/delete',

        'sys-rbac',
        'sys-rbac-accredit',
        '/sys/rbac/accredit',
        '/sys/rbac/accredit-edit',
        '/sys/rbac/accredit-del',
        '/sys/rbac/accredit-assign',
        'sys-rbac-role',
        '/sys/rbac/role',
        '/sys/rbac/role-edit',
        '/sys/rbac/role-del',
        'sys-rbac-rule',
        '/sys/rbac/rule',
        '/sys/rbac/ajax-update',


    ],

    /** ------ 默认禁止删除的角色名称 ------ **/
    'defaultNotDelRoleName' => [
        '总管理员'
    ],


    /** ------ 默认无需RBAC验证的路由 ------ **/
    'defaultNotAuthRoute' => [
        '/app-backend/site/index',           // HomePage
        '/app-backend/site/login',           // 登陆
        '/app-backend/site/register',        // 注册
        '/app-backend/site/forgot-password', // 忘记密码
        '/app-backend/site/reset-password',  // 重置密码
        '/app-backend/site/reset-code',      // 重置验证码
        '/app-backend/site/get-sms-code',    // 发送手机验证码
        '/app-backend/site/logout',          // 退出

        '/sys/main/index',                   // 系统首页
        '/sys/main/setting',                 // 系统管理
    ],

    /** ------ 默认无需RBAC验证的方法 ------ **/
    'defaultNotAuthAction' => [
        
    ],
    
];
