<?php
/**
 * Aes 加解密
 * User: icoolyy
 * Date: 2017/6/14
 * Time: 上午10:03
 */
namespace app\common\tools;


class AesJs
{
    /**向量
     * @var string
     */
    private static $iv = "jSsGUiDSEyG33jV6";//16位
    /**
     * 默认秘钥
     */
    const KEY = 'rocketbird@2017!';//16位

    public static function init($iv = '')
    {
        self::$iv = $iv;
    }

    /**
     * 加密字符串
     * @param string $data 字符串
     * @param string $key  加密key
     * @return string
     */
    public static function encrypt($data = '', $key = self::KEY)
    {
        $encrypted = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $data, MCRYPT_MODE_CBC, self::$iv);
        return base64_encode($encrypted);
    }

    /**
     * 解密字符串
     * @param string $data 字符串
     * @param string $key  加密key
     * @return string
     */
    public static function decrypt($data = '', $key = self::KEY)
    {
        $decrypted = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, base64_decode($data), MCRYPT_MODE_CBC, self::$iv);
        return rtrim($decrypted, "\0");
    }
}

//调用
//加密
//AesJs::encrypt('要加密的字符串','秘钥');
//解密
//AesJs::decrypt('要解密的字符串','秘钥');