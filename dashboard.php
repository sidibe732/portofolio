<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "gestion_stock3");

// Compter les utilisateurs et les produits
$utilisateurs_count = $conn->query("SELECT COUNT(*) AS count FROM utilisateurs")->fetch_assoc()['count'];
$produits_count = $conn->query("SELECT COUNT(*) AS count FROM produits")->fetch_assoc()['count'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #e9ecef;
        }
        .card {
            transition: transform 0.3s, box-shadow 0.3s;
            border-radius: 15px;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
        .card-header {
            background: linear-gradient(90deg, rgba(63,94,251,1) 0%, rgba(252,70,107,1) 100%);
            color: white;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }
        .action-btn {
            margin: 5px;
            border-radius: 50px;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }
        .btn-info {
            background-color: #17a2b8;
            border-color: #17a2b8;
        }
        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
        }
        .header-title {
            margin-bottom: 20px;
            font-weight: bold;
            color: #343a40;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2 class="header-title">Tableau de Bord</h2>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">Nombre d'Utilisateurs</div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $utilisateurs_count; ?></h5>
                    <p class="card-text">Nombre total d'utilisateurs enregistrés.</p>
                    <a href="users.php" class="btn btn-light">Voir les Utilisateurs</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">Nombre de Produits</div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $produits_count; ?></h5>
                    <p class="card-text">Nombre total de produits enregistrés.</p>
                    <a href="products.php" class="btn btn-light">Voir les Produits</a>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <h3>Actions Rapides</h3>
        <div class="btn-group-vertical">
            <a href="users.php" class="btn btn-primary action-btn">Gérer les Utilisateurs</a>
            <a href="panier.php" class="btn btn-primary action-btn">Voir Mon Panier</a>
            <a href="products.php" class="btn btn-success action-btn">Gérer les Produits</a>
            <a href="boutique.php" class="btn btn-info btn-lg action-btn">Accéder à la Boutique</a>
            <a href="orders.php" class="btn btn-warning action-btn">Gérer les Commandes</a>
            <a href="receipt.php?id=1" class="btn btn-light action-btn">Voir le Reçu de Commande</a>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>