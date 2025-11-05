<?php
session_start();
include("config.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $price = (float)$_POST['price'];
    $img = trim($_POST['img']);
    $category = $_POST['category'];

    $stmt = $conn->prepare("INSERT INTO products (name, price, img, category) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sdss", $name, $price, $img, $category);
    if ($stmt->execute()) {
        $message = "✅ Produit ajouté !";
    } else {
        $message = "❌ Erreur : " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Ajouter produit — Admin</title>
</head>
<body>
<h1>Ajouter un produit</h1>
<a href="admin.php">⬅️ Retour au tableau</a>
<form method="post">
    <input type="text" name="name" placeholder="Nom du produit" required><br><br>
    <input type="number" step="0.01" name="price" placeholder="Prix" required><br><br>
    <input type="text" name="img" placeholder="URL image"><br><br>
    <select name="category" required>
        <option value="enfants">Produits enfants</option>
        <option value="materiel">Matériel professionnel</option>
    </select><br><br>
    <button type="submit">Ajouter</button>
</form>
<p><?= $message ?></p>
</body>
</html>
