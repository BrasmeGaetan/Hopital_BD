<?php
include_once 'modele/mesFonctionsAccesBDD.php';
session_start(); // Démarre la session

$bdd = connexionBDD(); // Connexion à la base de données

// Gestion de la déconnexion
if (isset($_GET["logout"])) {
    unset($_SESSION['valid']);
    session_unset();
    session_destroy();
    echo "Déconnexion réussie.";
}

// Gestion de la connexion
if (isset($_POST['pseudo']) && isset($_POST['mdp'])) {
    // Récupérer l'utilisateur par pseudo
    $user = getUser($bdd, $_POST['pseudo']);

    // Vérifier si l'utilisateur existe et que le mot de passe correspond
    if ($user && $user['mdp'] === $_POST['mdp']) {
        $_SESSION['valid'] = true;
    } else {
        echo "Pseudo ou mot de passe incorrect.";
    }
}

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['valid']) && $_SESSION['valid']) {
    // Si l'utilisateur est authentifié, charger les données
    $genre = getGenre($bdd)->fetchAll();
    $auteur = getAuteur($bdd)->fetchAll();
    include "vue/vueMenu.php";
} else {
    // Afficher le formulaire de connexion
    include "vue/vueConnexion.php";
}
?>