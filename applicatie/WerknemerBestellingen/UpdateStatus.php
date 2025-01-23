<?php
session_start();
require_once '../Database/db-Connectie.php';
require_once 'WerknemerBestellingen_dao.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'personnel') {
    header('Location: /Login/Login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['status'];
    
    updateOrderStatus($verbinding, $order_id, $new_status);
    
    header('Location: WerknemerBestellingen.php');
    exit();
}
?>
