<?php
session_start();
include("config.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$result = $conn->query("SELECT * FROM products ORDER BY category, id DESC");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Admin — AstroShop</title>
<style>
body { font-family: Arial, sans-serif; padding: 20px; background: #1a2333; color: #fff; }
table { width: 100%; border-collapse: collapse; margin-top: 20px; }
th, td { border: 1px solid #fff; padding: 10px; text-align: left; }
a { color: #FFD700; text-decoration: none; margin-right: 10px; }
a:hover { text-decoration: underline; }
button { padding: 5px 10px; cursor: pointer; }
</style>
</head>
<body>
<h1>Bienvenue Admin <?= htmlspecialchars($_SESSION['username']); ?></h1>
<a href="admin_add_product.php">➕ Ajouter un produit</a>
<a href="logout.php">🔒 Déconnexion</a>

<table>
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Prix</th>
        <th>Catégorie</th>
        <th>Actions</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= number_format($row['price'], 2) ?> €</td>
        <td><?= $row['category'] == 'enfants' ? 'Produits enfants' : 'Matériel professionnel' ?></td>
        <td>
            <a href="admin_edit_product.php?id=<?= $row['id'] ?>">✏️ Modifier</a>
            <a href="admin_delete_product.php?id=<?= $row['id'] ?>" onclick="return confirm('Supprimer ce produit ?')">🗑️ Supprimer</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
</body>
</html>
