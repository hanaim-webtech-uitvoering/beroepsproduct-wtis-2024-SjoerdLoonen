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
        <?php if (isset($_SESSION['username'])): ?>
            <li><a href="index.php">Loguit</a></li>
        <?php else: ?>
            <li><a href="../Login.php">Login</a></li>
        <?php endif; ?>
    </ul>
</nav>
