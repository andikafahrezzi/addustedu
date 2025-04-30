<!DOCTYPE html>
<html>
<head>
    <title>Ranking Ujian</title>
</head>
<body>

<h2>Ranking Ujian: <?= $ujian->nama_ujian ?></h2>

<table border="1" cellpadding="10">
    <tr>
        <th>Ranking</th>
        <th>NIS</th>
        <th>Score</th>
    </tr>

    <?php 
    $no = 1;
    foreach($ranking as $r): ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $r->nis ?></td>
        <td><?= number_format($r->total_score, 2) ?>%</td>
    </tr>
    <?php endforeach; ?>

</table>

<a href="<?= site_url('user') ?>">Kembali ke Dashboard</a>
<style>
   body{
       margin: 500px;
    margin-top: 200px;
   } 
</style>
</body>
</html>
