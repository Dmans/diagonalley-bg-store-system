<html>
<head>
    <title>今日店鋪無人打卡警示</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<p>目前時間: <?=date("Y-m-d H:i:s") ?></p>
<? if(count($uncheckin_store) > 0 ): ?>
<h2>目前尚無人打卡店鋪</h2>
<table border="1">
    <tr>
        <th>店名</th>
    </tr>
    <? foreach ($uncheckin_store as $key=>$row) : ?>
        <tr>
            <td><?=$row->sto_name ?></td>
        </tr>
    <? endforeach  ?>
</table>
<? endif ?>

<h2>目前已打卡人員</h2>
<? if(isset($chks) and $chks!=NULL): ?>
<table border="1">
    <tr>
        <th>店名</th>
        <th>打卡人</th>
        <th>打卡時間</th>
    </tr>
    <? foreach ($chks as $key=>$row) : ?>
        <tr>
            <td><?=$row->sto_name ?></td>
            <td><?=$row->usr_name ?></td>
            <td><?=$row->chk_in_time ?></td>
        </tr>
    <? endforeach  ?>
</table>
<? else: ?>
<p>目前各店無人打卡!</p>
<? endif ?>
</body>
</html>