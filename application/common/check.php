<?php
/**
 * Created by PhpStorm.
 * User: qiangluo
 * Date: 2018/7/13
 * Time: 下午2:39
 */

// +----------------------------------------------------------------------
// | 参数验证公共方法
// +----------------------------------------------------------------------

/**
 * 数字类型验证
 * @param $param
 * @param bool $must
 * @return bool
 * @throws Exception
 */
function check_number($param, $must = true) {
    if (is_array($param)) {
        array_map(function($value) use ($must) {
            if (!$must && empty($value) && (0 !== $value || '0' !== $value)) {
                return true;
            }
            if ((empty($value) && 0 !== $value && '0' !== $value) || !is_numeric($value)) {
                throw new \Exception('参数错误！', PARAM_ERROR);
            }
            return true;
        }, $param);
    } else {
        if (false == $must && empty($param) && (0 !== $param || '0' !== $param)) {
            return true;
        }
        if (true == $must && (empty($param) && 0 !== $param && '0' !== $param) || !is_numeric($param)) {
            throw new \Exception('参数错误！', PARAM_ERROR);
        }
    }
    return true;
}

/**
 * 数字类型范围验证
 * @param $param
 * @param $arr
 * @param bool $must
 * @return bool
 * @throws Exception
 */
function check_number_range($param, $arr, $must = true) {
    if (!$must && empty($param) && (0 !== $param || '0' !== $param)) {
       return true;
    }
    if ((empty($param) && 0 !== $param && '0' !== $param) ||
        !is_numeric($param) || !in_array($param, $arr)) {
        throw new \Exception('参数错误！', PARAM_ERROR);
    }
    return true;
}

/**
 * 字符类型验证
 * @param $param
 * @param bool $must
 * @return bool
 * @throws Exception
 */
function check_string($param, $must = true) {
    if (is_array($param)) {
        array_map(function($value) use ($must) {
            if (!$must && empty($value) && (0 !== $value || '0' !== $value)) {
                return true;
            }
            if ((empty($value) && 0 !== $value && '0' !== $value) || !is_string($value)) {
                throw new \Exception('参数错误！', PARAM_ERROR);
            }
            return true;
        }, $param);
    } else {
        if (false == $must && empty($param) && (0 !== $param || '0' !== $param)) {
            return true;
        }
        if (false == $must && (empty($param) && 0 !== $param && '0' !== $param) || !is_string($param)) {
            throw new \Exception('参数错误！', PARAM_ERROR);
        }
        return true;
    }
    return true;
}

/**
 * 电话号码验证
 * @param $mobile
 * @param bool $must
 * @return bool
 * @throws Exception
 */
function check_phone($mobile, $must = true) {
    if (empty($mobile) && true == $must) {
        throw new Exception("  请填写电话号码！", PARAM_ERROR);
    }
    if (empty($mobile) && false == $must) {
        return true;
    }
    if (!is_numeric($mobile) || !preg_match('#^1[\d]{10}$#', $mobile)) {
        throw new Exception("手机号格式错误！", PARAM_ERROR);
    }
    return true;
}

/**
 * 邮箱验证
 * @param $email
 * @param bool $must
 * @return bool
 * @throws Exception
 */
function check_email($email, $must = true) {
    if (empty($email) && true == $must) {
        throw new Exception("  请填写邮箱！", PARAM_ERROR);
    }
    if (empty($email) && false == $must) {
        return true;
    }
    if (!preg_match("/\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/", $email)) {
        throw new Exception("邮箱格式不正确！", PARAM_ERROR);
    }
    return true;
}

/**
 * 不为空验证
 * @param $param
 * @return bool
 * @throws Exception
 */
function check_not_null($param) {
    if (empty($param)) {
        throw new Exception("参数错误", PARAM_ERROR);
    }
    return true;
}