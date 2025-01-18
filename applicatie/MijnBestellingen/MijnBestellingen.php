<?php
session_start();
require_once 'MijnBestellingen_dao.php';

$isLoggedIn = isset($_SESSION['username']);

if ($isLoggedIn) {
    $username = $_SESSION['username'];
    $orders = haalBestellingenOp($username);
} else {
    $orders = isset($_SESSION['confirmed_orders']) ? $_SESSION['confirmed_orders'] : [];
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mijn Bestellingen</title>
    <link rel="stylesheet" href="../Style/Style.css">
</head>
<body>

<header>
    <h1 class="h1-header">Jouw Bestellingen</h1>
    <p>Hier kun je alle informatie over je geplaatste bestellingen vinden.</p>
</header>

<?php require_once '../Navbar.php' ?>

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
                
                <ul class="order-list">
                    <?php if (!empty($order['product_details'])): ?>
                        <?php
                        $productArray = explode(', ', $order['product_details']);
                        foreach ($productArray as $productDetails):
                            echo "<li>" . htmlspecialchars($productDetails) . "</li>";
                        endforeach;
                        ?>
                    <?php else: ?>
                        <li>Geen producten gevonden.</li>
                    <?php endif; ?>
                </ul>

                <span><?php echo htmlspecialchars($order['datetime']); ?></span>
                <span><?php echo htmlspecialchars($order['status']); ?></span>
                <span><?php echo htmlspecialchars($order['address']); ?></span>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Je hebt nog geen bestellingen geplaatst.</p>
    <?php endif; ?>
</section>

<?php require_once '../Footer.php' ?>

</body>
</html>
