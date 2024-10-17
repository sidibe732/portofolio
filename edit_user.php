<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "gestion_stock3");

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        echo "Utilisateur non trouvé.";
        exit();
    }
} else {
    echo "ID de l'utilisateur non spécifié.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $mot_de_passe = !empty($_POST['mot_de_passe']) ? password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT) : $user['mot_de_passe'];
    
    $stmt = $conn->prepare("UPDATE utilisateurs SET nom = ?, prenom = ?, mot_de_passe = ? WHERE id = ?");
    $stmt->bind_param("sssi", $nom, $prenom, $mot_de_passe, $user_id);
    $stmt->execute();

    header("Location: users.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Utilisateur</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Modifier l'Utilisateur</h2>

    <form method="POST" action="">
        <div class="form-group">
            <label>Nom</label>
            <input type="text" name="nom" class="form-control" value="<?php echo htmlspecialchars($user['nom']); ?>" required>
        </div>
        <div class="form-group">
            <label>Nouveau Mot de Passe (laisser vide pour ne pas modifier)</label>
            <input type="password" name="mot_de_passe" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
</body>
</html>
