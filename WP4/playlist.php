<?php
include 'includes/auth.php';
include 'includes/db.php';

$userId = $_SESSION['user_id'];
$songId = (int)$_POST['song_id'];

// provjera postoji li već pjesma
$check = $conn->prepare("
    SELECT id
    FROM playlist
    WHERE user_id = ? AND song_id = ?
");

$check->bind_param("ii", $userId, $songId);
$check->execute();

$result = $check->get_result();

if ($result->num_rows > 0) {

    echo "duplicate";

} else {

    $stmt = $conn->prepare("
        INSERT INTO playlist(user_id, song_id)
        VALUES (?, ?)
    ");

    $stmt->bind_param("ii", $userId, $songId);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }
}
?>