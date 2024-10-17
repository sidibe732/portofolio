<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Connexion à la base de données
$conn = new mysqli("localhost", "root", "", "gestion_stock3");

// Récupération des produits
$produits = $conn->query("SELECT * FROM produits");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boutique</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .product-card {
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .product-card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        }
        .search-bar {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Bienvenue dans notre Boutique en ligne</h2>
    
    <input type="text" id="search" class="form-control search-bar" placeholder="Rechercher un produit...">

    <div class="row" id="product-list">
        <?php while ($produit = $produits->fetch_assoc()): ?>
        <div class="col-md-4 mb-4">
            <div class="card product-card">
                <img src="path/to/image.jpg" class="card-img-top" alt="<?php echo htmlspecialchars($produit['nom']); ?>">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($produit['nom']); ?></h5>
                    <p class="card-text"><?php echo htmlspecialchars($produit['description']); ?></p>
                    <p class="card-text"><strong>Prix: <?php echo number_format($produit['prix'] * 655, 0, ',', ' ') . ' FCFA'; ?></strong></p>
                     <!-- Affichage des évaluations ---

                    <a href="ajouter_au_panier.php?id=<?php echo $produit['id']; ?>" class="btn btn-primary"><i class="fas fa-cart-plus"></i> Ajouter au Panier</a>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>

    <!-- Pagination -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
        </ul>
    </nav>
</div>

<!-- Notification Toast -->
<div id="toast" class="position-fixed" style="bottom: 20px; right: 20px; display:none;">
    <div class="alert alert-success" role="alert">
        Produit ajouté au panier !
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $('#search').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('#product-list .col-md-4').filter(function() {
                $(this).toggle($(this).find('.card-title').text().toLowerCase().indexOf(value) > -1)
            });
        });

        // Exemple de notification toast pour ajouter au panier
        $('.btn-primary').on('click', function() {
            $('#toast').fadeIn().delay(2000).fadeOut();
        });
    });
</script>
</body>
</html>
