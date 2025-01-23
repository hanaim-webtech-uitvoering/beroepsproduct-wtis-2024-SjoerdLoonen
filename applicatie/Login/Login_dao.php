<?php
require_once '../Database/db-connectie.php';

function haalGebruikerOp($username, $role) {
    $db = maakverbinding();
    $query = "SELECT * FROM [User] WHERE username = :username AND role = :role";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':role', $role);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
