<?php
include 'includes/auth.php';
include 'includes/db.php';

$userId = $_SESSION['user_id'];
$photo = $_POST['photo'];
$rating = (int)$_POST['rating'];

// validacija
if ($rating < 1 || $rating > 5) {
    die("Neispravna ocjena");
}

// provjera postoji li već ocjena
$stmt = $conn->prepare("
    SELECT id
    FROM ratings
    WHERE user_id = ? AND photo = ?
");

$stmt->bind_param("is", $userId, $photo);
$stmt->execute();

$result = $stmt->get_result();

// AKO POSTOJI → UPDATE
if ($result->num_rows > 0) {

    $update = $conn->prepare("
        UPDATE ratings
        SET rating = ?
        WHERE user_id = ? AND photo = ?
    ");

    $update->bind_param("iis", $rating, $userId, $photo);
    $update->execute();

// AKO NE POSTOJI → INSERT
} else {

    $insert = $conn->prepare("
        INSERT INTO ratings (user_id, photo, rating)
        VALUES (?, ?, ?)
    ");

    $insert->bind_param("isi", $userId, $photo, $rating);
    $insert->execute();
}

header("Location: gallery.php");
exit();
?>