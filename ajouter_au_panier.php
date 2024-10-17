<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Connexion à la base de données
$conn = new mysqli("localhost", "root", "", "gestion_stock3");

if (isset($_GET['id'])) {
    $produit_id = intval($_GET['id']);
    $produit = $conn->query("SELECT * FROM produits WHERE id = $produit_id")->fetch_assoc();

    if ($produit) {
        if (!isset($_SESSION['panier'])) {
            $_SESSION['panier'] = [];
        }

        if (isset($_SESSION['panier'][$produit_id])) {
            $_SESSION['panier'][$produit_id]['quantite']++;
        } else {
            $_SESSION['panier'][$produit_id] = [
                'nom' => $produit['nom'],
                'quantite' => 1,
                'prix' => $produit['prix'] * 655
            ];
        }

        // Message de succès
        $message = "Le produit a été ajouté au panier avec succès!";
    } else {
        $message = "Produit non trouvé!";
    }
} else {
    $message = "Aucun produit spécifié!";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajout au Panier</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Ajout au Panier</h2>
    <div class="alert alert-success" role="alert">
        <?php echo htmlspecialchars($message); ?>
    </div>
    <a href="boutique.php" class="btn btn-primary">Retour à la Boutique</a>
    <a href="panier.php" class="btn btn-secondary">Voir le Panier</a>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
