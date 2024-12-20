<?php
session_start();
require_once 'MijnBestellingen_dao.php';

if (!isset($_SESSION['username'])) {
    header('Location: Login/Login.php');
    exit;
}

$username = $_SESSION['username'];

$orders = haalBestellingenOp($username);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mijn Bestellingen</title>
    <link rel="stylesheet" href="../../Style/Style.css">
</head>
<body>

<header>
    <h1 class="h1-header">Jouw Bestellingen</h1>
    <p>Hier kun je alle informatie over je geplaatste bestellingen vinden.</p>
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
        <li><a href="#">Mijn Bestellingen</a></li>
        <li><a href="Login.html">Login</a></li>
    </ul>
</nav>

<section class="order-list">
    <div class="order-header">
        <h2>Order ID</h2>
        <h2>Producten</h2>
        <h2>Datum en Tijd</h2>
        <h2>Status</h2>
        <h2>Leveradres</h2>
    </div>

    <?php if (count($orders) > 0): ?>
        <?php foreach ($orders as $order): ?>
            <div class="order-item">
                <span><?php echo htmlspecialchars($order['order_id']); ?></span>
                <span><?php echo htmlspecialchars($order['product_details']); ?></span>
                <span><?php echo htmlspecialchars($order['datetime']); ?></span>
                <span><?php echo htmlspecialchars($order['status']); ?></span>
                <span><?php echo htmlspecialchars($order['address']); ?></span>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Je hebt nog geen bestellingen geplaatst.</p>
    <?php endif; ?>
</section>

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
