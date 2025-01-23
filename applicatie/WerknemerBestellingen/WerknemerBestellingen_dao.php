<?php

function getOrdersByPersonnel($verbinding, $personnel_username) {
    $sql = "
        SELECT PO.order_id, PO.client_name, PO.datetime, PO.status, PO.address, P.name AS product_name 
        FROM Pizza_Order PO
        JOIN Pizza_Order_Product POP ON PO.order_id = POP.order_id
        JOIN Product P ON POP.product_name = P.name
        WHERE PO.personnel_username = :personnel_username
        ORDER BY PO.datetime DESC
    ";

    $stmt = $verbinding->prepare($sql);
    $stmt->bindParam(':personnel_username', $personnel_username, PDO::PARAM_STR);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function updateOrderStatus($verbinding, $order_id, $new_status) {
    $sql = "UPDATE Pizza_Order SET status = :new_status WHERE order_id = :order_id";
    
    $stmt = $verbinding->prepare($sql);
    $stmt->bindParam(':new_status', $new_status, PDO::PARAM_INT);
    $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    $stmt->execute();
}

?>
