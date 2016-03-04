<?php

/**
 * 常用正则
 */
function regex($args)
{
	/**
	 * 正整数
	 */
	if(preg_match('/^[1-9]\d*$/', $args)){
		return true;
	}
	/**
	 * 长度在6~18之间，只能包含字母、数字和下划线
	 */
	if(preg_match('/^[\w]{6,18}$/', $args)){
		return true;
	}

	/**
	 * 手机号码
	 */
	if(preg_match("/1[34578]{1}\d{9}$/", $args)){
		return true;
	}

	/**
	 * 邮箱
	 */
	if(preg_match('/.+@.+\.[a-zA-Z]{2,4}$/', $args)){
		return true;
	}

	/**
	 * 邮箱
	 */
	if(preg_match("/^[0-9a-zA-Z]+@(([0-9a-zA-Z]+)[.])+[a-z]{2,4}$/i", $args)){
		return true;
	}

	/**
	 * 身份证号码
	 */
	if(preg_match('/^[1-9]([0-9]{14}|[0-9]{17}|([0-9]{16}[xX]))$/i', $args)){
		return true;
	}


}