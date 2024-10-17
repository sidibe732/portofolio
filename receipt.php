<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Supposons que ces données proviennent de la base de données ou d'une session
$order_id = $_GET['id']; // L'ID de la commande passée en paramètre
$user_id = $_SESSION['user_id'];

// Connexion à la base de données
$conn = new mysqli("localhost",  "root", "", "gestion_stock3");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupération des détails de la commande
$order_query = $conn->prepare("SELECT * FROM commandes WHERE id = ?");
$order_query->bind_param("i", $order_id);
$order_query->execute();
$order_result = $order_query->get_result();
$order = $order_result->fetch_assoc();

if (!$order) {
    echo "Commande introuvable.";
    exit();
}

// Récupération des informations utilisateur
$user_query = $conn->prepare("SELECT nom, mot_de_passe FROM utilisateurs WHERE id = ?");
$user_query->bind_param("i", $user_id);
$user_query->execute();
$user_result = $user_query->get_result();
$user = $user_result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reçu de Commande</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Reçu de Commande</h2>
    <p><strong>Nom :</strong> <?php echo htmlspecialchars($user['nom']); ?></p>
    <p><strong>ID de la Commande :</strong> <?php echo htmlspecialchars($order['id']); ?></p>
    <p><strong>Date :</strong> <?php echo htmlspecialchars($order['date']); ?></p>
    <h4>Détails de la Commande</h4>
    <ul class="list-group">
        <?php
        // Supposons que les détails des produits sont stockés dans une table `commande_details`
        $details_query = $conn->prepare("SELECT produit, quantite, prix FROM commande_details WHERE commande_id = ?");
        $details_query->bind_param("i", $order_id);
        $details_query->execute();
        $details_result = $details_query->get_result();

        $total = 0;
        while ($detail = $details_result->fetch_assoc()) {
            $total += $detail['quantite'] * $detail['prix'];
            echo "<li class='list-group-item'>" . htmlspecialchars($detail['produit']) . " - Quantité: " . htmlspecialchars($detail['quantite']) . " - Prix: " . htmlspecialchars($detail['prix']) . " €</li>";
        }
        ?>
    </ul>
    <h5>Total: <?php echo htmlspecialchars($total); ?> €</h5>
    <button onclick="window.print()" class="btn btn-primary">Imprimer le Reçu</button>
</div>
</body>
</html>

<?php
$conn->close();
?>
