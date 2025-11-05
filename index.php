<?php
require_once 'cookie.php'; // Inclure le cookie en haut
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<title>AstroShop - Boutique Astronomie</title>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
<style>
/* ===== GLOBAL ===== */
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
  opacity: 0.2;
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
nav a {
  color: #f5f5f5;
  text-decoration: none;
  margin-left: 25px;
  font-weight: 600;
  position: relative;
  transition: 0.3s;
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

/* ===== HERO ===== */
.hero {
  text-align: center;
  padding: 100px 20px;
  background: linear-gradient(135deg, #1a2a4d, #0b0f1a);
  position: relative;
  overflow: hidden;
}
.hero h2 {
  font-size: 2.8em;
  margin-bottom: 20px;
  color: #ffdd57;
  animation: floatText 5s ease-in-out infinite alternate;
}
.hero p {
  font-size: 1.2em;
  color: #d0e6ff;
  max-width: 600px;
  margin: 0 auto;
}
@keyframes floatText {
  0% { transform: translateY(0); }
  100% { transform: translateY(-15px); }
}

/* ===== AVIS CLIENTS ===== */
.reviews-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 25px;
  margin: 50px 0;
}
.review {
  background: rgba(255,255,255,0.08);
  padding: 25px;
  border-radius: 15px;
  width: 300px;
  box-shadow: 0 5px 20px rgba(0,0,0,0.5);
  position: relative;
  opacity: 0;
  transform: translateY(30px);
  animation: fadeUp 1.5s forwards;
}
.review:nth-child(1) { animation-delay: 0.2s; }
.review:nth-child(2) { animation-delay: 0.5s; }
.review:nth-child(3) { animation-delay: 0.8s; }
.review::before {
  content: "“";
  font-size: 2em;
  position: absolute;
  top: 15px;
  left: 15px;
  color: #57c7ff;
}
.review::after {
  content: "”";
  font-size: 2em;
  position: absolute;
  bottom: 15px;
  right: 15px;
  color: #57c7ff;
}
.review .author { margin-top: 15px; font-weight: bold; color: #ffdd57; }
.review .title { font-size: 0.85em; color: #a0cfff; }
@keyframes fadeUp { to { opacity: 1; transform: translateY(0); } }

/* ===== ANECDOTES ===== */
.facts-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 25px;
  margin-bottom: 60px;
}
.fact {
  background: rgba(0,0,0,0.25);
  border-left: 4px solid #57c7ff;
  padding: 20px;
  border-radius: 12px;
  max-width: 280px;
  min-width: 220px;
  text-align: left;
  box-shadow: 0 6px 18px rgba(0,0,0,0.4);
  transform: translateY(30px);
  opacity: 0;
  animation: rise 1.5s forwards;
}
.fact img {
  width: 70px;
  height: 70px;
  object-fit: cover;
  border-radius: 8px;
  margin-bottom: 12px;
}
.fact:nth-child(1) { animation-delay: 0.2s; }
.fact:nth-child(2) { animation-delay: 0.6s; }
.fact:nth-child(3) { animation-delay: 1s; }
.fact:nth-child(4) { animation-delay: 1.4s; }
.fact:nth-child(5) { animation-delay: 1.8s; }
.fact:nth-child(6) { animation-delay: 2.2s; }
@keyframes rise { to { opacity: 1; transform: translateY(0); } }

/* ===== FORMULAIRES ===== */
form {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin: 40px 0;
}
form input, form textarea {
  width: 100%;
  max-width: 320px;
  padding: 14px;
  margin: 10px 0;
  border-radius: 10px;
  border: none;
  background: rgba(255,255,255,0.1);
  color: #fff;
  font-size: 1em;
}
form button {
  margin-top: 15px;
  padding: 12px 30px;
  border-radius: 10px;
  border: none;
  background: #57c7ff;
  color: #0b0f1a;
  font-weight: bold;
  cursor: pointer;
  transition: 0.3s;
}
form button:hover {
  background: #ffdd57;
  color: #0f2a4d;
  transform: scale(1.05);
  box-shadow: 0 4px 15px rgba(255,221,87,0.6);
}

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

<?php
require_once 'cookie.php';
?>
<p style="text-align:center; font-size:1.2em; margin:20px 0;">
    <?php if($visites == 1): ?>
        Bienvenue sur le site ! C'est votre première visite.
    <?php else: ?>
        Vous avez visité ce site <?= $visites ?> fois.
    <?php endif; ?>
</p>

<header>
  <h1>AstroShop</h1>
  <nav>
    <a href="Produits enfants.php">Produits Enfants</a>
    <a href="Materiel_profesionnel.php">Matériel Pro</a>
    <a href="register.php">Inscription</a>
    <a href="login.php">Connexion</a>
    <a href="contact.php">Contact</a>
    <a href="cart.php">🛒Panier</a>
  </nav>
</header>

<section class="hero">
  <li>Explorez l’univers avec AstroShop</li>
  <p>Découvrez télescopes, instruments scientifiques et accessoires pour tous les passionnés d’astronomie.</p>
</section>

<main>
<h2 style="text-align:center; margin-bottom:30px;">Avis clients</h2>
<div class="reviews-container">
  <div class="review">"Super service et conseils précis."
    <div class="author">Julien Martin</div>
    <div class="title">Amateur d'astronomie</div>
  </div>
  <div class="review">"Ma fille adore son télescope !"
    <div class="author">Sophie Lemoine</div>
    <div class="title">Maman passionnée</div>
  </div>
  <div class="review">"Produits fiables et durables."
    <div class="author">Alexandre Dupuis</div>
    <div class="title">Étudiant en physique</div>
  </div>
</div>

<h2 style="text-align:center; margin-bottom:30px;">Faits scientifiques marquants</h2>
<div class="container">
  <div class="row">
    <div class="col-md-6 fact">
      <img src="images/arn_vaccin.jpg" alt="Vaccin ARN">
      🔬 2020 : Premier vaccin à ARN messager contre le COVID-19.
    </div>
    <div class="col-md-6 fact">
      <img src="images/james_webb.jpg" alt="Télescope James Webb">
      🚀 2021 : Lancement du télescope James Webb.
    </div>
  </div>

  <div class="row">
    <div class="col-md-6 fact">
      ⚛️ 2012 : Découverte du boson de Higgs au CERN.
    </div>
    <div class="col-md-6 fact">
      🌍 2022 : Mission DART dévie un astéroïde.
    </div>
  </div>
</div>
</main>

<footer>
  &copy; 2025 AstroShop - Tous droits réservés
</footer>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
