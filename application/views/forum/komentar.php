<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h2>Komentar Diskusi</h2>

<form action="<?= base_url('forum/tambah_komentar') ?>" method="POST">
    <input type="hidden" name="forum_id" value="<?= $forum_id ?>">
    <textarea name="komentar" required></textarea>
    <button type="submit">Kirim</button>
</form>

<ul>
    <?php foreach ($forum as $komen): ?>
        <li><?= $komen->komentar ?> - <?= $komen->created_at ?></li>
    <?php endforeach; ?>
</ul>

</body>
</html>