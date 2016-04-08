<?php

/**
 * 获取毫秒级别的时间戳
 */
function getMillisecond()
{
	//获取毫秒的时间戳
	$time = explode ( " ", microtime () );
	$time = $time[1] . ($time[0] * 1000);
	$time2 = explode( ".", $time );
	$time = $time2[0];
	return $time;
}

/**
 * 根据出生年月日回返回年龄(周岁)
 */
function getAge($birthday)
{
    $age = date('Y', time()) - date('Y', strtotime($birthday)) - 1; 

    if (date('m', time()) == date('m', strtotime($birthday))){  
      
        if (date('d', time()) > date('d', strtotime($birthday))){  
            $age++;  
        }  
    }elseif (date('m', time()) > date('m', strtotime($birthday))){  
        $age++;  
    }

    return $age;
    ////
    //
    //
}