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

namespace think;

use think\exception\ValidateException;
use traits\controller\Jump;

Loader::import('controller/Jump', TRAIT_PATH, EXT);

class Controller
{
    use Jump;

    /**
     * @var \think\View 视图类实例
     */
    protected $view;

    /**
     * @var \think\Request Request 实例
     */
    protected $request;

    /**
     * @var bool 验证失败是否抛出异常
     */
    protected $failException = false;

    /**
     * @var bool 是否批量验证
     */
    protected $batchValidate = false;

    /**
     * @var array 前置操作方法列表
     */
    protected $beforeActionList = [];

    /**
     * @var array 请求参数
     */
    protected $param = [];

    /**
     * @var int 开始时间
     */
    protected $start_time;

    /**
     * 构造方法
     * @access public
     * @param Request $request Request 对象
     */
    public function __construct(Request $request = null)
    {
        $this->view    = View::instance(Config::get('template'), Config::get('view_replace_str'));
        $this->request = is_null($request) ? Request::instance() : $request;

        // 控制器初始化
        $this->_initialize();

        // 前置操作方法
        if ($this->beforeActionList) {
            foreach ($this->beforeActionList as $method => $options) {
                is_numeric($method) ?
                $this->beforeAction($options) :
                $this->beforeAction($method, $options);
            }
        }

        // 参数获取
        $this->param = $this->request->param();
    }

    /**
     * 初始化操作
     * @access protected
     */
    protected function _initialize()
    {
    }

    /**
     * 前置操作
     * @access protected
     * @param  string $method  前置操作方法名
     * @param  array  $options 调用参数 ['only'=>[...]] 或者 ['except'=>[...]]
     * @return void
     */
    protected function beforeAction($method, $options = [])
    {
        if (isset($options['only'])) {
            if (is_string($options['only'])) {
                $options['only'] = explode(',', $options['only']);
            }

            if (!in_array($this->request->action(), $options['only'])) {
                return;
            }
        } elseif (isset($options['except'])) {
            if (is_string($options['except'])) {
                $options['except'] = explode(',', $options['except']);
            }

            if (in_array($this->request->action(), $options['except'])) {
                return;
            }
        }

        call_user_func([$this, $method]);
    }

    /**
     * 加载模板输出
     * @access protected
     * @param  string $template 模板文件名
     * @param  array  $vars     模板输出变量
     * @param  array  $replace  模板替换
     * @param  array  $config   模板参数
     * @return mixed
     */
    protected function fetch($template = '', $vars = [], $replace = [], $config = [])
    {
        return $this->view->fetch($template, $vars, $replace, $config);
    }

    /**
     * 渲染内容输出
     * @access protected
     * @param  string $content 模板内容
     * @param  array  $vars    模板输出变量
     * @param  array  $replace 替换内容
     * @param  array  $config  模板参数
     * @return mixed
     */
    protected function display($content = '', $vars = [], $replace = [], $config = [])
    {
        return $this->view->display($content, $vars, $replace, $config);
    }

    /**
     * 模板变量赋值
     * @access protected
     * @param  mixed $name  要显示的模板变量
     * @param  mixed $value 变量的值
     * @return $this
     */
    protected function assign($name, $value = '')
    {
        $this->view->assign($name, $value);

        return $this;
    }

    /**
     * 初始化模板引擎
     * @access protected
     * @param array|string $engine 引擎参数
     * @return $this
     */
    protected function engine($engine)
    {
        $this->view->engine($engine);

        return $this;
    }

    /**
     * 设置验证失败后是否抛出异常
     * @access protected
     * @param bool $fail 是否抛出异常
     * @return $this
     */
    protected function validateFailException($fail = true)
    {
        $this->failException = $fail;

        return $this;
    }

    /**
     * 验证数据
     * @access protected
     * @param  array        $data     数据
     * @param  string|array $validate 验证器名或者验证规则数组
     * @param  array        $message  提示信息
     * @param  bool         $batch    是否批量验证
     * @param  mixed        $callback 回调方法（闭包）
     * @return array|string|true
     * @throws ValidateException
     */
    protected function validate($data, $validate, $message = [], $batch = false, $callback = null)
    {
        if (is_array($validate)) {
            $v = Loader::validate();
            $v->rule($validate);
        } else {
            // 支持场景
            if (strpos($validate, '.')) {
                list($validate, $scene) = explode('.', $validate);
            }

            $v = Loader::validate($validate);

            !empty($scene) && $v->scene($scene);
        }

        // 批量验证
        if ($batch || $this->batchValidate) {
            $v->batch(true);
        }

        // 设置错误信息
        if (is_array($message)) {
            $v->message($message);
        }

        // 使用回调验证
        if ($callback && is_callable($callback)) {
            call_user_func_array($callback, [$v, &$data]);
        }

        if (!$v->check($data)) {
            if ($this->failException) {
                throw new ValidateException($v->getError());
            }

            return $v->getError();
        }

        return true;
    }



    /**
     * ajax方式返回数据给客户端
     * @param $data
     * @param string $type
     */
    protected function ajaxReturn($data, $type = '')
    {
        $global_start_time = $GLOBALS['index_start_time'];
        if ($global_start_time) {
            $this->start_time = $global_start_time;
        }
        // 请求时间统计
        $time_limit = ini_get('max_execution_time');
        $time_start = get_microtime($this->start_time);
        $time_end   = get_microtime(microtime());
        $time_use   = ($time_end - $time_start) / 1000000;
        $time_percent = (string)round($time_use / $time_limit, 4) * 100 . '%';
        $time_stat  = $time_limit . '_' . $time_use . '_' . $time_percent;
        // 使用内存统计
        $memory_limit   = other2byte(ini_get('memory_limit'));
        $memory_use     = memory_get_peak_usage(true);
        $memory_percent = (string)round(($memory_use / $memory_limit), 4) * 100 . '%';
        $memory_use     = (string)round($memory_use / pow(1024, 2), 2) . 'mb';
        $memory_limit   = (string)round($memory_limit / pow(1024, 2), 2) . 'mb';
        $memory_stat    = $memory_limit . '_' . $memory_use . '_' . $memory_percent;
        // 返回对应的数据类型
        if (empty($type)) {
            $type = Config::get('default_return_type');
        }
        switch (strtoupper($type)) {
            // 返回json数据格式
            case 'JSON' :
                $data = (object)$data;
                $str  = sprintf("module=%s\tcontroller=%s\taction=%s\ttime_stat=%s\tmemory_stat=%s\t%s\terrcode=%s\terrmsg=%s",
                    $this->request->module(), $this->request->controller(), $this->request->action(), $time_stat, $memory_stat, get_params(), $data->errcode, $data->errmsg);
                if (isset($data->log)) {
                    $str = $str . $data->log;
                    unset($data->log);
                }
                logw($str);
                header('Content-Type:application/json; charset=utf-8');
                exit(json_encode_unescape($data));

            // 返回xml格式数据
            case 'XML' :
                header('Content-Type:text/xml; charset=utf-8');
                exit(array2xml($data));

            // 返回JSONP数据格式
            case 'JSONP' :
                header('Content-Type:application/json; charset=utf-8');
                $var_jsonp_handler = $this->request->param(Config::get('var_jsonp_handler'));
                $handler = isset($var_jsonp_handler) ? $var_jsonp_handler : Config::get('default_jsonp_handler');
                exit($handler . '(' . json_encode($data) . ');');

            // 返回可执行的js脚本
            case 'EVAL' :
                header('Content-Type:text/html; charset=utf-8');
                exit($data);

            // 用于扩展其他返回格式数据
            default :
                Hook::listen('ajax_return', $data);
        }
    }
}
