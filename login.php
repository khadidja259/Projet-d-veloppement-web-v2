<?php
session_start();
include("config.php");

$cartCount = 0;
if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    $cartCount = array_sum(array_column($_SESSION['cart'], 'quantity'));
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_id'] = $user['id'];
            header("Location: index.php");
            exit;
        } else {
            $message = "<p class='error'>Mot de passe incorrect ❌</p>";
        }
    } else {
        $message = "<p class='error'>Utilisateur non trouvé ❌</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Connexion — AstroShop</title>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<style>
body {
  margin: 0;
  font-family: 'Roboto', sans-serif;
  background: radial-gradient(#0b0f1a, #1a2333);
  color: #f5f5f5;
  overflow-x: hidden;
}
body::after {
  content: '';
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: url('images/stars.png') repeat;
  opacity: 0.18;
  pointer-events: none;
  animation: starsMove 60s linear infinite;
}
@keyframes starsMove { 
  0% { background-position: 0 0; } 
  100% { background-position: -10000px 5000px; } 
}
header {
  background: #0f2a4d;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px 40px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.5);
  position: sticky;
  top: 0;
  z-index: 10;
}
header h1 {
  color: #ffdd57;
  font-size: 2.2em;
  margin: 0;
  animation: glow 2s infinite alternate;
}
@keyframes glow { 
  0% { text-shadow: 0 0 5px #ffdd57; } 
  100% { text-shadow: 0 0 20px #ffdd57; } 
}
nav {
  display: flex;
  align-items: center;
}
nav a {
  color: #f5f5f5;
  text-decoration: none;
  margin-left: 25px;
  font-weight: 600;
  position: relative;
  transition: 0.3s;
  font-size: 1rem;
}
nav a::after {
  content: '';
  position: absolute;
  left: 0; bottom: -5px;
  width: 0%;
  height: 2px;
  background: #57c7ff;
  transition: 0.3s;
}
nav a:hover::after { width: 100%; }
nav a:hover { color: #57c7ff; }
.cart-link { position: relative; }
.cart-badge {
  position: absolute;
  top: -10px; right: -15px;
  background: #ffdd57;
  color: #0f2a4d;
  font-size: 0.75rem;
  font-weight: bold;
  padding: 3px 7px;
  border-radius: 50%;
}
main {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: calc(100vh - 160px);
  padding: 20px;
}
.login-container {
  background: rgba(255,255,255,0.04);
  padding: 30px;
  border-radius: 12px;
  box-shadow: 0 8px 24px rgba(0,0,0,0.45);
  text-align: center;
  width: 100%;
  max-width: 400px;
  animation: fadeIn 1s ease forwards;
}
@keyframes fadeIn { from {opacity:0; transform: translateY(20px);} to {opacity:1; transform:translateY(0);} }
.login-container h2 {
  color: #ffdd57;
  margin-bottom: 20px;
}
.login-container form input {
  width: 100%;
  padding: 12px;
  margin: 10px 0;
  border: none;
  border-radius: 8px;
  background: #1a2a4d;
  color: #f5f5f5;
  font-size: 1rem;
}
.login-container form button {
  width: 100%;
  padding: 12px;
  margin-top: 12px;
  background: #57c7ff;
  color: #0f2a4d;
  font-weight: 700;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: all 0.25s;
}
.login-container form button:hover {
  background: #ffdd57;
  color: #0f2a4d;
  box-shadow: 0 8px 20px rgba(255,221,87,0.2);
}
.success { color: #57ff8a; margin-top: 12px; font-weight: bold; }
.error { color: #ff6b6b; margin-top: 12px; font-weight: bold; }
footer {
  text-align: center;
  padding: 30px 0;
  background: #0f2a4d;
  color: #f5f5f5;
  font-size: 0.95em;
}
</style>
</head>
<body>

<header>
  <h1>AstroShop</h1>
  <nav>
    <a href="index.php">Accueil</a>
    <a href="Produits enfants.php">Produits Enfants</a>
    <a href="Materiel_profesionnel.php">Matériel Pro</a>
    <a href="contact.php">Contact</a>
    <a href="cart.php" class="cart-link">🛒Panier
      <?php if($cartCount > 0): ?>
        <span class="cart-badge"><?= $cartCount ?></span>
      <?php endif; ?>
    </a>

    <?php if(isset($_SESSION['username'])): ?>
        <a href="logout.php">Déconnexion</a>
        <span style="margin-left:10px;color:#ffdd57;font-weight:bold;">
          👋 <?= htmlspecialchars($_SESSION['username']); ?>
        </span>
    <?php else: ?>
        <a href="register.php">Inscription</a>
        <a href="login.php">Connexion</a>
    <?php endif; ?>
  </nav>
</header>

<main>
  <div class="login-container">
    <h2>Connexion</h2>
    <form method="post" action="">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit" name="login">Se connecter</button>
    </form>
    <?php if(!empty($message)) echo $message; ?>
  </div>
</main>

<footer>
  &copy; 2025 AstroShop - Tous droits réservés
</footer>
</body>
</html>
