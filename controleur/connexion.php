<?php
include_once 'modele/mesFonctionsAccesBDD.php';
session_start(); // Démarre la session

$bdd = connexionBDD(); // Connexion à la base de données

if (isset($_GET["logout"])) { // Gestion de la déconnexion
    unset($_SESSION['valid']);
    session_unset();
    session_destroy();
    echo "Déconnexion réussie.";
}

if (isset($_POST['pseudo']) && isset($_POST['mdp'])) {
    // Récupérer le mot de passe associé au pseudo
    $user = getUser(connexionBDD(), $_POST['pseudo']);
    

    // Vérifier si l'utilisateur existe et que le mot de passe correspond
    if ($user && $user['mdp'] == $_POST['mdp']) {
        $_SESSION['valid'] = true;

    } else {
        echo "Pseudo ou mot de passe incorrect.";
    }
}

if (isset($_SESSION['valid']) && $_SESSION['valid']) {
    // Si l'utilisateur est authentifié, charger les données
    $Connexion = connexionBDD();
    $genre = getGenre($Connexion)->fetchAll();
    $auteur = getAuteur($Connexion)->fetchAll();
    include "vue/vueMenu.php";
} else {
    // Afficher le formulaire de connexion si l'utilisateur n'est pas authentifié
    include "vue/vueConnexion.php";
}
