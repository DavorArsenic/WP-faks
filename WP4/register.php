<?php
include 'includes/db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $message = "Sva polja su obavezna.";
    } else {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare(
            "INSERT INTO users(username, password) VALUES (?, ?)"
        );

        $stmt->bind_param("ss", $username, $hashedPassword);

        if ($stmt->execute()) {
            $message = "Registracija uspješna.";
        } else {
            $message = "Korisničko ime već postoji.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Registracija</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Registracija</h1>

<form method="POST">

    <input type="text" name="username" placeholder="Korisničko ime">

    <input type="password" name="password" placeholder="Lozinka">

    <button type="submit">Registriraj se</button>

</form>

<p><?php echo $message; ?></p>

<a href="login.php" class="nav-btn">Login</a>
<script src="script.js"></script>
</body>
</html>