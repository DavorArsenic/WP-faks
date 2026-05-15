<?php
include 'includes/auth.php';
include 'includes/db.php';

$photos = scandir("images");

$photos = array_diff($photos, ['.', '..']);
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Galerija</title>

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style-slike.css">
</head>
<body>

<h1>Galerija slika</h1>

<div class="gallery">

<?php foreach($photos as $photo): ?>

    <div class="photo-card">

        <img
            src="images/<?php echo $photo; ?>"
            width="300"
        >

        <form action="rate_photo.php" method="POST">

            <input
                type="hidden"
                name="photo"
                value="<?php echo $photo; ?>"
            >

            <select name="rating">

                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>

            </select>

            <button type="submit">
                Ocijeni
            </button>

        </form>

    </div>

<?php endforeach; ?>

</div>
<script src="script.js"></script>
</body>
</html>