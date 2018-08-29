<?php
/**
 * Aes 加解密
 */
namespace Common\Tools;

class AesJsV2 {
    /**向量
     * @var string
     */
    private static $iv = "kiPqmEVXtZrgaVkf";//16位
    /**
     * 默认秘钥
     */
    const KEY = 'rocketbird!@sjs!';//16位

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
    function encrypt($str,$is_PKCS5Padding = false){

        $td = mcrypt_module_open('rijndael-128', '', 'cbc',self::$iv);
        mcrypt_generic_init($td, self::KEY,self::$iv);

        if($is_PKCS5Padding){
            $block = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);  // PKCS5Padding 填充
            $pad = $block - (strlen($str) % $block); //Compute how many characters need to pad
            $str .= str_repeat(chr($pad), $pad); // After pad, the str length must be equal to block or its integer multiples
        }

        $encrypted = @mcrypt_generic($td, $str);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        $encrypted = base64_encode($encrypted);
        return $encrypted;

    }
    /**
     * 解密字符串
     * @param string $data 字符串
     * @param string $key  加密key
     * @return string
     */
    function decrypt($decode_str){

        $decode_str = base64_decode($decode_str);
        $detd = mcrypt_module_open('rijndael-128', '', 'cbc', self::$iv);
        mcrypt_generic_init($detd, self::KEY, self::$iv);
        $decrypted = @mdecrypt_generic($detd, $decode_str);
        mcrypt_generic_deinit($detd);
        mcrypt_module_close($detd);
        return $decrypted;

    }
}

//调用
//加密
//AesJs::encrypt('要加密的字符串','秘钥');
//解密
//AesJs::decrypt('要解密的字符串','秘钥');