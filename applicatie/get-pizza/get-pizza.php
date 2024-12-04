<?php
    require_once '../Database/db-connectie.php';
    $db = maakverbinding();
    
    // Correct SQL query without GROUP BY
    $query = 'SELECT P.name as naam, P.price as prijs, P.type_id as id
    FROM Products P
    ORDER BY P.name';
    
    $data = $db->query($query);
    
    // Building the HTML table
    $html_table = '<table>';
    $html_table = $html_table . '<tr><th>Id</th><th>Naam</th><th>Aantal stukken</th></tr>';
    
    while ($rij = $data->fetch()) {
        $id = $rij['id'];
        $naam = $rij['naam'];
        $prijs = $rij['prijs'];
        
        $html_table = $html_table . "<tr><td>$id</td><td>$naam</td><td>$prijs</td></tr>";
    }
    
    $html_table = $html_table . "</table>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        table,
        td,
        th {
            padding: 0px 2px 0px 5px;
            border: 1px solid black;
        }
        table {
            border-collapse: collapse;
        }
        td {
            text-align: left;
        }
        td:first-child {
            text-align: right;
        }
        td:last-child {
            text-align: center;
        }
    </style>
    <title>Pizzas</title>
</head>
<body>
    <h1>Pizzas met prijs en id</h1>
    <?php 
    echo ($html_table);
    ?>
</body>
</html>
