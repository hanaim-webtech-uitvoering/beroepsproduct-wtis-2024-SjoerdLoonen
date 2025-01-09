<?php
require_once 'Registratie_dao.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $street = trim($_POST['address']);
    $city = trim($_POST['city']);
    $postalCode = trim($_POST['postal-code']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm-password']);
    
    // Server-side validatie
    if(empty($firstname)) {
        $errors['firstname'] = "Voer een voornaam in.";
    }

    if (!preg_match('/^[a-zA-Z\s]+$/', $firstname)) {
        $errors['firstname'] = "Voer een geldige voornaam in.";
    }
    
    if(empty($lastname)) {
        $errors['lastname'] = "Voer een achternaam in";
    }

    if (!preg_match('/^[a-zA-Z\s]+$/', $lastname)) {
        $errors['lastname'] = "Voer een geldige achternaam in.";
    }

    
    
    if (!preg_match('/^[a-zA-Z\s]+\s\d+[a-zA-Z]?$/', $street)) {
        $errors['address'] = "Voer een geldige straatnaam en huisnummer in.";
    }
    
    if (!preg_match('/^[a-zA-Z\s]+$/', $city)) {
        $errors['city'] = "Voer een geldige stad in.";
    }
    
    if (!preg_match('/^[0-9]{4}[A-Z]{2}$/', $postalCode)) {
        $errors['postal-code'] = "Voer een geldige postcode in (bijv. 1234AB).";
    }
    
    if (!preg_match('/^[a-zA-Z0-9]{8,}$/', $username)) {
        $errors['username'] = "Voer een geldige gebruikersnaam in (minimaal 8 karakters).";
    }
    
    if (!preg_match('/^[a-zA-Z0-9]{8,16}$/', $password)) {
        $errors['password'] = "Voer een geldig wachtwoord in (8 tot 16 karakters).";
    }
    
    if ($password !== $confirmPassword) {
        $errors['confirm-password'] = "De wachtwoorden komen niet overeen.";
    }
    
    // Als er geen fouten zijn, probeer te registreren
    if (empty($errors)) {
        try {
            if (checkUsernameExists($username)) {
                $errors['username'] = "De gebruikersnaam bestaat al. Kies een unieke gebruikersnaam.";
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $fullAddress = "$street, $postalCode, $city";
                registerUser($username, $hashedPassword, $firstname, $lastname, $fullAddress);
                header('Location: ../Login/Login.php');
                exit;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
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

    <?php require_once '../Navbar.php'; ?>

    <div class="login-container">
        <h2>Registreer</h2>
        <?php if (!empty($errors)): ?>
            <ul style="color: red;">
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        
        <form action="registratie.php" method="post">
            <div class="input-group">
                <label for="firstname">Voornaam:</label>
                <input type="text" id="firstname" name="firstname" placeholder="Bijv. Henk" 
                    pattern="[a-zA-Z\s]+" 
                    value="<?php echo htmlspecialchars($firstname ?? ''); ?>" 
                    title="Voer een geldige voornaam in (bijv. Henk)" required>
            </div>
            <div class="input-group">
                <label for="lastname">Achternaam:</label>
                <input type="text" id="lastname" name="lastname" placeholder="Bijv. Janssen" 
                    pattern="[a-zA-Z\s]+" 
                    value="<?php echo htmlspecialchars($lastname ?? ''); ?>"
                    title="Voer een geldige achternaam in (bijv. Janssen)" required>
            </div>
            <div class="input-group">
                <label for="address">Straatnaam + huisnummer:</label>
                <input type="text" id="address" name="address" placeholder="Bijv. Johanstraat 26"
                    pattern="[a-zA-Z\s]+\s\d+[a-zA-Z]?"
                    value="<?php echo htmlspecialchars($street ?? ''); ?>"
                    title="Voer een geldige straatnaam en huisnummer in (bijv. Johanstraat 26 of Korteweg 5a)" required>
            </div>

            <div class="input-group">
                <label for="city">Stad:</label>
                <input type="text" id="city" name="city" placeholder="Bijv. Amsterdam" 
                    pattern="[a-zA-Z\s]+" 
                    value="<?php echo htmlspecialchars($city ?? ''); ?>"
                    title="Voer een geldige stad in (bijv. Amsterdam)" required>
            </div>
            <div class="input-group">
                <label for="postal-code">Postcode:</label>
                <input type="text" id="postal-code" name="postal-code" placeholder="Bijv. 1111AA" 
                    pattern="^[0-9]{4}[A-Z]{2}$"
                    value="<?php echo htmlspecialchars($postalCode ?? ''); ?>"
                    title="Voer een geldige postcode in (bijv. 1234AB)" required>
            </div>
            <div class="input-group">
                <label for="username">Gebruikersnaam:</label>
                <small>Minimaal 8 karakters</small>
                <input type="text" id="username" name="username" placeholder="Gebruikersnaam" 
                    pattern="[a-zA-Z0-9]{8,}"
                    value="<?php echo htmlspecialchars($username ?? ''); ?>"
                    title="Voer een geldige gebruikersnaam in (bijv. HenkJanssen01)" required>
            </div>
            <div class="input-group">
                <label for="password">Wachtwoord:</label>
                <small>Tussen 8 en 16 karakters</small>
                <input type="password" id="password" name="password" placeholder="Wachtwoord" 
                    pattern="[a-zA-Z0-9]{8,16}"
                    title="Voer een geldig wachtwoord in" required>
            </div>
            <div class="input-group">
                <label for="confirm-password">Bevestig Wachtwoord:</label>
                <small>Tussen 8 en 16 karakters</small>
                <input type="password" id="confirm-password" name="confirm-password" placeholder="Bevestig wachtwoord" 
                    pattern="[a-zA-Z0-9]{8,16}"
                    title="Herhaal uw eerder ingevulde wachtwoord" required>
            </div>
            <button type="submit" class="login-btn">Registreren</button>
        </form>
        <p>Al een account? <a class="link-style-login" href="../Login/Login.php">Log hier in</a></p>
    </div>

    <?php require_once '../Footer.php'; ?>

</body>

</html>
