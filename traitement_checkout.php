<?php
session_start();

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = htmlspecialchars($_POST['nom']);
    $adresse = htmlspecialchars($_POST['adresse']);
    $ville = htmlspecialchars($_POST['ville']);
    $code_postal = htmlspecialchars($_POST['code_postal']);
    $telephone = htmlspecialchars($_POST['telephone']);

    // Traitement de la commande (ajouter dans la base de données, envoyer un e-mail, etc.)
    
    // Une fois le traitement effectué, vider le panier
    unset($_SESSION['panier']);

    // Redirection vers une page de confirmation
    header("Location: confirmation.php");
    exit();
}
