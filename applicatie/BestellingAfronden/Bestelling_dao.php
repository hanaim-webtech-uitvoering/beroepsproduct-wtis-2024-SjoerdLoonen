<?php
require_once '../Database/db-Connectie.php';

function getUserData($username) {
    $db = maakVerbinding();
    $query = "SELECT first_name, last_name, address FROM [User] WHERE username = :username";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($userData) {
        $fullName = $userData['first_name'] . " " . $userData['last_name'];
        return ['full_name' => $fullName, 'address' => $userData['address']];
    } else {
        die("Gebruiker niet gevonden.");
    }
}

function getRandomPersonnelUsername() {
    $db = maakVerbinding();
    $query = "SELECT TOP 1 username FROM [User] WHERE role = 'personnel' ORDER BY NEWID()";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $personnelData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($personnelData) {
        return $personnelData['username'];
    } else {
        die("Geen personeelslid gevonden.");
    }
}

function placeOrder($user, $fullName, $personnelUsername, $address, $order) {
    $db = maakVerbinding();
    $status = 1;
    $datetime = date('Y-m-d H:i:s');

    $insertQuery = "INSERT INTO [Pizza_Order] (client_username, client_name, personnel_username, datetime, status, address)
                    VALUES (:client_username, :client_name, :personnel_username, :datetime, :status, :address)";
    $insertStmt = $db->prepare($insertQuery);
    $insertStmt->bindParam(':client_username', $user);
    $insertStmt->bindParam(':client_name', $fullName);
    $insertStmt->bindParam(':personnel_username', $personnelUsername);
    $insertStmt->bindParam(':datetime', $datetime);
    $insertStmt->bindParam(':status', $status);
    $insertStmt->bindParam(':address', $address);

    if (!$insertStmt->execute()) {
        die("Er is een fout opgetreden bij het plaatsen van de bestelling.");
    }

    $newOrderId = $db->lastInsertId();
    foreach ($order as $product) {
        $productName = $product['name'];
        $productQuantity = $product['quantity'];

        $insertProductQuery = "INSERT INTO [Pizza_Order_Product] (order_id, product_name, quantity)
                               VALUES (:order_id, :product_name, :quantity)";
        $insertProductStmt = $db->prepare($insertProductQuery);
        $insertProductStmt->bindParam(':order_id', $newOrderId);
        $insertProductStmt->bindParam(':product_name', $productName);
        $insertProductStmt->bindParam(':quantity', $productQuantity);

        if (!$insertProductStmt->execute()) {
            die("Er is een fout opgetreden bij het opslaan van de producten.");
        }
    }

    return $newOrderId;
}
?>
