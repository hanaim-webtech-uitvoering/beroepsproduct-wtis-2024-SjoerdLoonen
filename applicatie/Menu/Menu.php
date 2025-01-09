<?php
require_once 'Menu_dao.php';  // Importeer de functies uit de nieuwe file

session_start();  // Start de sessie

$types = haalProductTypesOp();
$selected_type = isset($_GET['type_id']) ? $_GET['type_id'] : null;

if ($selected_type) {
    $producten = haalProductenOp($selected_type);
}

// Voeg geselecteerd product toe aan de winkelmand (sessie) als de knop is ingedrukt
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];

    // Controleer of het product al in de winkelmand zit
    if (!isset($_SESSION['winkelmand'][$product_name])) {
        $_SESSION['winkelmand'][$product_name] = [
            'name' => $product_name,
            'price' => $price,
            'quantity' => 1
        ];
    } else {
        // Verhoog de hoeveelheid als het product al in de winkelmand zit
        $_SESSION['winkelmand'][$product_name]['quantity']++;
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Style/Style.css">
    <title>Menukaart - Pizzeria Sole Machina</title>
</head>
<body>
    <header>
        <h1 class="h1-header">Menukaart - Pizzeria Sole Machina</h1>
        <p>Kies uit onze heerlijke pizza's en plaats direct een bestelling!</p>
    </header>

    <?php require_once '../Navbar.php' ?>
    
    <main>
        <nav class="navbar">
            <ul>
                <?php
                while ($type_row = $types->fetch(PDO::FETCH_ASSOC)) {
                    $type_name = htmlspecialchars($type_row['name']);
                    echo '<li><a href="?type_id=' . urlencode($type_name) . '">' . $type_name . '</a></li>';
                }
                ?>
            </ul>
        </nav>

        <section class="menu">
            <?php if ($selected_type): ?>
                <h2><?php echo htmlspecialchars($selected_type); ?></h2>

                <?php
                while ($row = $producten->fetch(PDO::FETCH_ASSOC)) {
                    echo '<div class="menu-item">';
                    echo '<h3>' . htmlspecialchars($row['naam']) . '</h3>';

                    if (!empty($row['ingredienten'])) {
                        echo '<p>' . htmlspecialchars($row['ingredienten']) . '</p>';
                    }

                    echo '<p class="price">€' . number_format($row['prijs'], 2, ',', '.') . '</p>';
                    echo '<form action="Menu.php" method="post">';
                    echo '<input type="hidden" name="product_name" value="' . htmlspecialchars($row['naam']) . '">';
                    echo '<input type="hidden" name="price" value="' . htmlspecialchars($row['prijs']) . '">';
                    echo '<button class="order-btn">Bestel nu</button>';
                    echo '</form>';
                    echo '</div>';
                }
                ?>
            <?php else: ?>
                <h2>Selecteer een producttype om producten te bekijken</h2>
            <?php endif; ?>
        </section>
    </main>

    <?php require_once '../Footer.php'; ?>

</body>
</html>
