<?php
require_once '../Database/db-Connectie.php';

function haalBestellingenOp($username) {
    $db = maakverbinding();
    $query = "
        SELECT 
            o.order_id, 
            o.datetime, 
            o.status, 
            o.address, 
            STRING_AGG(CONCAT(op.quantity, 'x ', p.name), ', ') AS product_details
        FROM Pizza_Order o
        JOIN Pizza_Order_Product op ON o.order_id = op.order_id
        JOIN Product p ON op.product_name = p.name
        WHERE o.client_username = :username
        GROUP BY o.order_id, o.datetime, o.status, o.address
        ORDER BY o.datetime DESC";

    $stmt = $db->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
