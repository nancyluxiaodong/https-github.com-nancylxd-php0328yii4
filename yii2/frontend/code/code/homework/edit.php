<?php

/**
 * 添加功能
 */
require 'DB.class.php';
$db = DB::getInstance(['password' => 'root', 'dbname' => 'news']);

//1.获取请求的id
$id = isset($_GET['id'])?$_GET['id']-0:1;
//2.准备sql语句
$sql = "SELECT * FROM `news` WHERE `id`=$id";
//3.执行
$row = $db->fetchRow($sql);

//判断是否提交
if ($_POST) {
    //准备sql语句
    $title = addslashes($_POST['title']);
    $content = addslashes($_POST['content']);
    $content = nl2br($content);
    $time = time();
    $sql = "UPDATE `news` SET `title`='$title',`content`='$content' WHERE `id`=$id ";
    //执行
    $db->query($sql);

    //需求:在添加的时候将数据保存到html文件夹中,id.html
    $tpl = file_get_contents('show.tpl');
    //替换占位符
    $tpl = str_replace('{%title%}', $title,$tpl);
    $tpl = str_replace('{%content%}',$content, $tpl);
    //保存到文件中
    $path = $row['path'];
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
            <td><input type="text" name="title" class="tle" value="<?php echo $row['title'];?>"/></td>
        </tr>
        <tr>
            <td>内容</td>
            <td><textarea class="txt" name="content"><?php echo $row['content'];?></textarea></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="提交"/></td>
        </tr>
    </table>
</form>
