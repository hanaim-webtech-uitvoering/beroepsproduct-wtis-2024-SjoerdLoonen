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

    <nav>
        <input type="checkbox" id="menu-toggle">
        <label for="menu-toggle" class="menu-icon">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </label>
        <ul class="navbar" id="nav-links">
            <li><a href="KlantenHome.html">Home</a></li>
            <li><a href="KlantenMenu.html">Menu</a></li>
            <li><a href="KlantenWinkelmandje.html">Winkelmand</a></li>
            <li><a href="KlantenMijnBestellingen.html">Mijn Bestellingen</a></li>
            <li><a href="../Gebruikers/Index.html">Loguit</a></li>
        </ul>
    </nav>
    <div class="container">
        <h1>Bevestig uw Bestelling</h1>
        <div class="customer-info">
            <h2>Uw Gegevens</h2>
            <form action="KlantenMijnBestellingen.html" method="post">
                <strong>Naam:</strong>
                <p>NaamKlant</p>
                <strong>Straatnaam</strong>
                <p>StraatNaam</p>
                <strong>Stadnaam</strong>
                <p>StadNaam</p>
                <strong>Postcode</strong>
                <p>1111AA</p>
                <div class="order-summary">
                    <h2>Uw Bestelling</h2>
                    <ul class="order-list">
                        <li>Product 1 - €20.00</li>
                        <li>Product 2 - €15.00</li>
                        <li>Product 3 - €30.00</li>
                    </ul>
                    <div class="total">
                        <strong>Totaal: €65.00</strong>
                    </div>
                </div>
                <button type="submit" class="confirm-btn">Bevestig bestelling</button>
            </form>
        </div>
    </div>
    <footer>
        <div class="footer-content">
            <a class="link-style-login" href="KlantenPrivacyVerklaring.html">&copy; 2024 Pizzeria Sole Machina. Alle rechten
                voorbehouden.</a>
            <div class="divider"></div>
            <section id="contact">
                <h2>Contact</h2>
                <p><strong>Adres:</strong> Via Italia 24, 1234 AB, Pizza City</p>
                <p><strong>Telefoon:</strong> +31 123 456 789</p>
                <p><strong>Email:</strong> info@solemachina.nl</p>
            </section>
        </div>
    </footer>
</body>

</html>