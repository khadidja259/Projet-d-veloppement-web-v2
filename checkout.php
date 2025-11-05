<?php
session_start();
include("config.php");

if (!isset($_SESSION['username'], $_SESSION['user_id']) || empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$cart = $_SESSION['cart'];

// Calcul du total
$total = 0;
foreach ($cart as $item) {
    $total += $item['price'] * $item['qty'];
}

// Ici tu peux ajouter l'enregistrement dans une table `orders`
// Exemple simplifié : $conn->query("INSERT INTO orders ...");

// Vider le panier après commande
$_SESSION['cart'] = [];

?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Commande - AstroShop</title>
</head>
<body>
<h2>Merci pour votre commande, <?= htmlspecialchars($_SESSION['username']); ?> !</h2>
<p>Montant total : <?= number_format($total, 2); ?> €</p>
<a href="index.php">Retour à l'accueil</a>
</body>
</html>
