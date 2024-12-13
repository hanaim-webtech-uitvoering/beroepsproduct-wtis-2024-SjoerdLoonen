<?php

require_once '../../Database/db-connectie.php';

// Haal het winkelmandje op voor de gebruiker op basis van de gebruikersnaam
function haalWinkelmandOp($username) {
    $db = maakverbinding();
    $cart_query = 'SELECT P.name as product_name, P.price, OP.quantity 
                   FROM Pizza_Order O
                   JOIN Pizza_Order_Product OP ON O.order_id = OP.order_id
                   JOIN Product P ON OP.product_name = P.name
                   WHERE O.client_username = :username AND O.status = 0';  // Status 0 = Winkelmandje open
    
    $cart_stmt = $db->prepare($cart_query);
    $cart_stmt->bindParam(':username', $username);
    $cart_stmt->execute();

    $producten = [];
    $total = 0;

    while ($row = $cart_stmt->fetch(PDO::FETCH_ASSOC)) {
        $producten[] = $row;
        $total += $row['price'] * $row['quantity'];
    }

    return ['producten' => $producten, 'total' => $total];
}

// Update de hoeveelheid van een product in het winkelmandje
function updateWinkelmand($username, $product_name, $quantity) {
    $db = maakverbinding();

    // Update de hoeveelheid van een product in de pizza_order_product-tabel
    $update_query = 'UPDATE Pizza_Order_Product
                     SET quantity = :quantity
                     WHERE order_id = (SELECT order_id FROM Pizza_Order WHERE client_username = :username AND status = 0)
                     AND product_name = :product_name';
    
    $update_stmt = $db->prepare($update_query);
    $update_stmt->bindParam(':username', $username);
    $update_stmt->bindParam(':product_name', $product_name);
    $update_stmt->bindParam(':quantity', $quantity);
    $update_stmt->execute();
}

?>
