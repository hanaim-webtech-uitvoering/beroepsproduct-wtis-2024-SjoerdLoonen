<?php
require_once '../Database/db-connectie.php';

function checkUsernameExists($username) {
    try {
        $db = maakverbinding();
        $query = "SELECT * FROM [User] WHERE username = :username";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
        throw new Exception("Fout bij het controleren van de gebruikersnaam: " . $e->getMessage());
    }
}

function registerUser($username, $hashedPassword, $firstname, $lastname, $fullAddress) {
    try {
        $db = maakverbinding();
        $insertQuery = "
            INSERT INTO [User] (username, password, first_name, last_name, address, role) 
            VALUES (:username, :password, :firstname, :lastname, :address, 'Client')
        ";
        $query = $db->prepare($insertQuery);
        $query->bindParam(':username', $username);
        $query->bindParam(':password', $hashedPassword);
        $query->bindParam(':firstname', $firstname);
        $query->bindParam(':lastname', $lastname);
        $query->bindParam(':address', $fullAddress);
        $query->execute();
    } catch (PDOException $e) {
        throw new Exception("Fout bij het registreren: " . $e->getMessage());
    }
}
?>