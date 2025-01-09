<?php
session_start();
require_once 'Login_dao.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if(!preg_match()){

    }

    $user = haalGebruikerOp($username);

    // Use password_verify to check if the entered password matches the hashed password in the database
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['last_name'] = $user['last_name'];
        header('Location: ../MijnBestellingen/MijnBestellingen.php');
        exit;
    } else {
        $error = "Ongeldige gebruikersnaam of wachtwoord!";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pagina</title>
    <link rel="stylesheet" href="../Style/Style.css">
</head>

<body>
    <header>
        <h1 class="h1-header">Login</h1>
        <p>Log hier in om uw ervaring nog persoonlijker te maken!</p>
    </header>

    <?php require_once '../Navbar.php' ?>

    <div class="login-container">
        <h2>Login</h2>

        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form action="Login.php" method="post">
            <div class="input-group">
                <label for="username">Gebruikersnaam:</label>
                <small>Minimaal 8 karakters</small>
                <input type="text" id="username" name="username" placeholder="Gebruikersnaam" pattern="[a-zA-Z0-9]{4,}" required>
            </div>
            <div class="input-group">
                <label for="password">Wachtwoord:</label>
                <small>8 - 16 karakters</small>
                <input type="password" id="password" name="password" placeholder="Wachtwoord" pattern="[a-zA-Z0-9]{8,16}" required>
            </div>
            <button type="submit" class="login-btn">Inloggen</button>
        </form>

        <p>Nog geen account? Registreer <a class="link-style-login" href="../Registratie/Registratie.php">hier</a></p>
        <p>Medewerker? Log dan <a class="link-style-login" href="../Werknemers/WerknemersLogin.html">hier</a> in.</p>
    </div>

    <?php require_once '../Footer.php' ?>

</body>
</html>
