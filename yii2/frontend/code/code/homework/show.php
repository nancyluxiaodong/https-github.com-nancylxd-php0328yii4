<?php
require 'DB.class.php';
$db=DB::getInstance(['password'=>'root','dbname'=>'news']);

//1.获取请求的id
$id = isset($_GET['id'])?$_GET['id']-0:1;
//2.准备sql语句
$sql = "SELECT * FROM `news` WHERE `id`=$id";
//3.执行
$row = $db->fetchRow($sql);
//4.展示
?>
<style type="text/css">
    table {
        border-collapse: collapse;
        border: 1px solid black;
    }
    td{
        border: 1px solid black;
        padding: 0 10px;
    }
    .tle{
        width: 80em;
    }
    .txt{
        width: 80em;
        height: 6em;
        resize: none;
    }
</style>
<a href="04index.php">新闻列表</a>
    <table>
        <tr>
            <td>标题</td>
            <td><?php echo $row['title'];?></td>
        </tr>
        <tr>
            <td>内容</td>
            <td><?php echo $row['content'];?></td>
        </tr>
    </table>

