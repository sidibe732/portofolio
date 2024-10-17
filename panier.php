<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Panier</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Mon Panier</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Prix</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($_SESSION['panier'])): ?>
                <?php foreach ($_SESSION['panier'] as $produit): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($produit['nom']); ?></td>
                        <td><?php echo $produit['quantite']; ?></td>
                        <td><?php echo number_format($produit['prix'], 0, ',', ' ') . ' FCFA'; ?></td>
                    </tr>
                    <?php $total += $produit['prix']; ?>
                <?php endforeach; ?>
                <tr>
                    <td colspan="2" class="font-weight-bold">Total</td>
                    <td class="font-weight-bold"><?php echo number_format($total, 0, ',', ' ') . ' FCFA'; ?></td>
                </tr>
            <?php else: ?>
                <tr>
                    <td colspan="3" class="text-center">Votre panier est vide.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <div class="d-flex justify-content-between">
        <a href="checkout.php" class="btn btn-success">Passer à la caisse</a>
        <a href="boutique.php" class="btn btn-secondary">Continuer vos achats</a>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
