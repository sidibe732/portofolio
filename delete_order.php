<?php
// Connexion à la base de données
$conn = new mysqli("localhost", "root", "", "gestion_stock3");

// Vérifiez si l'ID de commande est fourni
if (isset($_GET['id'])) {
    $order_id = $_GET['id'];

    // Supprimer la commande
    $delete_query = $conn->prepare("DELETE FROM commandes WHERE id = ?");
    $delete_query->bind_param("i", $order_id);
    $delete_query->execute();

    // Redirection après suppression
    header("Location: orders.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer Commande</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Commande Supprimée</h2>
    <p>La commande a été supprimée avec succès.</p>
    <a href="orders.php" class="btn btn-primary">Retour à la liste des commandes</a>
</div>
</body>
</html>
