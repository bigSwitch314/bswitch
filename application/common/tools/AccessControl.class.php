<?php
/**
 * Created by PhpStorm.
 * User: Jimmy
 * Date: 2017/7/5
 * Time: 17:21
 */

namespace Common\Tools;
use Common\Tools\RedisClient;

class AccessControl
{

    /**
     * 鸡迷 2017.7.5
     * 限制访问API次数
     *param $className 类名
     *param $actionName 方法名
     *param array $limitRule 例如 ['60'=>10,'3600'=>20] 60秒内最多10次访问 , 3600秒内最多20次访问
     *param array $flags 例如 array('IP','Phone')
     *return bool
     */

    public function limit_api_rate($className, $actionName, array $limitRule, array $flags)
    {

        if (!is_array($limitRule) || !is_array($flags)) {
            return false;
        }

        $redis = new RedisClient();
        $redis = $redis->getRedis();

        foreach ($flags as $flag) {

            foreach ($limitRule as $timeOut => $times) {

                $limit_flag_str = "limitapi:{$className}:{$actionName}:{$timeOut}:$flag";

                $lua_script = <<<luascript
                 local current
                 current = redis.call('incr',KEYS[1])
                 current = tonumber(current)
                 if current == 1 then
                      redis.call('expire',KEYS[1],ARGV[1])
                 end
                return current
luascript;

                $rst = $redis->evaluate($lua_script, array($limit_flag_str, $timeOut), 1);

                if ($rst > $times) {

                    logw("pathinfo:{$className}/{$actionName}, in {$timeOut} seconds requesting {$rst} times,limit_times:{$times}",'info');
                    return false;
                }

            }

        }

        return true;

    }

}