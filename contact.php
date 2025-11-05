<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Compteur du panier
$cartCount = 0;
if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    $cartCount = array_sum(array_column($_SESSION['cart'], 'qty'));
}

$message = "";

// Connexion MySQL
$host = "localhost";
$db   = "astrorocket";
$user = "root";
$pass = "";
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Erreur MySQL : " . $conn->connect_error);
}

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom   = htmlspecialchars(trim($_POST['nom'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $msg   = htmlspecialchars(trim($_POST['message'] ?? ''));

    if ($nom === '' || $email === '' || $msg === '') {
        $message = "<p class='error'>❌ Merci de remplir tous les champs.</p>";
    } else {
        $stmt = $conn->prepare("INSERT INTO contact_messages (nom, email, message) VALUES (?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("sss", $nom, $email, $msg);
            if ($stmt->execute()) {
                $message = "<p class='success'>✅ Merci $nom, votre message a bien été envoyé et enregistré !</p>";
            } else {
                $message = "<p class='error'>❌ Erreur : impossible d'enregistrer le message.</p>";
            }
            $stmt->close();
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Contact — AstroShop</title>

<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<style>
  :root {
    --bg1: #0b0f1a;
    --bg2: #1a2333;
    --header: #0f2a4d;
    --accent: #ffdd57;
    --lightblue: #57c7ff;
    --panel: rgba(255,255,255,0.04);
  }

  body {
    margin: 0;
    font-family: 'Roboto', sans-serif;
    background: radial-gradient(circle at top, var(--bg1), var(--bg2));
    color: #f5f5f5;
    overflow-x: hidden;
  }

  body::after {
    content: '';
    position: fixed;
    inset: 0;
    background: url('images/stars.png') repeat;
    opacity: 0.15;
    pointer-events: none;
    animation: starsMove 60s linear infinite;
  }

  @keyframes starsMove {
    from { background-position: 0 0; }
    to { background-position: -9000px 4000px; }
  }

  /* ===== HEADER ===== */
  header {
    background: var(--header);
    padding: 18px 40px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 4px 12px rgba(0,0,0,0.4);
  }

  header h1 a {
    color: var(--accent);
    text-decoration: none;
    font-size: 2rem;
    font-weight: 700;
    letter-spacing: 1px;
    text-shadow: 0 0 8px var(--accent);
  }

  nav {
    display: flex;
    align-items: center;
    gap: 18px;
  }

  nav a {
    color: #f5f5f5;
    text-decoration: none;
    font-weight: 600;
    transition: color .2s ease;
  }

  nav a:hover {
    color: var(--lightblue);
  }

  .cart-link {
    position: relative;
  }

  .cart-badge {
    position: absolute;
    top: -8px;
    right: -12px;
    background: var(--accent);
    color: var(--header);
    padding: 3px 7px;
    border-radius: 50%;
    font-size: 0.75rem;
    font-weight: bold;
  }

  /* ===== MAIN ===== */
  main {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 80vh;
    padding: 20px;
  }

  .contact-container {
    background: var(--panel);
    padding: 30px;
    border-radius: 12px;
    width: 100%;
    max-width: 500px;
    text-align: center;
    box-shadow: 0 10px 40px rgba(0,0,0,0.5);
  }

  .contact-container h2 {
    color: var(--accent);
    margin-bottom: 20px;
  }

  .contact-container form input,
  .contact-container form textarea {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border: none;
    border-radius: 8px;
    background: #13294b;
    color: #f5f5f5;
    font-size: 1rem;
  }

  .contact-container form textarea {
    resize: vertical;
    min-height: 120px;
  }

  .contact-container form button {
    width: 100%;
    padding: 12px;
    margin-top: 12px;
    background: var(--lightblue);
    color: #0f2a4d;
    font-weight: 700;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.2s;
  }

  .contact-container form button:hover {
    background: var(--accent);
    color: #0f2a4d;
  }

  .success {
    color: #57ff8a;
    margin-top: 12px;
    font-weight: bold;
  }

  .error {
    color: #ff6b6b;
    margin-top: 12px;
    font-weight: bold;
  }

  footer {
    text-align: center;
    padding: 30px 0;
    background: var(--header);
    color: #f5f5f5;
    font-size: 0.95em;
  }
</style>
</head>
<body>

<header>
  <h1><a href="index.php">AstroShop</a></h1>
  <nav>
    <a href="index.php">Accueil</a>
    <a href="Produits enfants.php">Produits Enfants</a>
    <a href="Materiel_profesionnel.php">Matériel Pro</a>
    <a href="register.php">Inscription</a>
    <a href="login.php">Connexion</a>
    <a href="contact.php">Contact</a>
    <a href="cart.php" class="cart-link">🛒 Panier
      <?php if ($cartCount > 0): ?>
        <span class="cart-badge"><?= $cartCount ?></span>
      <?php endif; ?>
    </a>
  </nav>
</header>

<main>
  <div class="contact-container">
    <h2>📩 Contactez-nous</h2>
    <form method="post" action="">
      <input type="text" name="nom" placeholder="Votre nom" required>
      <input type="email" name="email" placeholder="Votre email" required>
      <textarea name="message" placeholder="Votre message" required></textarea>
      <button type="submit">Envoyer</button>
    </form>
    <?php if(!empty($message)) echo $message; ?>
  </div>
</main>

<footer>
  &copy; <?= date('Y') ?> AstroShop — Tous droits réservés.
</footer>

</body>
</html>
