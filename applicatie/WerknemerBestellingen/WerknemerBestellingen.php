<?php
session_start();
require_once '../Database/db-Connectie.php';
require_once 'WerknemerBestellingen_dao.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'personnel') {
    header('Location: /Login/Login.php');
    exit();
}

$personnel_username = $_SESSION['username'];
$orders = getOrdersByPersonnel($verbinding, $personnel_username);
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klant bestellingen</title>
    <link rel="stylesheet" href="../Style/Style.css">
</head>

<body>

    <header>
        <h1 class="h1-header">Klant bestellingen voor <?php echo htmlspecialchars($personnel_username); ?></h1>
        <p>Hier kun je alle informatie over bestellingen van klanten vinden en de status aanpassen.</p>
    </header>
    
    <?php require_once '../Navbar.php' ?>

    <section class="order-list-werknemers">
        <div class="order-header">
            <h2>Order ID</h2>
            <h2>Productnaam</h2>
            <h2>Datum en Tijd</h2>
            <h2>Status aanpassen</h2>
            <h2>Leveradres</h2>
        </div>

        <?php foreach ($orders as $order): ?>
            <div class="order-item">
                <span>#<?php echo htmlspecialchars($order['order_id']); ?></span>
                <span><?php echo htmlspecialchars($order['product_name']); ?></span>
                <span><?php echo htmlspecialchars($order['datetime']); ?></span>
                <span>
                    <form action="UpdateStatus.php" method="post">
                        <select name="status" class="status-dropdown">
                            <option value="1" <?php if ($order['status'] == 1) echo 'selected'; ?>>Besteld</option>
                            <option value="2" <?php if ($order['status'] == 2) echo 'selected'; ?>>In Behandeling</option>
                            <option value="3" <?php if ($order['status'] == 3) echo 'selected'; ?>>Verzonden</option>
                        </select>
                        <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['order_id']); ?>">
                        <button type="submit" class="status-button">Status doorvoeren</button>
                    </form>
                </span>
                <span><?php echo htmlspecialchars($order['address']); ?></span>
            </div>
        <?php endforeach; ?>
    </section>

    <?php require_once '../Footer.php' ?>

</body>

</html>
