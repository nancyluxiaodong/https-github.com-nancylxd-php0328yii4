
<table class="table table-border table-condensed">

    <tr>
        <th>ID</th>
        <th>姓名</th>
        <th>年龄</th>
        <th>操作</th>
    </tr>
    <?php Foreach($Users as $user):?>
        <tr>
            <td><?=$user->id?></td><br>
            <td><?=$user->name?></td><br>
            <td><?=$user->age?></td>
            <td></td>
        </tr>
    <?php endforeach;?>
</table>
