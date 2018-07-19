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
    if (!is_array($param)) {
        throw new \Exception('The first param of check_number function must be a array type.', PARAM_ERROR);
    }
    array_map(function($value) use ($must) {
        if (!$must && empty($value) && (0 !== $value || '0' !== $value)) {
            return true;
        }
        if ((empty($value) && 0 !== $value && '0' !== $value) || !is_numeric($value)) {
            throw new \Exception('参数错误！', PARAM_ERROR);
        }
    }, $param);
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
    if (!is_array($param)) {
        throw new \Exception('The first param of check_string function must be a array type.', PARAM_ERROR);
    }
    array_map(function($value) use ($must) {
        if (!$must && empty($value) && (0 !== $value || '0' !== $value)) {
            return true;
        }
        if ((empty($value) && 0 !== $value && '0' !== $value) || !is_string($value)) {
            throw new \Exception('参数错误！', PARAM_ERROR);
        }
    }, $param);
    return true;
}

/**
 * 电话号码验证
 * @param $mobile
 * @return bool
 * @throws Exception
 */
function check_phone($mobile) {
    if (!is_numeric($mobile) || !preg_match('#^1[\d]{10}$#', $mobile)) {
        throw new Exception( "手机号格式错误！", PARAM_ERROR );
    }
    return true;
}