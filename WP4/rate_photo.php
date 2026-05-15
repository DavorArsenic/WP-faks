<?php
include 'includes/auth.php';
include 'includes/db.php';

$userId = $_SESSION['user_id'];

$photo = $_POST['photo'];

$rating = (int)$_POST['rating'];

$stmt = $conn->prepare(
    "INSERT INTO ratings(user_id, photo, rating)
     VALUES (?, ?, ?)"
);

$stmt->bind_param("isi", $userId, $photo, $rating);

$stmt->execute();

header("Location: gallery.php");
exit();
?>