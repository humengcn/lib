<?php

/**
 * 隐藏手机号码中间4位
 */
function hidePhone($phone)
{
    return substr_replace($phone, '****', 3, 4);
}