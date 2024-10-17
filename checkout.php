<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['panier']) || empty($_SESSION['panier'])) {
    header("Location: boutique.php?message=Votre panier est vide.");
    exit();
}

$total = 0;

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Checkout</h2>

    <h4>Votre Panier</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nom du Produit</th>
                <th>Quantité</th>
                <th>Prix Unitaire (FCFA)</th>
                <th>Prix Total (FCFA)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_SESSION['panier'] as $produit_id => $produit): 
                // Supposons que vous avez accès au prix du produit
                $prix_unitaire = 6500; // Remplacez par la logique de récupération du prix réel en FCFA
                $quantite = $produit['quantite'];
                $prix_total = $prix_unitaire * $quantite;
                $total += $prix_total;
            ?>
            <tr>
                <td><?php echo htmlspecialchars($produit['nom']); ?></td>
                <td><?php echo $quantite; ?></td>
                <td><?php echo number_format($prix_unitaire, 0, ',', ' ') . ' FCFA'; ?></td>
                <td><?php echo number_format($prix_total, 0, ',', ' ') . ' FCFA'; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <h4>Total: <?php echo number_format($total, 0, ',', ' ') . ' FCFA'; ?></h4>

    <h4>Informations de Livraison</h4>
    <form action="traitement_checkout.php" method="POST">
        <div class="form-group">
            <label for="nom">Nom Complet</label>
            <input type="text" class="form-control" id="nom" name="nom" required>
        </div>
        <div class="form-group">
            <label for="adresse">Adresse</label>
            <input type="text" class="form-control" id="adresse" name="adresse" required>
        </div>
        <div class="form-group">
            <label for="ville">Ville</label>
            <input type="text" class="form-control" id="ville" name="ville" required>
        </div>
        <div class="form-group">
            <label for="code_postal">Code Postal</label>
            <input type="text" class="form-control" id="code_postal" name="code_postal" required>
        </div>
        <div class="form-group">
            <label for="telephone">Téléphone</label>
            <input type="text" class="form-control" id="telephone" name="telephone" required>
        </div>
        <button type="submit" class="btn btn-success">Confirmer la Commande</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
