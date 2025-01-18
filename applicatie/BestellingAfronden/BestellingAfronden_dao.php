<?php
session_start();
require_once 'Bestelling_dao.php';

if (!isset($_SESSION['username'])) {
    echo "Je moet ingelogd zijn om een bestelling te bevestigen.";
    exit;
}

$order = isset($_SESSION['winkelmand']) ? $_SESSION['winkelmand'] : [];
if (empty($order)) {
    echo "Je winkelmand is leeg.";
    exit;
}

$user = $_SESSION['username'];
$userData = getUserData($user);
$fullName = $userData['full_name'];
$address = $userData['address'];
$personnelUsername = getRandomPersonnelUsername();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['bevestig_bestelling'])) {
    $newOrderId = placeOrder($user, $fullName, $personnelUsername, $address, $order);

    unset($_SESSION['winkelmand']);
    echo "Bestelling succesvol toegevoegd. Uw winkelmandje is nu leeg.";
}
?>
