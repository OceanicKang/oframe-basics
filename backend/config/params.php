<?php
return [
    'adminEmail' => 'admin@example.com',

    /** ------ 系统信息 ------ **/
    'Author_Info' => [
        'system_name' => 'OceanicFrame 框架',
        'system_version' => 'V 1.0.0',
        'author_name' => 'OceanicKang',
        'home_url' => 'www.oceanickang.com',
        'docs_url' => 'oceanickang.github.io/OceanicFrame',
        'demo_url' => '#',
        'gitee_url' => 'gitee.com/oceanickang/OceanicFrame',
        'github_url' => 'github.com/OceanicKang/OceanicFrame',
        'qq_group' => [
            'name' => '850238761',
            'url' => 'shang.qq.com/wpa/qunwpa?idkey=d3b7d66814063b2741d53b8f26ea8c4c17410b173b87353d2d0794833f247ec5'
        ],
    ],

    /** ------ php 扩展 ------ **/
    'extension_loaded' => [
        'fileinfo',
        'memcache',
        'memcached',
        'redis',
        'swoole',
        'mongodb',
        'bz2',
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
        'statusRadio'   => "状态按钮",
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
        'WEB_DEFAULT_AVATAR',

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
        // 侧边
        '/sys/setting/config',

        // 系统
        'RBAC',
        '/sys/manager/index',
        '/sys/rbac/role',
        '/sys/rbac/accredit',
        '/sys/rbac/rule',

        'TOOLS',
        '/sys/data/index',

    ],

    /** ------ 默认禁止删除的权限路由 ------ **/
    'defaultNotDelRbacUrl' => [

        'menu-setting',              // 菜单 -- 系统设置
        '/sys/setting/config',       // 网站配置信息
        '/sys/setting/update',       // 更新配置
        '/sys/setting/send-email',   // 发送测试邮件

        'sys-extend',                // 系统 -- 扩展
        'sys-extend-menu',           // 菜单管理
        '/sys/menu/side-menu',       // 侧边菜单列表
        '/sys/menu/sys-menu',        // 系统菜单列表
        '/sys/menu/edit',            // 编辑|新增
        '/sys/menu/ajax-update',     // 开启|关闭|排序
        '/sys/menu/recycle',         // 回收站
        '/sys/menu/restore',         // 回收站还原
        '/sys/menu/status-del',      // 状态删除
        '/sys/menu/delete',          // 彻底删除
        'sys-extend-config',         // 配置权限
        '/sys/config/index',         // 配置列表
        '/sys/config/edit',          // 编辑|新增
        '/sys/config/ajax-update',   // 开启|关闭|排序
        '/sys/config/recycle',       // 回收站
        '/sys/config/restore',       // 回收站还原
        '/sys/config/status-del',    // 状态删除
        '/sys/config/delete',        // 彻底删除

        'sys-rbac',                  // 系统 -- 用户权限
        'sys-rbac-manager',          // 后台用户
        'sys-rbac-role',             // 角色管理
        '/sys/rbac/role',            // 角色列表
        '/sys/rbac/role-edit',       // 编辑|新增
        '/sys/rbac/role-del',        // 删除角色
        'sys-rbac-accredit',         // 权限管理
        '/sys/rbac/accredit',        // 权限列表
        '/sys/rbac/accredit-edit',   // 编辑|新增
        '/sys/rbac/accredit-del',    // 删除权限
        '/sys/rbac/accredit-assign', // 分配权限
        'sys-rbac-rule',             // 规则管理
        '/sys/rbac/rule',            // 规则列表
        '/sys/rbac/ajax-update',     // 开启|关闭|排序    

        'sys-tools',                 // 系统 -- 系统工具
        'sys-tools-database',        // 数据库管理
        '/sys/data/index',           // 数据列表
        '/sys/data/backup-files',    // 备份文件列表
        '/sys/data/optimize',        // 优化数据表
        '/sys/data/repair',          // 修复数据表
        '/sys/data/backup',          // 备份数据库
        '/sys/data/recover',         // 还原数据库
        '/sys/data/download',        // 下载备份文件
        '/sys/data/delete',          // 删除备份文件
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
