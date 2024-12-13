<?php
session_start();
require_once 'Login_dao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = haalGebruikerOp($username);

    if ($user && $password === $user['password']) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['last_name'] = $user['last_name'];
        header('Location: ../MijnBestellingen.php');
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
    <link rel="stylesheet" href="../../Style/Style.css">
</head>

<body>
    <header>
        <h1 class="h1-header">Login</h1>
        <p>Log hier in om uw ervaring nog persoonlijker te maken!</p>
    </header>
    <nav>
        <input type="checkbox" id="menu-toggle">
        <label for="menu-toggle" class="menu-icon">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </label>
        <ul class="navbar" id="nav-links">
            <li><a href="Index.html">Home</a></li>
            <li><a href="Menu.html">Menu</a></li>
            <li><a href="Winkelmandje.html">Winkelmand</a></li>
            <li><a href="MijnBestellingen.html">Mijn Bestellingen</a></li>
            <li><a href="#">Login</a></li>
        </ul>
    </nav>

    <div class="login-container">
        <h2>Login</h2>

        <!-- Toon foutmelding indien login mislukt -->
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

        <p>Nog geen account? Registreer <a class="link-style-login" href="registratie.html">hier</a></p>
        <p>Medewerker? Log dan <a class="link-style-login" href="../Werknemers/WerknemersLogin.html">hier</a> in.</p>
    </div>

    <footer>
        <div class="footer-content">
            <a class="link-style-login" href="PrivacyVerklaring.html">&copy; 2024 Pizzeria Sole Machina. Alle rechten voorbehouden.</a>
            <div class="divider"></div>
            <section id="contact">
                <h2>Contact</h2>
                <p><strong>Adres:</strong> Via Italia 24, 1234 AB, Pizza City</p>
                <p><strong>Telefoon:</strong> +31 123 456 789</p>
                <p><strong>Email:</strong> info@solemachina.nl</p>
            </section>
        </div>
    </footer>
</body>

</html>
