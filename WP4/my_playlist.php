<?php
include 'includes/auth.php';
include 'includes/db.php';

$userId = $_SESSION['user_id'];

$stmt = $conn->prepare(
    "SELECT songs.*
     FROM playlist
     JOIN songs ON playlist.song_id = songs.id
     WHERE playlist.user_id = ?"
);

$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Moja Playlista</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<h1>Moja Playlista</h1>

<table border="1">

<tr>
    <th>Naslov</th>
    <th>Izvođač</th>
    <th>Akcija</th>
</tr>

<?php while($song = $result->fetch_assoc()): ?>
<tr>

    <td><?php echo $song['naslov']; ?></td>
    <td><?php echo $song['izvodac']; ?></td>

    <td>
        <form method="POST" action="remove_from_playlist.php">
            <input type="hidden" name="song_id" value="<?php echo $song['id']; ?>">
            <button type="submit">Ukloni</button>
        </form>
    </td>

</tr>
<?php endwhile; ?>

</table>

<br>
<a href="index.php" class="nav-btn">Natrag</a>

</body>
</html>