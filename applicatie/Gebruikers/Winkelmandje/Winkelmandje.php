<?php
require_once 'Winkelmandje_dao.php';
session_start();

$username = $_SESSION['username']; 
$order = haalWinkelmandOp($username);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = $_POST['product_name'];
    $quantity = $_POST['quantity'];

    updateWinkelmand($username, $product_name, $quantity);
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winkelmandje</title>
    <link rel="stylesheet" href="../../Style/Style.css">
</head>

<body>

    <header>
        <h1 class="h1-header">Winkelmandje</h1>
        <p>Bekijk je winkelmandje en pas de hoeveelheden aan.</p>
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
            <li><a href="../Menu/Menu.php">Menu</li>
            <li><a href="#">Winkelmand</a></li>
            <li><a href="MijnBestellingen.html">Mijn Bestellingen</a></li>
            <li><a href="Login.html">Login</a></li>
        </ul>
    </nav>

    <form action="Winkelmandje.php" method="POST">
        <section class="purchase-list">
            <div class="purchase-header">
                <h2>Productnaam</h2>
                <h2>Prijs</h2>
                <h2>Hoeveelheid</h2>
                <h2>Totaal</h2>
            </div>

            <?php foreach ($order['producten'] as $product): ?>
                <div class="purchase-item">
                    <span><?php echo htmlspecialchars($product['product_name']); ?></span>
                    <span>€<?php echo number_format($product['price'], 2, ',', '.'); ?></span>
                    <span>
                        <input type="number" class="quantity-input" name="quantity" value="<?php echo $product['quantity']; ?>" min="1">
                        <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product['product_name']); ?>">
                    </span>
                    <span>€<?php echo number_format($product['price'] * $product['quantity'], 2, ',', '.'); ?></span>
                </div>
            <?php endforeach; ?>

            <div class="purchase-summary">
                <span><strong>Totaal:</strong></span>
                <span>€<?php echo number_format($order['total'], 2, ',', '.'); ?></span>
            </div>

            <button type="submit" class="complete-purchase-btn">Bestelling Afronden</button>
        </section>
    </form>

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