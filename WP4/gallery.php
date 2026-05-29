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

<a href="index.php" class="nav-btn">Natrag</a>

<h2>Učitaj novu sliku</h2>

<form
    action="upload_photo.php"
    method="POST"
    enctype="multipart/form-data"
>

    <input
        type="file"
        name="photo"
        accept="image/png, image/jpeg"
        required
    >

    <button type="submit">
        Upload
    </button>

</form>

<div class="galerija">

<?php foreach($photos as $photo): ?>

    <?php
    $stmt = $conn->prepare("
        SELECT AVG(rating) as avg_rating
        FROM ratings
        WHERE photo = ?
    ");

    $stmt->bind_param("s", $photo);

    $stmt->execute();

    $avgResult = $stmt->get_result()->fetch_assoc();

    $avgRating = round($avgResult['avg_rating'], 1);
    ?>

    <figure class="galerija_slika">

        <a href="#img<?php echo md5($photo); ?>">

            <img
                src="images/<?php echo $photo; ?>"
                alt="<?php echo $photo; ?>"
                loading="lazy"
            >

        </a>

        <form action="rate_photo.php" method="POST">

            <input
                type="hidden"
                name="photo"
                value="<?php echo $photo; ?>"
            >

            <div class="stars">

                <?php for($i = 1; $i <= 5; $i++): ?>

                    <button
                        type="submit"
                        name="rating"
                        value="<?php echo $i; ?>"
                        class="star-btn"
                    >
                        <?php echo str_repeat("★", $i); ?>
                    </button>

                <?php endfor; ?>

            </div>

        </form>

        <p>
            Prosječna ocjena:
            <strong>
                <?php echo $avgRating ?: "Nema ocjena"; ?>
            </strong>
        </p>
        <form action="delete_photo.php" method="POST">

            <input
                type="hidden"
                name="photo"
                value="<?php echo $photo; ?>"
            >

            <button
                type="submit"
                class="delete-btn"
                onclick="return confirm('Obrisati fotografiju?')"
            >
                Obriši sliku
            </button>

        </form>

    </figure>

    <div id="img<?php echo md5($photo); ?>" class="lightbox">

        <a href="#" class="close">
            ×
        </a>

        <img
            src="images/<?php echo $photo; ?>"
            alt="<?php echo $photo; ?>"
        >

    </div>

<?php endforeach; ?>

</div>
<script src="script.js"></script>
</body>
</html>