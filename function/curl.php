<?php

/**
 * 模拟GET请求
 */
function curl_get($url, $data = array(), $header = array()){

    $cu = curl_init();
    curl_setopt($cu, CURLOPT_URL, $url);
    curl_setopt($cu, CURLOPT_RETURNTRANSFER, 1);
    $ret = curl_exec($cu);
    curl_close($cu);
    return $ret;
}

/**
 * 模拟post请求
 * @param $url
 * @param $data
 * @return error or 数据
 */
function curl_post($url, $data = array(), $header = array()){   
    $curl = curl_init(); // 启动一个CURL会话      
    curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址                  
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查      
    // curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); // 从证书中检查SSL加密算法是否存在      
    curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器      
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转      
    curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer      
    curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求      
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包      
    // curl_setopt($curl, CURLOPT_COOKIEFILE, $GLOBALS['cookie_file']); // 读取上面所储存的Cookie信息      
    curl_setopt($curl, CURLOPT_TIMEOUT, 60); // 设置超时限制防止死循环
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);      
    curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容      
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回      
    $tmpInfo = json_decode(curl_exec($curl), true); // 执行操作      
    if (curl_errno($curl)) {      
       echo 'Errno'.curl_error($curl);      
    }      
    curl_close($curl); // 关键CURL会话      
    return $tmpInfo; // 返回数据      
}

/**
 * 以post方式提交xml到对应的接口url
 * 
 * @param string $xml  需要post的xml数据
 * @param string $url  url
 * @param bool $useCert 是否需要证书，默认不需要
 * @param int $second   url执行超时时间，默认30s
 * @throws WxPayException
 */
function postXmlCurl($xml, $url, $useCert = false, $second = 30)
{		
	$ch = curl_init();
	//设置超时
	curl_setopt($ch, CURLOPT_TIMEOUT, $second);
	
	//如果有配置代理这里就设置代理
	if(WxPayConfig::CURL_PROXY_HOST != "0.0.0.0" 
		&& WxPayConfig::CURL_PROXY_PORT != 0){
		curl_setopt($ch,CURLOPT_PROXY, WxPayConfig::CURL_PROXY_HOST);
		curl_setopt($ch,CURLOPT_PROXYPORT, WxPayConfig::CURL_PROXY_PORT);
	}
	curl_setopt($ch,CURLOPT_URL, $url);
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,TRUE);
	curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);//严格校验
	//设置header
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	//要求结果为字符串且输出到屏幕上
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

	if($useCert == true){
		//设置证书
		//使用证书：cert 与 key 分别属于两个.pem文件
		curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
		curl_setopt($ch,CURLOPT_SSLCERT, WxPayConfig::SSLCERT_PATH);
		curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
		curl_setopt($ch,CURLOPT_SSLKEY, WxPayConfig::SSLKEY_PATH);
	}
	//post提交方式
	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
	//运行curl
	$data = curl_exec($ch);
	//返回结果
	if($data){
		curl_close($ch);
		return $data;
	} else { 
		$error = curl_errno($ch);
		curl_close($ch);
		throw new WxPayException("curl出错，错误码:$error");
	}
}