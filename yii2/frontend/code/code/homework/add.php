<?php

/**
 * 添加功能
 */
require 'DB.class.php';
$db = DB::getInstance(['password' => 'root', 'dbname' => 'news']);
//判断是否提交
if ($_POST) {
    //准备sql语句
    $title = addslashes($_POST['title']);
    $content = addslashes($_POST['content']);
    $content = nl2br($content);
    $time = time();
    $date = date('Ymd');
    $path =  'html/' .$date.'/';
    $sql = "INSERT INTO `news` (`title`,`content`,`create_time`,`path`) VALUES  ('$title','$content',$time,'$path')";
    //执行
    $db->query($sql);
    //获取id
    $id = $db->get_last_id();
    //需求:在添加的时候将数据保存到html文件夹中,id.html
    $tpl = file_get_contents('show.tpl');
    //替换占位符
    $tpl = str_replace('{%title%}', $title,$tpl);
    $tpl = str_replace('{%content%}',$content, $tpl);
    //保存到文件中
    //将新闻分目录存放
    if(!is_dir($path)){
        mkdir($path);
    }
    $filename = $path . $id . '.html';
    file_put_contents($filename, $tpl);
    header('Location: 04index.php');
}


?>
<style type="text/css">
    .tle {
        width: 80em;
    }

    .txt {
        width: 80em;
        height: 6em;
        resize: none;
    }
</style>
<a href="04index.php">新闻列表</a>
<form action="" method="post">
    <table>
        <tr>
            <td>标题</td>
            <td><input type="text" name="title" class="tle"/></td>
        </tr>
        <tr>
            <td>内容</td>
            <td><textarea class="txt" name="content"></textarea></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="提交"/></td>
        </tr>
    </table>
</form>
