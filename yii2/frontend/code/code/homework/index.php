<?php
//首页静态化工具,用于生成index.html
ob_start();
require 'DB.class.php';
$db=DB::getInstance(['password'=>'root','dbname'=>'news']);

//2.准备sql语句
$sql = "SELECT * FROM `news`";
//3.执行
$rows = $db->fetchAll($sql);
//4.展示
?>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <title>新闻列表</title>
    <style type="text/css">
        table {
            border-collapse: collapse;
            border: 1px solid black;
        }
        th,td{
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
</head>
<body>
    <a href="02add.php">添加新闻</a>
    <table>
        <tr>
            <th>ID</th>
            <th>标题</th>
            <th>内容</th>
            <th>操作</th>
        </tr>
        <?php foreach($rows as $row):?>
        <tr>
            <td><?php echo $row['id'];?></td>
            <td><?php echo $row['title'];?></td>
            <td><?php echo mb_substr($row['content'],0,40,'UTF-8');?></td>
            <td>
                <a href="<?php echo $row['path'].$row['id'].'.html';?>">查看</a>
                <a href="05edit.php?id=<?php echo $row['id'];?>">编辑</a>
            </td>
        </tr>
        <?php endforeach;?>
    </table>
</body>
</html>
<?php
    $content = ob_get_contents();
    file_put_contents('index.html',$content);
    //ob_clean();