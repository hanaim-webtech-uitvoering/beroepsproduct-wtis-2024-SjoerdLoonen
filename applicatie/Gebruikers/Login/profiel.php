<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: Login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profiel Pagina</title>
    <link rel="stylesheet" href="../../Style/Style.css">
</head>

<body>
    <header>
        <h1 class="h1-header">Welkom, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <p>Hier kunt u uw persoonlijke informatie bekijken.</p>
    </header>
    <nav>
        <ul class="navbar">
            <li><a href="Index.html">Home</a></li>
            <li><a href="Menu.html">Menu</a></li>
            <li><a href="Winkelmandje.html">Winkelmand</a></li>
            <li><a href="MijnBestellingen.html">Mijn Bestellingen</a></li>
            <li><a href="Logout.php">Uitloggen</a></li>
        </ul>
    </nav>

    <div class="profiel-container">
        <h2>Uw Profiel</h2>
        <p><strong>Gebruikersnaam:</strong> <?php echo htmlspecialchars($_SESSION['username']); ?></p>
        <p><strong>Voornaam:</strong> <?php echo htmlspecialchars($_SESSION['first_name']); ?></p>
    </div>

    <footer>
        <div class="footer-content">
            <a class="link-style-login" href="PrivacyVerklaring.html">&copy; 2024 Pizzeria Sole Machina. Alle rechten voorbehouden.</a>
        </div>
    </footer>
</body>

</html>
