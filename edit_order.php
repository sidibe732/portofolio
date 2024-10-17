<?php
// Connexion à la base de données
$conn = new mysqli("localhost", "root", "", "gestion_stock3");

// Vérifiez si l'ID de commande est fourni
if (isset($_GET['id'])) {
    $order_id = $_GET['id'];
    $order_query = $conn->prepare("SELECT * FROM commandes WHERE id = ?");
    $order_query->bind_param("i", $order_id);
    $order_query->execute();
    $order_result = $order_query->get_result();
    $order = $order_result->fetch_assoc();
}

// Traitement du formulaire de modification
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $new_date = $_POST['date']; // Ajoutez d'autres champs si nécessaire

    // Mise à jour de la commande
    $update_query = $conn->prepare("UPDATE commandes SET date = ? WHERE id = ?");
    $update_query->bind_param("si", $new_date, $order_id);
    $update_query->execute();

    // Redirection après modification
    header("Location: orders.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Commande</title>
</head>
<body>
<form method="post">
    <label>Date :</label>
    <input type="date" name="date" value="<?php echo htmlspecialchars($order['date']); ?>">
    <button type="submit">Modifier</button>
</form>
</body>
</html>
