<?php

/** 
 * @link http://blog.kunx.org/.
 * @copyright Copyright (c) 2017-7-5 
 * @license kunx-edu@qq.com.
 */
ob_start();
//echo '<pre>';
//var_dump($_SERVER);
//获取路径信息PATH_INFO
if(empty($_SERVER['PATH_INFO'])){
    echo '未找到路径信息,啥也不干!';
    exit;
}
$pathinfo = $_SERVER['PATH_INFO'];
//拆分参数
$pathes = explode('/', $pathinfo);
$path = array_pop($pathes);
$path = explode('.',$path);
//获取到要访问的id
$id = array_shift($path);

//homework/show.php?id=xxx
$url = 'http://localhost/20170705/code/homework/show.php?id=' . $id;
//var_dump($url);
//header('Location: ' .$url);

/**
 * 1.创建一个curl浏览器
 * 2.准备一个url地址
 * 3.发起请求
 * 4.使用响应数据
 */
//$ch = curl_init();
//curl_setopt($ch, CURLOPT_URL, $url);
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//$content = curl_exec($ch);
//curl_close($ch);
//echo $content;

//使用简单的网络请求方式file_get_contents
$content = file_get_contents($url);
echo ($content);

