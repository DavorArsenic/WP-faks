<?php
session_start();

include 'includes/db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare(
        "SELECT * FROM users WHERE username = ?"
    );

    $stmt->bind_param("s", $username);

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            header("Location: index.php");
            exit();

        } else {
            $message = "Pogrešna lozinka.";
        }

    } else {
        $message = "Korisnik ne postoji.";
    }
}
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Login</h1>

<form method="POST">

    <input type="text" name="username" placeholder="Korisničko ime">

    <input type="password" name="password" placeholder="Lozinka">

    <button type="submit">Prijava</button>

</form>

<p><?php echo $message; ?></p>

<a href="register.php" class="nav-btn">Registracija</a>

<script src="script.js"></script>
</body>
</html>