<!-- app/Views/images.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Cloud Storage Images</title>
</head>

<body>
    <h1>Daftar Gambar:</h1>
    <ul>
        <?php foreach ($images as $image) : ?>
            <li><img src="<?=  site_url('upload/view?file=' . $image['name']) ?>" alt="<?= $image['name'] ?>"></li>
        <?php endforeach; ?>
    </ul>
</body>

</html>