<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "lv4_music"
);

if (!$conn) {
    die("Greška pri spajanju na bazu: " . mysqli_connect_error());
}
?>