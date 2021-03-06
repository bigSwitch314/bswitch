<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Env;

$env = Env::get('env');
$env = in_array($env, ['dev', 'beta', 'sim', 'online']) ? $env : 'dev';

// 后端地址
$web_site = [
    'dev'    => 'https://beta.rocketbird.cn',
    'beta'   => 'https://beta.rocketbird.cn',
    'sim'    => 'https://sim.rocketbird.cn',
    'online' => 'https://wx.rocketbird.cn',
];

// 回调地址
$notify_site = [
    'dev'    => 'https://m-api-beta.rocketbird.cn',
    'beta'   => 'https://m-api-beta.rocketbird.cn',
    'sim'    => 'https://m-api-sim.rocketbird.cn',
    'online' => 'https://m-api.rocketbird.cn',
];

return [
    // +------------F----------------------------------------------------------
    // | 应用设置
    // +----------------------------------------------------------------------

    // 应用调试模式
    'app_debug'              => true,
    // 显示错误信息
    'show_error_msg'         => true,
    // 应用Trace
    'app_trace'              => true,
    // 应用模式状态
    'app_status'             => '',
    // 是否支持多模块
    'app_multi_module'       => true,
    // 入口自动绑定模块
    'auto_bind_module'       => false,
    // 注册的根命名空间
    'root_namespace'         => [],
    // 扩展函数文件
    'extra_file_list'        => [
        COMM_PATH . 'check' . EXT,
        THINK_PATH . 'helper' . EXT,
        COMM_PATH . 'constant' . EXT,
        COMM_PATH . 'function' . EXT,
    ],
    // 默认输出类型
    'default_return_type'    => 'json',
    // 默认AJAX 数据返回格式,可选json xml ...
    'default_ajax_return'    => 'json',
    // 默认JSONP格式返回的处理方法
    'default_jsonp_handler'  => 'jsonpReturn',
    // 默认JSONP处理方法
    'var_jsonp_handler'      => 'callback',
    // 默认时区
    'default_timezone'       => 'PRC',
    // 是否开启多语言
    'lang_switch_on'         => false,
    // 默认全局过滤方法 用逗号分隔多个
    'default_filter'         => '',
    // 默认语言
    'default_lang'           => 'zh-cn',
    // 应用类库后缀
    'class_suffix'           => false,
    // 控制器类后缀
    'controller_suffix'      => false,

    // +----------------------------------------------------------------------
    // | 模块设置
    // +----------------------------------------------------------------------

    // 默认模块名
    'default_module'         => 'index',
    // 禁止访问模块
    'deny_module_list'       => ['common'],
    // 默认控制器名
    'default_controller'     => 'Admin',
    // 默认操作名
    'default_action'         => 'index',
    // 默认验证器
    'default_validate'       => '',
    // 默认的空控制器名
    'empty_controller'       => 'Error',
    // 操作方法后缀
    'action_suffix'          => '',
    // 自动搜索控制器
    'controller_auto_search' => false,

    // +----------------------------------------------------------------------
    // | URL设置
    // +----------------------------------------------------------------------

    // PATHINFO变量名 用于兼容模式
    'var_pathinfo'           => 's',
    // 兼容PATH_INFO获取
    'pathinfo_fetch'         => ['ORIG_PATH_INFO', 'REDIRECT_PATH_INFO', 'REDIRECT_URL'],
    // pathinfo分隔符
    'pathinfo_depr'          => '/',
    // URL伪静态后缀
    'url_html_suffix'        => 'html',
    // URL普通方式参数 用于自动生成
    'url_common_param'       => true,
    // URL参数方式 0 按名称成对解析 1 按顺序解析
    'url_param_type'         => 0,
    // 是否开启路由
    'url_route_on'           => true,
    // 路由使用完整匹配
    'route_complete_match'   => false,
    // 路由配置文件（支持配置多个）
    'route_config_file'      => ['route'],
    // 是否强制使用路由
    'url_route_must'         => false,
    // 域名部署
    'url_domain_deploy'      => false,
    // 域名根，如thinkphp.cn
    'url_domain_root'        => '',
    // 是否自动转换URL中的控制器和操作名
    'url_convert'            => true,
    // 默认的访问控制器层
    'url_controller_layer'   => 'controller',
    // 表单请求类型伪装变量
    'var_method'             => '_method',
    // 表单ajax伪装变量
    'var_ajax'               => '_ajax',
    // 表单pjax伪装变量
    'var_pjax'               => '_pjax',
    // 是否开启请求缓存 true自动缓存 支持设置请求缓存规则
    'request_cache'          => false,
    // 请求缓存有效期
    'request_cache_expire'   => null,
    // 全局请求缓存排除规则
    'request_cache_except'   => [],

    // +----------------------------------------------------------------------
    // | 日志设置
    // +----------------------------------------------------------------------

    'log'                    => [
        // 日志记录方式，内置file socket支持扩展
        'type'        => 'File',
        // 日志保存目录
        'path'        => LOG_PATH,
        // 日志记录级别
        'level'       => [],
        // 日志大小
        'size'        => 56200000,
        // 日志队列
        'queue' => 'queue:socket_log'
    ],

    // +--
    //--------------------------------------------------------------------
    // | 缓存设置
    // +----------------------------------------------------------------------

    'cache'                  => [
        // 驱动方式
        'type'   => 'File',
        // 缓存保存目录
        'path'   => CACHE_PATH,
        // 缓存前缀
        'prefix' => '',
        // 缓存有效期 0表示永久缓存
        'expire' => 0,
    ],

    // +----------------------------------------------------------------------
    // | 会话设置
    // +----------------------------------------------------------------------

    'session'                => [
        'id'             => '',
        // SESSION_ID的提交变量，解决flash上传跨域
        'var_session_id' => '',
        // SESSION前缀
        'prefix'         => '',
        // 是否自动开启SESSION
        'auto_start'     => true,
        // sessionkey前缀
        'session_name'   => 'sess_',
        // 驱动方式支持redis、memcache、memcached
        'type'           => 'redis',
        // redis主机
        'host'           => '127.0.0.1',
        // redis密码
        'password'       => 'lq420684',
        // redis端口
        'port'           => 6379
    ],

    // +----------------------------------------------------------------------
    // | Cookie设置
    // +----------------------------------------------------------------------

    'cookie'                 => [
        // cookie 名称前缀
        'prefix'    => '',
        // cookie 保存时间
        'expire'    => 0,
        // cookie 保存路径
        'path'      => '/',
        // cookie 有效域名
        'domain'    => '',
        //  cookie 启用安全传输
        'secure'    => false,
        // httponly设置
        'httponly'  => '',
        // 是否使用 setcookie
        'setcookie' => true,
    ],

    // +----------------------------------------------------------------------
    // | 其他设置
    // +----------------------------------------------------------------------

    // 加密密钥
    'encode_key' => 'webHttpFrameWork@2016#!Fuck Me',

    // redis记录发送短信验证码过期时间,10min
    'sms_code_expire' => '600',

    // redis配置
    'redis_conf' => [
        'master' => [
            [
                'host' => '127.0.0.1',
                'auth' => 'lq420684',
                'port' => 6379
            ],
        ],
        'slave' => [
            [
                'host' => '127.0.0.1',
                'auth' => 'lq420684',
                'port' => 6379
            ],
        ],
    ],

    // sphinx配置
    'sphinx_conf' => [
        'host' => '127.0.0.1',
        'port' => 9312
    ],

];
