<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$cartCount = 0;
if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    $cartCount = array_sum(array_column($_SESSION['cart'], 'qty'));
}
?>

<header class="site-header">
    <div class="header-container">
        <h1 class="logo">
            <a href="index.php">Astro<span>Shop</span></a>
        </h1>

        <nav class="main-nav">
            <a href="index.php">Accueil</a>
            <a href="fusee.php">Nos fusées</a>
            <a href="Produits enfants.php">Produits enfants</a>
            <a href="Materiel_profesionnel.php">Matériel professionnel</a>
            <a href="cart.php" class="cart-link">
                🛒 Panier
                <?php if ($cartCount > 0): ?>
                    <span class="cart-badge"><?= $cartCount ?></span>
                <?php endif; ?>
            </a>

            <?php if (isset($_SESSION['username'], $_SESSION['user_id'])): ?>
                <a href="logout.php">Déconnexion</a>
                <a href="delete_account.php" onclick="return confirm('Voulez-vous vraiment supprimer votre compte ?');">Supprimer mon compte</a>
                <span style="margin-left:10px;color:#FFD700;font-weight:bold;">
                    👋 <?= htmlspecialchars($_SESSION['username']); ?>
                </span>
            <?php else: ?>
                <a href="register.php">Inscription</a>
                <a href="login.php">Connexion</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<style>
.site-header {
    background: linear-gradient(90deg, #0a0a23, #1c1c3c);
    color: white;
    padding: 15px 50px;
    font-family: 'Roboto', sans-serif;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.4);
}

.header-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.logo a {
    text-decoration: none;
    font-size: 2rem;
    font-weight: 700;
    color: white;
    letter-spacing: 1px;
}

.logo span {
    color: #FFD700;
}

.main-nav a {
    text-decoration: none;
    color: white;
    margin: 0 15px;
    font-weight: 500;
    font-size: 1.1rem;
    transition: color 0.3s ease, transform 0.2s ease;
}

.main-nav a:hover {
    color: #FFD700;
    transform: scale(1.05);
}

.cart-link {
    position: relative;
}

.cart-badge {
    position: absolute;
    top: -8px;
    right: -12px;
    background-color: #FFD700;
    color: #000;
    font-weight: bold;
    font-size: 0.8rem;
    padding: 2px 6px;
    border-radius: 50%;
    animation: pop 0.3s ease;
}

@keyframes pop {
    0% { transform: scale(0.7); opacity: 0; }
    80% { transform: scale(1.2); opacity: 1; }
    100% { transform: scale(1); }
}
</style>
