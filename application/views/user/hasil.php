<!DOCTYPE html>
<html>
<head>
    <title>Hasil Ujian</title>
    <style>
        body { font-family: Arial; margin: 30px; }
        table { border-collapse: collapse; width: 60%; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
    </style>
</head>
<body>

<h2>Hasil Ujian: <?= $ujian->nama_ujian ?></h2>

<table>
    <tr>
        <th>Jumlah Soal Benar</th>
        <td><?= $hasil->jumlah_benar ?></td>
    </tr>
    <tr>
        <th>Jumlah Soal Salah</th>
        <td><?= $hasil->jumlah_salah ?></td>
    </tr>
    <tr>
        <th>Score</th>
        <td><?= number_format($hasil->score, 2) ?>%</td>
    </tr>
    <tr>
        <th>Tanggal Submit</th>
        <td><?= date('d M Y H:i', strtotime($hasil->tanggal_submit)) ?></td>
    </tr>
</table>

<br>
<a href="<?= site_url('ujian/ranking/'.$ujian->id_ujian) ?>">Lihat Ranking</a> |
<a href="<?= site_url('user') ?>">Kembali ke Dashboard</a>

<script>
    // Hapus timer setelah ujian selesai
    localStorage.removeItem('waktu_ujian_<?= $id_ujian ?>');
</script>

</body>
</html>
