<?php

require_once '../../Database/db-connectie.php';

// Haal de producttypes op uit de database
function haalProductTypesOp() {
    $db = maakverbinding();
    $type_query = 'SELECT name FROM ProductType';
    $types = $db->query($type_query);
    return $types;
}

// Haal de producten op op basis van het geselecteerde producttype
function haalProductenOp($selected_type) {
    $db = maakverbinding();

    $product_query = 'SELECT P.name as naam, P.price as prijs, PT.name as product_type, STRING_AGG(I.name, \', \') as ingredienten
                      FROM Product P
                      JOIN ProductType PT ON P.type_id = PT.name
                      LEFT JOIN Product_Ingredient PI ON P.name = PI.product_name
                      LEFT JOIN Ingredient I ON PI.ingredient_name = I.name
                      WHERE PT.name = :type_id
                      GROUP BY P.name, P.price, PT.name
                      ORDER BY PT.name';
    
    $product_stmt = $db->prepare($product_query);
    $product_stmt->bindParam(':type_id', $selected_type);
    $product_stmt->execute();
    
    return $product_stmt;
}
?>
