<?php

require_once '../Database/db-connectie.php';

$db = maakverbinding();

$type_query = 'SELECT name FROM ProductType';
$types = $db->query($type_query);

$selected_type = isset($_GET['type_id']) ? $_GET['type_id'] : null;

if ($selected_type) {
    $product_query = 'SELECT P.name as naam, P.price as prijs, PT.name as product_type, STRING_AGG(I.name, \', \') as ingredienten
                      FROM Product P
                      JOIN ProductType PT ON P.type_id = PT.name
                      LEFT JOIN Product_Ingredient PI ON P.name = PI.product_name
                      LEFT JOIN Ingredient I ON PI.ingredient_name = I.name
                      WHERE PT.name = :type_id
                      GROUP BY P.name, P.price, PT.name
                      ORDER BY PT.name';
    $product_stmt = $db->prepare($product_query);
    $product_stmt->bindParam(':type_id', $selected_type);
    $product_stmt->execute();
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

    <?php require_once '../Navbar.php'; ?>

    <main>
        <nav class="navbar">
            <ul>
                <?php
                while ($type_row = $types->fetch(PDO::FETCH_ASSOC)) {
                    $type_name = htmlspecialchars($type_row['name']);
                    echo '<li class="navbar" id="nav-links"><a href="?type_id=' . urlencode($type_name) . '">' . $type_name . '</a></li>';
                }
                ?>
            </ul>
        </nav>

        <section class="menu">
            <?php if ($selected_type): ?>
                <h2><?php echo htmlspecialchars($selected_type); ?></h2>

                <?php
                while ($row = $product_stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<div class="menu-item">';
                    echo '<h3>' . htmlspecialchars($row['naam']) . '</h3>';

                    if (!empty($row['ingredienten'])) {
                        echo '<p>' . htmlspecialchars($row['ingredienten']) . '</p>';
                    }

                    echo '<p class="price">€' . number_format($row['prijs'], 2, ',', '.') . '</p>';
                    echo '<form action="Winkelmandje.php" method="get">';
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