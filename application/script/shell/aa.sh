#!/bin/sh

#本地文件路径
#code_path="/var/www/laravel/"
#php_path="/usr/bin/php"
#log_path="/mnt/test/log/message/"

#msg_beta文件路径
#code_path="/home/www/beta/msg_center/"
#php_path="/usr/bin/php"
#log_path="/mnt/test/log/message/"

#msg_sim文件路径
code_path="/home/www/qn/predeploy/msg_center/"
php_path="/usr/local/bin/php"
log_path="/mnt/sim/log/message/"

#msg_online文件路径
#code_path="/home/www/qn/deploy/msg_center/"
#php_path="/usr/local/bin/php"
#log_path="/mnt/online/log/message/"


if [ ! -x "${log_path}" ]; then
    mkdir -p "${log_path}"
fi


start() {
    while true
    do
        date=`date '+%Y-%m-%d'`

        cd ${code_path} && nohup ${php_path} ${code_path}index.php  script/msg/send >> ${log_path}msg_center-${date}.log 2>&1 &

        wait
    done
}

start &