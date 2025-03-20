<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h2>Forum Diskusi</h2>

<form action="<?= base_url('forum/tambah_topik') ?>" method="POST">
    <input type="hidden" name="materi_id" value="<?= $materi_id ?>">
    <input type="text" name="judul" placeholder="Judul diskusi" required>
    <button type="submit">Buat Topik</button>
</form>

<ul>
    <?php foreach ($forums as $forum): ?>
        <li><a href="<?= base_url('forum/komentar/' . $forum->id) ?>"><?= $forum->judul ?></a></li>
    <?php endforeach; ?>
</ul>

</body>
</html>