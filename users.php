<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "gestion_stock3");

// Ajouter un utilisateur
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_user'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);

   

    $stmt = $conn->prepare("INSERT INTO utilisateurs (nom, mot_de_passe) VALUES (?, ?)");
    $stmt->bind_param("ss", $nom, $mot_de_passe);
    $stmt->execute();
}

// Récupérer la liste des utilisateurs
$utilisateurs = $conn->query("SELECT * FROM utilisateurs");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utilisateurs</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Liste des Utilisateurs</h2>

    <!-- Table des utilisateurs -->
    <table class="table">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($utilisateur = $utilisateurs->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($utilisateur['nom']); ?></td>
                    <a href="edit_user.php?id=<?php echo $utilisateur['id']; ?>" class="btn btn-warning">Modifier</a>
                    <a href="delete_user.php?id=<?php echo $utilisateur['id']; ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">Supprimer</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Bouton pour ajouter un utilisateur -->
    <button class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">Ajouter un Utilisateur</button>

    <!-- Modal pour ajouter un utilisateur -->
    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Ajouter un Utilisateur</h5>
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
                            <label>Prénom</label>
                            <input type="text" name="prenom" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Mot de passe</label>
                            <input type="password" name="mot_de_passe" class="form-control" required>
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        <button type="submit" name="add_user" class="btn btn-primary">Ajouter</button>
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
