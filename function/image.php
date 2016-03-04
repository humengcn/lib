<?php

/**
 * 处理多图
 */
function multiPic($name = 'pictures', $path = './pictures/', $prefix = 'pictures_')
{
	$data = array();
	$pictures = $_FILES[$name];
	$pictures_length = count($_FILES[$name]['name']);

	for ($i=0; $i < $pictures_length; $i++) { 
		$data[$i]['name'] = $pictures['name'][$i];
		$data[$i]['type'] = $pictures['type'][$i];
		$data[$i]['tmp_name'] = $pictures['tmp_name'][$i];
		$data[$i]['error'] = $pictures['error'][$i];
		$data[$i]['size'] = $pictures['size'][$i];
	}

	$pic_arr = array();$all_img = '';
	foreach ($data as $key => $value) {
		$_FILES[$name] = $value;
		if (isset($_FILES['pictures']) && $_FILES['pictures']['name']) {
			$pic_name = $prefix . time() . md5(uniqid());
			$now_all_img = $this->fileUpload($name, $pic_name, $path) . '|';
			$all_img .= $now_all_img;
		}
	}
	$new_all_img = substr($all_img, 0, -1);

	return $new_all_img;
}