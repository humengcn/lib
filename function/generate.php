<?php

/**
 * 
 * 产生随机字符串，不长于32位
 * @param int $length
 * @return 产生的随机字符串
 */
function getNonceStr($length = 32) 
{
	$chars = "abcdefghijklmnopqrstuvwxyz0123456789";  
	$str ="";
	for ( $i = 0; $i < $length; $i++ )  {  
		$str .= substr($chars, mt_rand(0, strlen($chars)-1), 1);  
	} 
	return $str;
}

/**
 * 验证码生成
 * 
 * @param type $length 验证码长度，默认为4，不能超过13位
 * @param type $has_letter 验证码中是否包含字母
 * @return string
 */
function generateSalt($length = 4, $has_letter = false)
{
    $salt = '';
    if ($has_letter) {
        $salt = substr(uniqid(), 9, $length);
    } else {
        for ($i = 0; $i < $length; $i++) {
            $salt .= mt_rand(0, 9);
        }
    }
    
    return $salt;
}

/**
 * 生成订单号
 */
function build_order_sn()
{
    $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');

    $orderSn = $yCode[intval(date('Y')) - 2015] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));

    return $orderSn;
}