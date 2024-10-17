<?php
// Connexion à la base de données
$conn = new mysqli("localhost", "root", "", "gestion_stock3");

// Vérifiez si l'ID du produit est fourni
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $product_query = $conn->prepare("SELECT * FROM produits WHERE id = ?");
    $product_query->bind_param("i", $product_id);
    $product_query->execute();
    $product_result = $product_query->get_result();
    $product = $product_result->fetch_assoc();
}

// Traitement du formulaire de modification
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_name = $_POST['nom'];
    $new_description = $_POST['description'];
    $new_label = $_POST['libelle'];
    $new_quantity = $_POST['quantite'];

    // Mise à jour du produit
    $update_query = $conn->prepare("UPDATE produits SET nom = ?, description = ?, libelle = ?, quantite = ? WHERE id = ?");
    $update_query->bind_param("ssssi", $new_name, $new_description, $new_label, $new_quantity, $product_id);
    $update_query->execute();

    // Redirection après modification
    header("Location: products.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Produit</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Modifier le Produit</h2>
    <form method="post">
        <div class="form-group">
            <label>Nom :</label>
            <input type="text" name="nom" class="form-control" value="<?php echo htmlspecialchars($product['nom']); ?>" required>
        </div>
        <div class="form-group">
            <label>Description :</label>
            <textarea name="description" class="form-control" required><?php echo htmlspecialchars($product['description']); ?></textarea>
        </div>
        <div class="form-group">
            <label>Libellé :</label>
            <input type="text" name="libelle" class="form-control" value="<?php echo htmlspecialchars($product['libelle']); ?>" required>
        </div>
        <div class="form-group">
            <label>Quantité :</label>
            <input type="number" name="quantite" class="form-control" value="<?php echo htmlspecialchars($product['quantite']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Modifier</button>
        <a href="products.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>
</body>
</html>
