<?php
session_start();
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Style/Style.css">
    <title>Pizzeria Sole Machina Index</title>
</head>

<body>
    <header>
        <h1 class="h1-header">Pizzeria Sole Machina</h1>
        <p class="spin">De beste authentieke pizza's in de stad!</p>
    </header>

    <?php require_once 'Navbar.php' ?>

    <section id="about">
        <h2>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'client'): ?>
                Welkom bij Pizzeria Sole Machina, <?php echo htmlspecialchars($_SESSION['first_name']) . ' ' . htmlspecialchars($_SESSION['last_name']); ?>!
            <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] === 'personnel'): ?>
                Welkom bij Pizzeria Sole Machina, gewaardeerde werknemer!
            <?php else: ?>
                Welkom bij Pizzeria Sole Machina!
            <?php endif; ?>
        </h2>
        <p>Bij ons proef je de smaak van Italië in elke hap! Onze meester-pizzabakkers gebruiken enkel de beste
            ingrediënten om de meest heerlijke en knapperige pizza's te bereiden. Of je nu houdt van een klassieke
            Margherita of een speciale Quattro Stagioni, bij ons ben je aan het juiste adres.</p>
        
        <!-- Show menu button only for clients or non-logged-in users -->
        <?php if (!isset($_SESSION['role']) || $_SESSION['role'] == 'client'): ?>
            <a href="Menu/Menu.php" class="menu-btn">Bekijk ons menu</a>
        <?php endif; ?>
    </section>

    <section id="hours">
        <h2>Openingstijden</h2>
        <ul>
            <li>Maandag - Vrijdag: 12:00 - 22:00</li>
            <li>Zaterdag: 14:00 - 23:00</li>
            <li>Zondag: 14:00 - 21:00</li>
        </ul>
    </section>

    <?php require_once 'Footer.php' ?>

</body>

</html>
