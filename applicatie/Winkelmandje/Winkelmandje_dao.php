<?php

require_once '/Database/db-connectie.php';

// function haalWinkelmandOp($username) {
//     $db = maakverbinding();
//     $cart_query = 'SELECT P.name as product_name, P.price, OP.quantity 
//                    FROM Pizza_Order O
//                    JOIN Pizza_Order_Product OP ON O.order_id = OP.order_id
//                    JOIN Product P ON OP.product_name = P.name
//                    WHERE O.client_username = :username AND O.status = 0';
    
//     $cart_stmt = $db->prepare($cart_query);
//     $cart_stmt->bindParam(':username', $username);
//     $cart_stmt->execute();

//     $producten = [];
//     $total = 0;

//     while ($row = $cart_stmt->fetch(PDO::FETCH_ASSOC)) {
//         $producten[] = $row;
//         $total += $row['price'] * $row['quantity'];
//     }

//     return ['producten' => $producten, 'total' => $total];
// }

// function updateWinkelmand($username, $product_name, $quantity) {
//     $db = maakverbinding();

//     $update_query = 'UPDATE Pizza_Order_Product
//                      SET quantity = :quantity
//                      WHERE order_id = (SELECT order_id FROM Pizza_Order WHERE client_username = :username AND status = 0)
//                      AND product_name = :product_name';
    
//     $update_stmt = $db->prepare($update_query);
//     $update_stmt->bindParam(':username', $username);
//     $update_stmt->bindParam(':product_name', $product_name);
//     $update_stmt->bindParam(':quantity', $quantity);
//     $update_stmt->execute();
// }

// ?>