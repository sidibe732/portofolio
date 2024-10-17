<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "gestion_stock3");

// Ajout d'une commande
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $produit_id = $_POST['produit_id'];
    $quantite = $_POST['quantite'];
    $utilisateur_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO commandes (utilisateur_id, produit_id, quantite) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $utilisateur_id, $produit_id, $quantite);
    $stmt->execute();
}

// Récupérer la liste des commandes
$commandes = $conn->query("SELECT c.*, u.nom AS nom_utilisateur, p.nom AS nom_produit FROM commandes c JOIN utilisateurs u ON c.utilisateur_id = u.id JOIN produits p ON c.produit_id = p.id ORDER BY c.date_commande DESC");

// Récupérer la liste des produits pour le formulaire d'ajout de commande
$produits = $conn->query("SELECT * FROM produits");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Commandes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Gestion des Commandes</h2>

    <form method="POST" action="">
        <div class="form-group">
            <label>Produit</label>
            <select name="produit_id" class="form-control" required>
                <option value="">Sélectionner un produit</option>
                <?php while ($produit = $produits->fetch_assoc()): ?>
                    <option value="<?php echo $produit['id']; ?>"><?php echo htmlspecialchars($produit['nom']); ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Quantité</label>
            <input type="number" name="quantite" class="form-control" required min="1">
        </div>
        <button type="submit" class="btn btn-primary">Ajouter Commande</button>
        <a href="edit_order.php?id=<?php echo $order['id']; ?>" class="btn btn-warning">Modifier</a>
        <a href="delete_order.php?id=<?php echo $order['id']; ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette commande ?');">Supprimer</a>

    </form>

    <h3 class="mt-5">Liste des Commandes</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Utilisateur</th>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Date de Commande</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($commande = $commandes->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $commande['id']; ?></td>
                    <td><?php echo htmlspecialchars($commande['nom_utilisateur']); ?></td>
                    <td><?php echo htmlspecialchars($commande['nom_produit']); ?></td>
                    <td><?php echo $commande['quantite']; ?></td>
                    <td><?php echo $commande['date_commande']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
