<?php
include 'includes/auth.php';
include 'includes/db.php';

$userId = $_SESSION['user_id'];

if (!isset($_FILES['photo'])) {
    die("Nema datoteke.");
}

$file = $_FILES['photo'];

$fileName = basename($file['name']);
$fileTmp = $file['tmp_name'];
$fileSize = $file['size'];
$fileError = $file['error'];

// MIME type provjera
$finfo = finfo_open(FILEINFO_MIME_TYPE);

$mime = finfo_file($finfo, $fileTmp);

$allowedMime = [
    'image/jpeg',
    'image/png'
];

if (!in_array($mime, $allowedMime)) {
    die("Datoteka mora biti JPG ili PNG.");
}

// provjera greške
if ($fileError !== 0) {
    die("Greška pri uploadu.");
}

// max 5MB
if ($fileSize > 5 * 1024 * 1024) {
    die("Datoteka je prevelika (max 5MB).");
}

// ekstenzija
$ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

$allowed = ['jpg', 'jpeg', 'png'];

if (!in_array($ext, $allowed)) {
    die("Dozvoljeni su samo JPG i PNG.");
}

// siguran naziv
$newName = uniqid("img_", true) . "." . $ext;

$target = "images/" . $newName;

// spremanje
if (move_uploaded_file($fileTmp, $target)) {

    header("Location: gallery.php");
    exit();

} else {

    die("Greška pri spremanju slike.");
}
?>