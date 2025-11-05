<?php
session_start();
include("config.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$id = (int)($_GET['id'] ?? 0);
$message = "";

$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
$stmt->close();

if (!$product) {
    die("Produit introuvable.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $price = (float)$_POST['price'];
    $img = trim($_POST['img']);
    $category = $_POST['category'];

    $stmt = $conn->prepare("UPDATE products SET name=?, price=?, img=?, category=? WHERE id=?");
    $stmt->bind_param("sdssi", $name, $price, $img, $category, $id);
    if ($stmt->execute()) {
        $message = "✅ Produit mis à jour !";
        $product = ['name'=>$name,'price'=>$price,'img'=>$img,'category'=>$category]; 
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
<title>Modifier produit — Admin</title>
</head>
<body>
<h1>Modifier un produit</h1>
<a href="admin.php">⬅️ Retour au tableau</a>
<form method="post">
    <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required><br><br>
    <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>" required><br><br>
    <input type="text" name="img" value="<?= htmlspecialchars($product['img']) ?>"><br><br>
    <select name="category" required>
        <option value="enfants" <?= $product['category']=='enfants'?'selected':'' ?>>Produits enfants</option>
        <option value="materiel" <?= $product['category']=='materiel'?'selected':'' ?>>Matériel professionnel</option>
    </select><br><br>
    <button type="submit">Modifier</button>
</form>
<p><?= $message ?></p>
</body>
</html>
