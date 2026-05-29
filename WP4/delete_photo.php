<?php
include 'includes/auth.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $photo = basename($_POST['photo']);

    $path = "images/" . $photo;

    if (file_exists($path)) {
        unlink($path);
    }

    header("Location: gallery.php");
    exit();
}
?>