<?php
require_once '../../Database/db-connectie.php';

function haalGebruikerOp($username) {
    $db = maakverbinding();
    $query = "SELECT * FROM [User] WHERE username = :username";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
