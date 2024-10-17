<?php
session_start();
$conn = new mysqli("localhost", "root", "", "gestion_stock3");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $mot_de_passe = $_POST['mot_de_passe'];

    $stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE nom = ?");
    $stmt->bind_param("s", $nom);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $utilisateur = $result->fetch_assoc();
        if (password_verify($mot_de_passe, $utilisateur['mot_de_passe'])) {
            $_SESSION['user_id'] = $utilisateur['id'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Mot de passe incorrect.";
        }
    } else {
        $error = "Nom d'utilisateur introuvable.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Connexion</h2>
    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <form method="POST" action="">
        <div class="form-group">
            <label>Nom d'utilisateur</label>
            <input type="text" name="nom" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Mot de passe</label>
            <input type="password" name="mot_de_passe" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>
</div>
</body>
</html>
