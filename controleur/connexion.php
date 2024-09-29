<?php
include_once 'modele/mesFonctionsAccesBDD.php';
session_start(); // Démarre une session

$bdd = connexionBDD(); // Connexion à la base de données

if (isset($_GET["logout"])) { // Déconnexion de l'utilisateur
    unset($_SESSION['valid']);
    session_unset();
    session_destroy();
}

if (isset($_POST['pseudo']) && isset($_POST['mdp'])) {
    // Récupération du mot de passe depuis la base de données pour l'utilisateur donné
    $user = getUser(connexionBDD(), $_POST['pseudo']);
    
    // Comparaison directe avec le mot de passe en clair (sans hashage)
    if ($user && $user[0][0] == $_POST['mdp']) {
        $_SESSION['valid'] = true;
    }
}

if (isset($_SESSION['valid']) && $_SESSION['valid']) {
    // Si l'utilisateur est authentifié, chargement des données nécessaires
    $Connexion = connexionBDD();
    $genre = getGenre($Connexion)->fetchAll();
    $auteur = getAuteur($Connexion)->fetchAll();
    include "vue/vueMenu.php"; // Affichage du menu principal
} else {
    // Si l'utilisateur n'est pas authentifié, affichage du formulaire de connexion
    include "vue/vueConnexion.php";
}
?>
