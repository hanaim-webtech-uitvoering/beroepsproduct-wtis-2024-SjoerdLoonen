<?php
session_start();

$isLoggedIn = isset($_SESSION['user']);

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

if ($isLoggedIn) {
    $user = $_SESSION['user'];
} else {
    $user = ['name' => '', 'address' => '', 'city' => '', 'postal_code' => ''];
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bestelling Bevestigen</title>
    <link rel="stylesheet" href="Style/Style.css">
</head>

<body>
    <header>
        <h1 class="h1-header">Bevestig uw bestelling</h1>
        <p>Bevestig uw bestelling en dan zijn wij zo snel mogelijk bij u!</p>
    </header>

    <?php require_once '../Navbar.php' ?>

    <div class="container">
        <h1>Bevestig uw Bestelling</h1>
        <div class="customer-info">
            <h2>Uw Gegevens</h2>
            <form action="MijnBestellingen.php" method="post">
                <label for="name">Naam:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" placeholder="Bijv. Henk" pattern="[a-zA-Z\s]+" required <?php echo $isLoggedIn ? 'readonly' : ''; ?>>

                <label for="address">Straatnaam:</label>
                <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" placeholder="Bijv. Johanstraat" pattern="[a-zA-Z\s]+" required <?php echo $isLoggedIn ? 'readonly' : ''; ?>>

                <label for="city">Stad:</label>
                <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($user['city']); ?>" placeholder="Bijv. Amsterdam" pattern="[a-zA-Z\s]+" required <?php echo $isLoggedIn ? 'readonly' : ''; ?>>

                <label for="postal-code">Postcode:</label>
                <input type="text" id="postal-code" name="postal-code" value="<?php echo htmlspecialchars($user['postal_code']); ?>" placeholder="Bijv. 1111AA" pattern="^[0-9]{4}[A-Z]{2}$" title="Voer een geldige postcode in (bijv. 1234AB)" required <?php echo $isLoggedIn ? 'readonly' : ''; ?>>

                <div class="order-summary">
                    <h2>Uw Bestelling</h2>
                    <ul class="order-list">
                        <?php if (!empty($order)): ?>
                            <?php foreach ($order as $product): ?>
                                <li><?php echo htmlspecialchars($product['name']); ?> - €<?php echo number_format($product['price'], 2, ',', '.'); ?> x <?php echo $product['quantity']; ?></li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li>Uw winkelmandje is leeg.</li>
                        <?php endif; ?>
                    </ul>

                    <div class="total">
                        <strong>Totaal: €<?php echo number_format($total, 2, ',', '.'); ?></strong>
                    </div>
                </div>
                
                <?php if (!empty($order)): ?>
                    <button type="submit" class="confirm-btn">Bevestig bestelling</button>
                <?php else: ?>
                    <p>Voeg eerst producten toe aan uw winkelmandje voordat u een bestelling kunt plaatsen.</p>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <?php require_once '../Footer.php' ?>

</body>

</html>
