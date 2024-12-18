<?php
session_start();  // Start de sessie

// Controleer of er producten in de winkelmand zitten
if (isset($_SESSION['winkelmand']) && !empty($_SESSION['winkelmand'])) {
    $order = $_SESSION['winkelmand'];
    $total = 0;

    // Bereken het totaalbedrag
    foreach ($order as $product) {
        $total += $product['price'] * $product['quantity'];
    }
} else {
    $order = [];
    $total = 0;
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
            <li><a href="../Index.php">Home</a></li>
            <li><a href="../Menu/Menu.php">Menu</a></li>
            <li><a href="#">Winkelmand</a></li>
            <li><a href="../MijnBestellingen.php">Mijn Bestellingen</a></li>
            <li><a href="../Login.php">Login</a></li>
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

            <?php foreach ($order as $product): ?>
                <div class="purchase-item">
                    <span><?php echo htmlspecialchars($product['name']); ?></span>
                    <span>€<?php echo number_format($product['price'], 2, ',', '.'); ?></span>
                    <span>
                        <input type="number" class="quantity-input" name="quantity" value="<?php echo $product['quantity']; ?>" min="1">
                        <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product['name']); ?>">
                    </span>
                    <span>€<?php echo number_format($product['price'] * $product['quantity'], 2, ',', '.'); ?></span>
                </div>
            <?php endforeach; ?>

            <div class="purchase-summary">
                <span><strong>Totaal:</strong></span>
                <span>€<?php echo number_format($total, 2, ',', '.'); ?></span>
            </div>

            <button type="submit" class="complete-purchase-btn">Bestelling Afronden</button>
        </section>
    </form>

    <footer>
        <div class="footer-content">
            <a class="link-style-login" href="PrivacyVerklaring.php">&copy; 2024 Pizzeria Sole Machina. Alle rechten voorbehouden.</a>
            <div class="divider"></div>
            <section>
                <ul class="footer-links">
                    <li><a href="#">Instagram</a></li>
                    <li><a href="#">Facebook</a></li>
                    <li><a href="#">TikTok</a></li>
                </ul>
            </section>
        </div>
    </footer>

</body>
</html>
