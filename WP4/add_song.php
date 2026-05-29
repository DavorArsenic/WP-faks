<?php
include 'includes/auth.php';
include 'includes/db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $naslov = trim($_POST['naslov']);
    $izvodac = trim($_POST['izvodac']);
    $zanr = trim($_POST['zanr']);
    $bpm = (int)$_POST['bpm'];
    $godina = (int)$_POST['godina'];
    $raspolozenje = trim($_POST['raspolozenje']);

    // VALIDACIJA
    if (
        empty($naslov) ||
        empty($izvodac) ||
        empty($zanr) ||
        empty($raspolozenje)
    ) {

        $message = "Sva polja su obavezna.";

    } elseif ($bpm < 40 || $bpm > 250) {

        $message = "BPM mora biti između 40 i 250.";

    } elseif ($godina < 1900 || $godina > date("Y")) {

        $message = "Neispravna godina.";

    } else {

        $stmt = $conn->prepare("
            INSERT INTO songs
            (naslov, izvodac, zanr, bpm, godina, raspolozenje)
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "sssiss",
            $naslov,
            $izvodac,
            $zanr,
            $bpm,
            $godina,
            $raspolozenje
        );

        if ($stmt->execute()) {

            $message = "Pjesma uspješno dodana.";

        } else {

            $message = "Greška pri unosu.";

        }
    }
}
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Dodaj pjesmu</title>

    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Dodaj novu pjesmu</h1>

<form method="POST">

    <input
        type="text"
        name="naslov"
        placeholder="Naslov"
        required
    >

    <input
        type="text"
        name="izvodac"
        placeholder="Izvođač"
        required
    >

    <input
        type="text"
        name="zanr"
        placeholder="Žanr"
        required
    >

    <input
        type="number"
        name="bpm"
        placeholder="BPM"
        required
    >

    <input
        type="number"
        name="godina"
        placeholder="Godina"
        required
    >

    <input
        type="text"
        name="raspolozenje"
        placeholder="Raspoloženje"
        required
    >

    <button type="submit">
        Dodaj
    </button>

</form>

<p><?php echo $message; ?></p>

<a href="index.php" class="nav-btn">Natrag</a>

</body>
</html>