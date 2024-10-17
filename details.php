<?php
session_start();
$conn = new mysqli("localhost", "root", "", "gestion_stock3");

if (isset($_GET['id'])) {
    $produit_id = intval($_GET['id']);
    $produit = $conn->query("SELECT * FROM produits WHERE id = $produit_id")->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Produit</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2><?php echo htmlspecialchars($produit['nom']); ?></h2>
    <img src="path/to/image.jpg" alt="<?php echo htmlspecialchars($produit['nom']); ?>" class="img-fluid mb-3">
    <p><?php echo htmlspecialchars($produit['description']); ?></p>
    <p><strong>Prix: <?php echo number_format($produit['prix'], 2, ',', ' ') . ' €'; ?></strong></p>
    <a href="ajouter_au_panier.php?id=<?php echo $produit['id']; ?>" class="btn btn-primary">Ajouter au Panier</a>
    <a href="boutique.php" class="btn btn-secondary">Retour à la Boutique</a>
</div>
</body>
</html>
