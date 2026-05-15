<?php
include 'includes/auth.php';
include 'includes/db.php';

$userId = $_SESSION['user_id'];
$songId = $_POST['song_id'];

$stmt = $conn->prepare(
    "INSERT INTO playlist(user_id, song_id)
     VALUES (?, ?)"
);

$stmt->bind_param("ii", $userId, $songId);

if (!$stmt->execute()) {
    echo "Pjesma već postoji u playlisti.";
} else {
    echo "Dodano u playlistu.";
}

echo "<br><a href='index.php'>Nazad</a>";
?>