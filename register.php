<?php
session_start();
include("config.php");

// Compteur du panier
$cartCount = 0;
if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    $cartCount = array_sum(array_column($_SESSION['cart'], 'quantity'));
}

$message = "";

if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Vérification si l’email existe déjà
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $message = "<p class='error'>❌ Cet email est déjà utilisé.</p>";
    } else {
        // Insertion sécurisée
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);

        if ($stmt->execute()) {
            $message = "<p class='success'>✅ Inscription réussie ! Vous pouvez vous connecter.</p>";
        } else {
            $message = "<p class='error'>❌ Erreur : " . $stmt->error . "</p>";
        }

        $stmt->close();
    }
    $check->close();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Inscription — AstroShop</title>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<style>
/* ===== GLOBAL ===== */
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

/* ===== HEADER ===== */
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

/* ===== MAIN REGISTER ===== */
main {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: calc(100vh - 160px);
  padding: 20px;
}
.register-container {
  background: rgba(255,255,255,0.04);
  padding: 30px;
  border-radius: 12px;
  box-shadow: 0 8px 24px rgba(0,0,0,0.45);
  text-align: center;
  width: 100%;
  max-width: 420px;
  animation: fadeIn 1s ease forwards;
}
@keyframes fadeIn { from {opacity:0; transform: translateY(20px);} to {opacity:1; transform:translateY(0);} }
.register-container h2 {
  color: #ffdd57;
  margin-bottom: 20px;
}
.register-container form input {
  width: 100%;
  padding: 12px;
  margin: 10px 0;
  border: none;
  border-radius: 8px;
  background: #1a2a4d;
  color: #f5f5f5;
  font-size: 1rem;
}
.register-container form button {
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
.register-container form button:hover {
  background: #ffdd57;
  color: #0f2a4d;
  box-shadow: 0 8px 20px rgba(255,221,87,0.2);
}
.success { color: #57ff8a; margin-top: 12px; font-weight: bold; }
.error { color: #ff6b6b; margin-top: 12px; font-weight: bold; }

/* ===== FOOTER ===== */
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
    <a href="register.php">Inscription</a>
    <a href="login.php">Connexion</a>
    <a href="contact.php">Contact</a>
    <a href="cart.php" class="cart-link">🛒Panier
      <?php if($cartCount > 0): ?>
        <span class="cart-badge"><?= $cartCount ?></span>
      <?php endif; ?>
    </a>
  </nav>
</header>

<main>
  <div class="register-container">
    <h2>Inscription</h2>
    <form method="post" action="">
        <input type="text" name="username" placeholder="Nom d'utilisateur" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit" name="register">S'inscrire</button>
    </form>
    <?php if(!empty($message)) echo $message; ?>
  </div>
</main>

<footer>
  &copy; 2025 AstroRocket - Tous droits réservés
</footer>

</body>
</html>
