<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_POST['add_to_cart'])) {
    $id    = (int)$_POST['id'];
    $name  = $_POST['name'];
    $price = (float)$_POST['price'];
    $img   = $_POST['img'];

    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] === $id) {
            $item['qty']++;
            $found = true;
            break;
        }
    }
    unset($item);

    if (!$found) {
        $_SESSION['cart'][] = [
            "id" => $id,
            "name" => $name,
            "price" => $price,
            "img" => $img,
            "qty" => 1
        ];
    }

    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}

if (isset($_POST['remove'])) {
    $id = $_POST['id'];
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $id) {
            unset($_SESSION['cart'][$key]);
        }
    }
    $_SESSION['cart'] = array_values($_SESSION['cart']);
}

if (isset($_POST['clear'])) {
    $_SESSION['cart'] = [];
}

if (isset($_POST['update_qty'])) {
    $id = (int)$_POST['id'];
    $qty = (int)$_POST['qty'];
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] === $id) {
            $item['qty'] = max(1, $qty);
            break;
        }
    }
    unset($item);
}

$cartCount = array_sum(array_column($_SESSION['cart'], 'qty'));
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Mon Panier — AstroShop</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <style>
  body {
    margin: 0;
    font-family: 'Roboto', sans-serif;
    background: radial-gradient(#0b0f1a, #1a2333);
    color: #f5f5f5;
  }
  body::after {
    content: '';
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: url('images/stars.png') repeat;
    opacity: 0.15;
    pointer-events: none;
    animation: starsMove 60s linear infinite;
  }
  @keyframes starsMove {
    from { background-position: 0 0; }
    to { background-position: -8000px 4000px; }
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
    font-size: 2em;
    margin: 0;
    font-weight: 700;
    text-transform: uppercase;
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
    font-weight: 500;
    transition: 0.3s;
    font-size: 1rem;
  }
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
    padding: 50px 5%;
    text-align: center;
  }
  h2 {
    color: #ffdd57;
    margin-bottom: 30px;
  }
  table.cart-table {
    width: 100%;
    max-width: 900px;
    margin: 0 auto;
    border-collapse: collapse;
    background: rgba(255,255,255,0.05);
    border-radius: 10px;
    overflow: hidden;
  }
  .cart-table th, .cart-table td {
    padding: 15px;
    border-bottom: 1px solid rgba(255,255,255,0.1);
  }
  .cart-table th {
    background: rgba(255,255,255,0.08);
  }
  .cart-table img {
    width: 60px;
    border-radius: 10px;
    margin-right: 10px;
  }
  .cart-table td {
    vertical-align: middle;
  }
  .cart-table form button {
    background: #ff6b6b;
    border: none;
    padding: 8px 15px;
    color: white;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.3s;
  }
  .cart-table form button:hover {
    background: #ffdd57;
    color: #0f2a4d;
  }
  .total-section {
    margin-top: 30px;
    font-size: 1.2em;
    font-weight: 600;
  }
  .actions {
    margin-top: 25px;
  }
  .actions button {
    background: #57c7ff;
    color: #0f2a4d;
    border: none;
    padding: 12px 25px;
    border-radius: 8px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
    margin: 5px;
  }
  .actions button:hover {
    background: #ffdd57;
    color: #0f2a4d;
  }
  footer {
    text-align: center;
    padding: 25px;
    background: #0f2a4d;
    color: #f5f5f5;
    font-size: 0.9em;
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
    <a href="cart.php" class="cart-link">🛒 Panier
      <?php if($cartCount > 0): ?>
        <span class="cart-badge"><?= $cartCount ?></span>
      <?php endif; ?>
    </a>
  </nav>
</header>

<main>
  <h2>🛒 Votre Panier</h2>

  <?php if (empty($_SESSION['cart'])): ?>
    <p>Votre panier est vide pour le moment.</p>
  <?php else: ?>
    <table class="cart-table">
      <thead>
        <tr>
          <th>Produit</th>
          <th>Prix</th>
          <th>Quantité</th>
          <th>Sous-total</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php $total = 0; ?>
        <?php foreach ($_SESSION['cart'] as $item): ?>
          <?php $subtotal = $item['price'] * $item['qty']; ?>
          <?php $total += $subtotal; ?>
          <tr>
            <td style="display:flex; align-items:center; justify-content:center;">
              <img src="<?= htmlspecialchars($item['img']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
              <?= htmlspecialchars($item['name']) ?>
            </td>
            <td><?= number_format($item['price'], 2) ?> €</td>
            <td>
              <form method="post" action="cart.php" style="display:flex; justify-content:center; align-items:center;">
                <input type="hidden" name="id" value="<?= $item['id'] ?>">
                <input type="number" name="qty" value="<?= $item['qty'] ?>" min="1" style="width:60px; text-align:center; margin-right:8px;">
                <button type="submit" name="update_qty">🔁</button>
              </form>
            </td>
            <td><?= number_format($subtotal, 2) ?> €</td>
            <td>
              <form method="post" action="cart.php">
                <input type="hidden" name="id" value="<?= $item['id'] ?>">
                <button type="submit" name="remove">❌ Supprimer</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <div class="total-section">
      <p>Total : <?= number_format($total, 2) ?> €</p>
    </div>

    <div class="actions">
      <form method="post" action="cart.php" style="display:inline;">
        <button type="submit" name="clear">🗑️ Vider le panier</button>
      </form>
      <a href="Produits enfants.php"><button>⬅️ Continuer mes achats</button></a>
      <?php if (isset($_SESSION['user_id'])): ?>
        <a href="checkout.php"><button>✅ Commander</button></a>
      <?php else: ?>
        <a href="login.php"><button>🔐 Connectez-vous pour commander</button></a>
      <?php endif; ?>
    </div>
  <?php endif; ?>
</main>

<footer>
  &copy; 2025 AstroRocket — Tous droits réservés.
</footer>

</body>
</html>
