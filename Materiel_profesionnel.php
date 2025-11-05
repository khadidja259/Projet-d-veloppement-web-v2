<?php 
session_start();

// Compteur du panier
$cartCount = 0;
if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    $cartCount = array_sum(array_column($_SESSION['cart'], 'quantity'));
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Matériel Professionnel — AstroShop</title>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<style>
/*tout*/
body {
  margin: 0;
  font-family: 'Roboto', sans-serif;
  background: radial-gradient(#0b0f1a, #1a2333);
  color: #f5f5f5;
  overflow-x: hidden;
  position: relative;
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

/*header*/
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

/* Panier avec compteur*/
.cart-link {
  position: relative;
  display: inline-block;
}
.cart-badge {
  position: absolute;
  top: -10px; right: -15px;
  background: #ffdd57;
  color: #0f2a4d;
  font-size: 0.75rem;
  font-weight: bold;
  padding: 3px 7px;
  border-radius: 50%;
  box-shadow: 0 2px 6px rgba(0,0,0,0.4);
}

/* ===== HERO ===== */
.hero {
  text-align: center;
  padding: 48px 20px;
  background: linear-gradient(135deg, #1a2a4d, #0b0f1a);
}

/*main*/
main {
  max-width: 1200px;
  margin: 30px auto;
  padding: 0 20px 60px;
  text-align: center;
}
h2.section-title {
  font-size: 2em;
  color: #ffdd57;
  margin: 18px 0 8px;
}

/*pour la grille des produits*/
.products-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
  gap: 24px;
  margin-top: 26px;
}
.product-card {
  background: rgba(255,255,255,0.03);
  border-radius: 12px;
  padding: 16px;
  text-align: center;
  box-shadow: 0 8px 24px rgba(0,0,0,0.45);
  transform: translateY(20px);
  opacity: 0;
  animation: cardIn 0.9s forwards;
}
.product-card img {
  width: 100%;
  height: 160px;
  object-fit: cover;
  border-radius: 8px;
  border: 2px solid rgba(255,255,255,0.04);
}
.product-card h3 {
  color: #ffdd57;
  font-size: 1.15rem;
  margin: 12px 0 6px;
  font-weight: 700;
}
.product-card .price {
  color: #a8e0ff;
  font-weight: 600;
  margin-bottom: 12px;
}
.product-card form button {
  padding: 10px 16px;
  background: #57c7ff;
  color: #0b0f1a;
  border: none;
  border-radius: 8px;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.25s ease;
}
.product-card form button:hover {
  background: #ffdd57;
  color: #0f2a4d;
  transform: translateY(-3px);
  box-shadow: 0 8px 20px rgba(255,221,87,0.2);
}
@keyframes cardIn { to { transform: translateY(0); opacity: 1; } }

/* ===== FOOTER ===== */
footer {
  text-align: center;
  padding: 30px 0;
  background: #0f2a4d;
  color: #f5f5f5;
  font-size: 0.95em;
  margin-top: 36px;
}
</style>
</head>
<body>

<header>
  <h1>AstroShop</h1>
  <nav>
    <a href="index.php">Accueil</a>
    <a href="Produits enfants.php">Produits Enfants</a>
    <a href="Materiel_professionnel.php">Matériel Pro</a>
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

<section class="hero">
  <h2 style="color:#ffdd57;margin:0 0 6px;font-size:1.6rem;">Matériel Professionnel 🔭</h2>
  <p style="color:#d0e6ff;margin:6px 0 0;">Des instruments haut de gamme pour les passionnés et les astronomes confirmés 🌌</p>
</section>

<main>
  <h2 class="section-title">Notre sélection</h2>

  <div class="products-grid">
    <?php
      $products = [
        ["id"=>101, "name"=>"Télescope Cassegrain Pro 200mm", "price"=>1200, "img"=>"images/telescope_pro.jpg"],
        ["id"=>102, "name"=>"Caméra CCD astrophotographie", "price"=>850, "img"=>"images/camera_ccd.jpg"],
        ["id"=>103, "name"=>"Monture équatoriale motorisée", "price"=>950, "img"=>"images/monture.jpg"],
        ["id"=>104, "name"=>"Spectromètre stellaire", "price"=>1400, "img"=>"images/spectrometre.jpg"],
        ["id"=>105, "name"=>"Lunette apochromatique 120mm", "price"=>1100, "img"=>"images/lunette_pro.jpg"],
        ["id"=>106, "name"=>"Caméra planétaire haute vitesse", "price"=>690, "img"=>"images/camera_planetaire.jpg"],
        ["id"=>107, "name"=>"Filtre solaire professionnel", "price"=>199, "img"=>"images/filtre_solaire.jpg"],
        ["id"=>108, "name"=>"Ordinateur de contrôle Goto", "price"=>500, "img"=>"images/controle_goto.jpg"],
        ["id"=>109, "name"=>"Logiciel astrophotographie avancé", "price"=>300, "img"=>"images/logiciel.jpg"],
        ["id"=>110, "name"=>"Station météo astronomique", "price"=>250, "img"=>"images/meteo.jpg"]
      ];

      foreach ($products as $p) {
        $id = (int)$p['id'];
        $name = htmlspecialchars($p['name'], ENT_QUOTES);
        $price = htmlspecialchars($p['price'], ENT_QUOTES);
        $img = htmlspecialchars($p['img'], ENT_QUOTES);

        echo "<article class='product-card'>
                <img src='{$img}' alt='{$name}'>
                <h3>{$name}</h3>
                <div class='price'>{$price} €</div>
                <form method='post' action='cart.php'>
                  <input type='hidden' name='id' value='{$id}'>
                  <input type='hidden' name='name' value='{$name}'>
                  <input type='hidden' name='price' value='{$price}'>
                  <input type='hidden' name='img' value='{$img}'>
                  <button type='submit' name='add_to_cart'>🛒 Ajouter au panier</button>
                </form>
              </article>";
      }
    ?>
  </div>
</main>

<footer>
  &copy; 2025 AstroRocket - Tous droits réservés
</footer>

</body>
</html>
