<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_unset();
    session_destroy();
    
    header("Location: " . $_SERVER['DOCUMENT_ROOT'] . "/Index.php");
    exit();
}
?>

<nav>
    <input type="checkbox" id="menu-toggle">
    <label for="menu-toggle" class="menu-icon">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
    </label>
    <ul class="navbar" id="nav-links">
        <li><a href="/Index.php">Home</a></li>
        <li><a href="/Menu/Menu.php">Menu</a></li>
        <li><a href="/Winkelmandje/Winkelmandje.php">Winkelmand</a></li>
        <li><a href="/MijnBestellingen/MijnBestellingen.php">Mijn Bestellingen</a></li>
        <?php if (isset($_SESSION['username'])): ?>
            <li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?action=logout">Loguit</a></li>
        <?php else: ?>
            <li><a href="/Login/Login.php">Login</a></li>
        <?php endif; ?>
    </ul>
</nav>
