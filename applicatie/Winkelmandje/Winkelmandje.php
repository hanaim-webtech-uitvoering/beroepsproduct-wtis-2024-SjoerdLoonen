<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['quantity'], $_POST['product_name'])) {
        $newQuantity = (int)$_POST['quantity'];
        $productName = $_POST['product_name'];

        if ($newQuantity > 0 && isset($_SESSION['winkelmand'][$productName])) {
            $_SESSION['winkelmand'][$productName]['quantity'] = $newQuantity;
        }
    }
}

if (isset($_SESSION['winkelmand']) && !empty($_SESSION['winkelmand'])) {
    $order = $_SESSION['winkelmand'];
    $total = 0;

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
    <link rel="stylesheet" href="../Style/Style.css">
</head>

<body>

    <header>
        <h1 class="h1-header">Winkelmandje</h1>
        <p>Bekijk je winkelmandje en pas de hoeveelheden aan.</p>
    </header>

    <?php require_once '../Navbar.php' ?>

    <!-- <form action="../BestellingAfronden.php" method="POST"> -->
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
                    <form method="POST">
                    <span>
                        <input type="number" class="quantity-input" name="quantity" value="<?php echo $product['quantity']; ?>" min="1">
                        <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product['name']); ?>">
                        <button type="submit" class="status-button">Update</button>
                    </span>
                </form>
                    <span>€<?php echo number_format($product['price'] * $product['quantity'], 2, ',', '.'); ?></span>
                </div>
            <?php endforeach; ?>

            <div class="purchase-summary">
                <span><strong>Totaal:</strong></span>
                <span>€<?php echo number_format($total, 2, ',', '.'); ?></span>
            </div>
            <form action="../BestellingAfronden/BestellingAfronden.php" method="POST">
            <button type="submit" class="complete-purchase-btn">Bestelling Afronden</button>
        </section>
    </form>

    <?php require_once '../Footer.php' ?>

</body>
</html>
