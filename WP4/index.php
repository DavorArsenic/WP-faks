<?php
include 'includes/auth.php';
include 'includes/db.php';

$sql = "SELECT * FROM songs";
$result = mysqli_query($conn, $sql);

$songs = [];

while ($row = mysqli_fetch_assoc($result)) {
    $songs[] = $row;
}
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Popis pjesama</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

<header>
    <h1>Dobrodošao <?php echo $_SESSION['username']; ?></h1>
    <a href="logout.php">Logout</a>
</header>

<main class="grid-layout">

<section>

<h2>Filteri</h2>

<div class="filters">

    <div class="dropdown">
        <button onclick="toggleGenreDropdown()">Žanrovi</button>
        <div id="genre-dropdown" class="dropdown-content"></div>
    </div>

    <div class="dropdown">
        <button onclick="toggleMoodDropdown()">Raspoloženje</button>
        <div id="mood-dropdown" class="dropdown-content"></div>
    </div>

    <label>BPM: <span id="bpm-value">0-220</span></label>
    <input type="range" id="filter-bpm" min="0" max="220" value="220">

    <input type="number" id="filter-year-from" placeholder="Godina od...">
    <input type="number" id="filter-year-to" placeholder="Godina do...">

    <input type="text" id="search" placeholder="Pretraži...">

</div>

<button onclick="dodajOdabrane()">Dodaj u playlistu</button>

<h2>Popis pjesama</h2>

<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Naslov</th>
            <th>Izvođač</th>
            <th>Žanr</th>
            <th>BPM</th>
            <th>Godina</th>
            <th>Popularnost</th>
            <th>Raspoloženje</th>
        </tr>
    </thead>

    <tbody id="songs-table"></tbody>
</table>

</section>



</main>

<a href="my_playlist.php">Moja Playlista</a>
<br>
<a href="gallery.php">Galerija</a>

<div id="toast"></div>

<script>
const svePjesme = <?php echo json_encode($songs); ?>;
</script>

<script src="script.js"></script>

</body>
</html>