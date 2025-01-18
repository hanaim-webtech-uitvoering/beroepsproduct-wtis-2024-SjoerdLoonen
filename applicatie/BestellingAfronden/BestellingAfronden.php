<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../Login/login.php");
    exit;
}

require_once 'Bestelling_dao.php';

$user = $_SESSION['username'];

$order = isset($_SESSION['winkelmand']) ? $_SESSION['winkelmand'] : [];
$total = 0;
foreach ($order as $product) {
    $total += $product['price'] * $product['quantity'];
}

$userData = getUserData($user);
$fullName = $userData['full_name'];
$address = $userData['address'];

$personnelUsername = getRandomPersonnelUsername();

?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bestelling Bevestigen</title>
    <link rel="stylesheet" href="../Style/Style.css">
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
            <p><strong>Naam:</strong> <?php echo htmlspecialchars($fullName); ?></p>
            <p><strong>Adres:</strong> <?php echo htmlspecialchars($address); ?></p>

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
                <form action="../MijnBestellingen/MijnBestellingen.php" method="post">
                    <button type="submit" name="bevestig_bestelling" class="confirm-btn">Bevestig bestelling</button>
                </form>
            <?php else: ?>
                <p>Voeg eerst producten toe aan uw winkelmandje voordat u een bestelling kunt plaatsen.</p>
            <?php endif; ?>
        </div>
    </div>

    <?php require_once '../Footer.php' ?>

</body>
</html>
