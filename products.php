<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "gestion_stock3");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $libelle = $_POST['libelle'];
    $quantite = $_POST['quantite'];
    $prix = $_POST['prix']; // Ajout du prix

    $stmt = $conn->prepare("INSERT INTO produits (nom, description, libelle, quantite, prix) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $nom, $description, $libelle, $quantite, $prix);
    $stmt->execute();
}

$produits = $conn->query("SELECT * FROM produits");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produits</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Liste des Produits</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Description</th>
                <th>Libellé</th>
                <th>Quantité</th>
                <th>Prix (FCFA)</th> <!-- Ajout de la colonne Prix -->
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($produit = $produits->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($produit['nom']); ?></td>
                <td><?php echo htmlspecialchars($produit['description']); ?></td>
                <td><?php echo htmlspecialchars($produit['libelle']); ?></td>
                <td><?php echo htmlspecialchars($produit['quantite']); ?></td>
                <td><?php echo number_format($produit['prix'], 0, ',', ' ') . ' FCFA'; ?></td> <!-- Affichage du prix -->
                <td>
                    <a href="edit_product.php?id=<?php echo $produit['id']; ?>" class="btn btn-warning">Modifier</a>
                    <a href="delete_product.php?id=<?php echo $produit['id']; ?>" class="btn btn-danger">Supprimer</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <button class="btn btn-primary" data-toggle="modal" data-target="#addProductModal">Ajouter un Produit</button>
    
    <!-- Modal pour ajouter un produit -->
    <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Ajouter un Produit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nom</label>
                            <input type="text" name="nom" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Libellé</label>
                            <input type="text" name="libelle" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Quantité</label>
                            <input type="number" name="quantite" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Prix (FCFA)</label> <!-- Ajout du champ Prix -->
                            <input type="number" name="prix" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        <button type="submit" name="add_product" class="btn btn-primary">Ajouter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
