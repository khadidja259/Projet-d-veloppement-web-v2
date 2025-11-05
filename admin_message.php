<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Connexion MySQL
$host = "localhost";
$db = "astrorocket";
$user = "root";
$pass = "";
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Erreur MySQL : " . $conn->connect_error);

// Récupérer tous les messages
$result = $conn->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
$messages = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Admin — Messages Contact</title>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<style>
body {
  margin: 0;
  font-family: 'Roboto', sans-serif;
  background: radial-gradient(#0b0f1a, #1a2333);
  color: #f5f5f5;
}
header {
  background: #0f2a4d;
  display: flex; justify-content: center; padding: 20px;
}
header h1 { color: #ffdd57; }
main { padding: 20px; }
table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}
th, td {
  padding: 12px;
  border-bottom: 1px solid #444;
  text-align: left;
}
th { background: #0f2a4d; color: #ffdd57; }
tr:nth-child(even) { background: rgba(255,255,255,0.05); }
tr:hover { background: rgba(87,199,255,0.2); }
footer { text-align: center; padding: 20px; background: #0f2a4d; color: #f5f5f5; margin-top: 40px; }
</style>
</head>
<body>

<header>
  <h1>📩 Messages Contact - Admin</h1>
</header>

<main>
<?php if(count($messages) > 0): ?>
<table>
  <tr>
    <th>ID</th>
    <th>Nom</th>
    <th>Email</th>
    <th>Message</th>
    <th>Reçu le</th>
  </tr>
  <?php foreach($messages as $msg): ?>
  <tr>
    <td><?= htmlspecialchars($msg['id']) ?></td>
    <td><?= htmlspecialchars($msg['nom']) ?></td>
    <td><?= htmlspecialchars($msg['email']) ?></td>
    <td><?= nl2br(htmlspecialchars($msg['message'])) ?></td>
    <td><?= $msg['created_at'] ?></td>
  </tr>
  <?php endforeach; ?>
</table>
<?php else: ?>
<p>Aucun message reçu pour le moment.</p>
<?php endif; ?>
</main>

<footer>
  &copy; 2025 AstroRocket - Tous droits réservés
</footer>

</body>
</html>
