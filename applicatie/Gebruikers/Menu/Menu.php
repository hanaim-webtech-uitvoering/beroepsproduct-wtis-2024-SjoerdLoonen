<?php

require_once 'Menu_dao.php';  // Importeer de functies uit de nieuwe file

$types = haalProductTypesOp();
$selected_type = isset($_GET['type_id']) ? $_GET['type_id'] : null;

if ($selected_type) {
    $producten = haalProductenOp($selected_type);
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Style/Style.css">
    <title>Menukaart - Pizzeria Sole Machina</title>
</head>

<body>
    <header>
        <h1 class="h1-header">Menukaart - Pizzeria Sole Machina</h1>
        <p>Kies uit onze heerlijke pizza's en plaats direct een bestelling!</p>
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
        <li><a href="../Winkelmandje/Winkelmandje.php">Winkelmand</a></li>
        <li><a href="../MijnBestellingen.php">Mijn Bestellingen</a></li>
        <li><a href="../Login.php">Login</a></li>
    </ul>
</nav>

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
                    echo '<form action="../Winkelmandje/Winkelmandje.php" method="post">';
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

    <?php require_once '../../Footer.php'; ?>

</body>
</html>
