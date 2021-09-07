<?php

return [
    // +----------------------------------------------------------------------
    // | 应用设置
    // +----------------------------------------------------------------------
    // 应用调试模式
    'app_debug'              => true,
    // 应用Trace
    'app_trace'              => false,
    // 应用模式状态
    'app_status'             => '',
    // 是否支持多模块
    'app_multi_module'       => true,
    // 入口自动绑定模块
    'auto_bind_module'       => false,
    // 注册的根命名空间
    'root_namespace'         => [],
    // 扩展函数文件
    'extra_file_list'        => [THINK_PATH . 'helper' . EXT],
    // 默认输出类型
    'default_return_type'    => 'html',
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
    // strip_tags: 剥去字符串中的 HTML 标签 
    // addslashes: 防SQL注入，在每个双引号（"）前添加反斜杠      [还原:stripslashes]
    // htmlspecialchars: 防XSS攻击，尖括号等转义过滤           [还原:htmlspecialchars_decode]
    'default_filter'         => 'strip_tags,addslashes,htmlspecialchars',
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
    'default_controller'     => 'Index',
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
    'url_common_param'       => false,
    // URL参数方式 0 按名称成对解析 1 按顺序解析
    'url_param_type'         => 0,
    // 是否开启路由
    'url_route_on'           => true,
    // 路由使用完整匹配
    'route_complete_match'   => false,
    // 路由配置文件（支持配置多个）
    'route_config_file'      => ['route'],
    // 是否开启路由解析缓存
    'route_check_cache'      => false,
    // 是否强制使用路由
    'url_route_must'         => true,
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
    // | 模板设置
    // +----------------------------------------------------------------------
    'template'               => [
        // 模板引擎类型 支持 php think 支持扩展
        'type'         => 'Think',
        // 默认模板渲染规则 1 解析为小写+下划线 2 全部转换小写
        'auto_rule'    => 1,
        // 模板路径
        'view_path'    => '',
        // 模板后缀
        'view_suffix'  => 'html',
        // 模板文件名分隔符
        'view_depr'    => DS,
        // 模板引擎普通标签开始标记
        'tpl_begin'    => '{',
        // 模板引擎普通标签结束标记
        'tpl_end'      => '}',
        // 标签库标签开始标记
        'taglib_begin' => '{',
        // 标签库标签结束标记
        'taglib_end'   => '}',
    ],
    // 视图输出字符串内容替换
    'view_replace_str'       => [],
    // 默认跳转页面对应的模板文件
    'dispatch_success_tmpl'  => EXTEND_PATH . DS . 'tpl' . DS . 'dispatch_jump.tpl', //THINK_PATH . 'tpl' . DS . 'dispatch_jump.tpl',
    'dispatch_error_tmpl'    => EXTEND_PATH . DS . 'tpl' . DS . 'dispatch_jump.tpl', //THINK_PATH . 'tpl' . DS . 'dispatch_jump.tpl',

    // +----------------------------------------------------------------------
    // | 异常及错误设置
    // +----------------------------------------------------------------------
    // 异常页面的模板文件
    'exception_tmpl'         => EXTEND_PATH . DS . 'tpl' . DS . 'think_exception.tpl', //THINK_PATH . 'tpl' . DS . 'think_exception.tpl',
    // 错误显示信息,非调试模式有效
    'error_message'          => '出现未知错误,请通知系统管理员.',
    // 显示错误信息
    'show_error_msg'         => false,
    // 异常处理handle类 留空使用 \think\exception\Handle
    'exception_handle'       => '',

    // +----------------------------------------------------------------------
    // | 日志设置
    // +----------------------------------------------------------------------
    'log'                    => [
        // 日志记录方式，内置 file socket 支持扩展
        'type'  => '\tpl\log\driver\File', // 'type'  => 'File',
        // 日志保存目录
        'path'  => LOG_PATH,
        // 独立日志
        'apart_level' => ['error', 'notice'],
    ],

    // +----------------------------------------------------------------------
    // | Trace设置 开启 app_trace 后 有效
    // +----------------------------------------------------------------------
    'trace'                  => [
        // 内置Html Console 支持扩展
        'type' => 'Html',
    ],

    // +----------------------------------------------------------------------
    // | 缓存设置
    // | 同时使用多个缓存类型
    // | 切换到file操作
    // | Cache::store('file')->set('name','value');
    // | Cache::get('name');
    // | 切换到redis操作
    // | Cache::store('redis')->set('name','value');
    // | Cache::get('name');
    // +----------------------------------------------------------------------
    'cache' =>  [
        // 使用复合缓存类型
        'type'  =>  'complex',
        // 默认使用的缓存
        'default'   =>  [
            'type'   => 'File', // 驱动方式
        ],
        // 文件缓存
        'file'   =>  [
            'type'   => 'file',
            'path'   => CACHE_PATH, // 缓存保存目录
            'prefix' => '', // 缓存前缀
            'expire' => 0, // 缓存有效期 0表示永久缓存
        ],
        // redis缓存
        'redis'   =>  [
            'type'     => 'redis',
            'host'     => '127.0.0.1',
            'port'     => 6379,
            'password' => '',
            'expire'   => 0,
        ],
    ],

    // +----------------------------------------------------------------------
    // | 会话设置
    // +----------------------------------------------------------------------
    'session'                => [
        'id'             => '',
        // SESSION_ID的提交变量,解决flash上传跨域
        'var_session_id' => '',
        // SESSION 前缀
        'prefix'         => 'think',
        // 驱动方式 支持redis memcache memcached
        'type'           => '',
        // 是否自动开启 SESSION
        'auto_start'     => true,
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
    // | 分页配置
    // +----------------------------------------------------------------------
    'paginate'               => [
        'type'      => 'bootstrap',
        'var_page'  => 'page',
        'list_rows' => 15,
    ],

    // +----------------------------------------------------------------------
    // | 验证码配置
    // +----------------------------------------------------------------------
    'captcha'                => [
        // 验证码字符集合
        'codeSet'       => '2345678ABCDEFGHJKLMNPQRTUVWXY',
        // 验证码字体大小(px)
        'fontSize'      => 28,
        // 是否画混淆曲线
        'useCurve'      => false,
        // 验证码位数
        'length'        => 4,
        // 验证成功后是否重置
        'reset'         => true,
        // 是否使用算术验证码
        'useArithmetic' => true,
    ],

    // 自定义系统配置
    'admin'                 => [
        // 超级管理员ID
        'id'        => 1,
        // 是否开启谷歌验证码
        // PHP: composer require "phpgangsta/googleauthenticator:dev-master"
        // iOS: AppStore搜索Google Authenticator / Android: GooglePlay搜索Google身份验证器或者其他安卓市场下载
        'google'    => false,
        // 是否开启管理员操作日志
        'log'       => true,
    ],

    //JWT
    'jwt'                   => [
        'key'       => 'WWW.JWT.KEY',
        'time_out'  => 86400,
    ],
];
