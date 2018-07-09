<?php
/**
 * 模板消息ID配置
 */

use think\Env;

$env = Env::get('env');
$env = in_array($env, ['dev', 'beta', 'sim', 'online']) ? $env : 'dev';

$template_conf = [
	'dev'    => [
		'pt_card_template_id' => 'SUIdaPAfGALJHScmH3QKSBxv3zV0ry5Uqzz8WnhRjwc',  // 私教购买通知  购买课程通知
		'card_template_id'    => '0oURG4qoKWCS5YpuZsPu-3lcKP8ZCl5mqJGoCoVsgOc',  // 会员卡购买通知  健身服务购买成功通知
	],
	'beta'   => [
		'pt_card_template_id' => 'SUIdaPAfGALJHScmH3QKSBxv3zV0ry5Uqzz8WnhRjwc',  // 私教购买通知  购买课程通知
		'card_template_id'    => '0oURG4qoKWCS5YpuZsPu-3lcKP8ZCl5mqJGoCoVsgOc',  // 会员卡购买通知  健身服务购买成功通知
    ],
	'sim'    => [
		'pt_card_template_id' => 'SUIdaPAfGALJHScmH3QKSBxv3zV0ry5Uqzz8WnhRjwc',  // 私教购买通知  购买课程通知
		'card_template_id'    => '0oURG4qoKWCS5YpuZsPu-3lcKP8ZCl5mqJGoCoVsgOc',  // 会员卡购买通知  健身服务购买成功通知
    ],
	'online' => [
		'pt_card_template_id' => 'wd1bfLZpMOdzz7AAxQ_zVDWAyM7V-HVn5KS1fg7cBA0',  // 私教购买通知  购买课程通知
		'card_template_id'    => 'lOaxrDPz1GI8JWX0RRC6FiuJu0LEOTd9755gT5crKZw',  // 会员卡购买通知  健身服务购买成功通知
    ],
];

return [
	'pt_card_template_id' => $template_conf[ $env ]['pt_card_template_id'],      // 私教购买通知  购买课程通知
	'card_template_id'    => $template_conf[ $env ]['card_template_id'],         // 会员卡购买通知  健身服务购买成功通知
];