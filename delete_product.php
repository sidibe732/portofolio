<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Connexion à la base de données
$conn = new mysqli("localhost", "root", "", "gestion_stock3");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suppression de Produit</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Gestion des Produits</h2>
    
    <?php
    // Vérifiez si l'ID du produit est passé en paramètre
    if (isset($_GET['id'])) {
        $produit_id = intval($_GET['id']);

        // Supprimer les commandes liées
        $conn->query("DELETE FROM commandes WHERE produit_id = $produit_id");

        // Maintenant, vous pouvez supprimer le produit
        $stmt = $conn->prepare("DELETE FROM produits WHERE id = ?");
        $stmt->bind_param("i", $produit_id);
        
        if ($stmt->execute()) {
            echo '<div class="alert alert-success" role="alert">Produit supprimé avec succès.</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Erreur lors de la suppression du produit.</div>';
        }
        
        $stmt->close();
    } else {
        echo '<div class="alert alert-warning" role="alert">Aucun ID de produit fourni.</div>';
    }

    $conn->close();
    ?>

    <a href="produits.php" class="btn btn-primary mt-3">Retour à la liste des produits</a>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
