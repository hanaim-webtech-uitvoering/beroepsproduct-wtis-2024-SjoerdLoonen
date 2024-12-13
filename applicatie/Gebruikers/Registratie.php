<?php
require_once '../Database/db-connectie.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $street = trim($_POST['address']);
    $city = trim($_POST['city']);
    $postalCode = trim($_POST['postal-code']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm-password']);

    if ($password !== $confirmPassword) {
        $error_message = "De wachtwoorden komen niet overeen.";
    } else {
        try {
            $db = maakverbinding();

            $query = "SELECT * FROM [User] WHERE username = :username";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $error_message = "De gebruikersnaam bestaat al. Kies een andere.";
            } else {
                // Hash het wachtwoord
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Voeg de nieuwe gebruiker toe aan de database
                $insertQuery = "
                    INSERT INTO [User] (username, password, first_name, last_name, address, role) 
                    VALUES (:username, :password, :firstname, :lastname, :address, 'klant')
                ";
                $stmt = $db->prepare($insertQuery);
                $fullAddress = "$street, $postalCode, $city";  // Voeg volledige adres samen
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':password', $hashedPassword);
                $stmt->bindParam(':firstname', $firstname);
                $stmt->bindParam(':lastname', $lastname);
                $stmt->bindParam(':address', $fullAddress);
                $stmt->execute();

                // Redirect naar de loginpagina na succesvolle registratie
                header('Location: Login.php');
                exit;
            }
        } catch (PDOException $e) {
            echo "Fout bij het registreren: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registratie Pagina</title>
    <link rel="stylesheet" href="../Style/Style.css">
</head>

<body>
    <header>
        <h1 class="h1-header">Registreer</h1>
        <p>Registreer je hier om uw ervaring nog persoonlijker te maken!</p>
    </header>

    <nav>
        <input type="checkbox" id="menu-toggle">
        <label for="menu-toggle" class="menu-icon">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </label>
        <ul class="navbar" id="nav-links">
            <li><a href="Index.html">Home</a></li>
            <li><a href="Menu.html">Menu</a></li>
            <li><a href="Winkelmandje.html">Winkelmand</a></li>
            <li><a href="MijnBestellingen.html">Mijn Bestellingen</a></li>
            <li><a href="Login.html">Login</a></li>
        </ul>
    </nav>

    <div class="login-container">
        <h2>Registreer</h2>
        <?php if (isset($error_message)): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
        <form action="registratie.php" method="post">
            <div class="input-group">
                <label for="firstname">Voornaam:</label>
                <input type="text" id="firstname" name="firstname" placeholder="Bijv. Henk" pattern="[a-zA-Z\s]+" required>
            </div>
            <div class="input-group">
                <label for="lastname">Achternaam:</label>
                <input type="text" id="lastname" name="lastname" placeholder="Bijv. Jansen" pattern="[a-zA-Z\s]+" required>
            </div>
            <div class="input-group">
                <label for="address">Straatnaam:</label>
                <input type="text" id="address" name="address" placeholder="Bijv. Johanstraat" pattern="[a-zA-Z\s]+" required>
            </div>
            <div class="input-group">
                <label for="city">Stad:</label>
                <input type="text" id="city" name="city" placeholder="Bijv. Amsterdam" pattern="[a-zA-Z\s]+" required>
            </div>
            <div class="input-group">
                <label for="postal-code">Postcode:</label>
                <input type="text" id="postal-code" name="postal-code" placeholder="Bijv. 1111AA" pattern="^[0-9]{4}[A-Z]{2}$"
                    title="Voer een geldige postcode in (bijv. 1234AB)" required>
            </div>
            <div class="input-group">
                <label for="username">Gebruikersnaam:</label>
                <small>Minimaal 8 karakters</small>
                <input type="text" id="username" name="username" placeholder="Gebruikersnaam" pattern="[a-zA-Z0-9]{8,}" required>
            </div>
            <div class="input-group">
                <label for="password">Wachtwoord:</label>
                <small>Tussen 8 en 16 karakters</small>
                <input type="password" id="password" name="password" placeholder="Wachtwoord" pattern="[a-zA-Z0-9]{8,16}" required>
            </div>
            <div class="input-group">
                <label for="confirm-password">Bevestig Wachtwoord:</label>
                <small>Tussen 8 en 16 karakters</small>
                <input type="password" id="confirm-password" name="confirm-password" placeholder="Bevestig wachtwoord" pattern="[a-zA-Z0-9]{8,16}"
                    required>
            </div>
            <button type="submit" class="login-btn">Registreren</button>
        </form>
        <p>Al een account? <a class="link-style-login" href="Login.php">Log hier in</a></p>
    </div>

    <footer>
        <div class="footer-content">
            <a class="link-style-login" href="PrivacyVerklaring.html">&copy; 2024 Pizzeria Sole Machina. Alle rechten voorbehouden.</a>
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
