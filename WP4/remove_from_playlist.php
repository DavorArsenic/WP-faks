<?php
include 'includes/auth.php';
include 'includes/db.php';

$userId = $_SESSION['user_id'];
$songId = $_POST['song_id'];

$stmt = $conn->prepare(
    "DELETE FROM playlist WHERE user_id=? AND song_id=?"
);

$stmt->bind_param("ii", $userId, $songId);
$stmt->execute();

header("Location: my_playlist.php");
exit();
?>