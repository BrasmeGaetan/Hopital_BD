<?php
include_once 'modele/mesFonctionsAccesBDD.php';

session_start(); // Initialisation de la session

$bdd = connexionBDD(); // Connexion à la base de données

if (!$bdd) {
    die("Erreur de connexion à la base de données.");
}

// Gestion de la déconnexion
if (isset($_GET["logout"])) {
    unset($_SESSION['valid']);
    session_unset();
    session_destroy();
    echo "Déconnexion réussie.";
    include "vue/vueConnexion.php"; // Inclusion après déconnexion
    exit();
}

if (isset($_POST['pseudo']) && isset($_POST['mdp'])) {
    $user = getUser($bdd, $_POST['pseudo']);

    if ($user && password_verify($_POST['mdp'], $user['mdp'])) {
        $_SESSION['valid'] = true;
        $_SESSION['roles'] = $user['roles'];

        // Redirection en fonction du rôle de l'utilisateur
        if ($_SESSION['roles'] == 1) {
            // Inclure la page d'employé
            $genre = getGenre($bdd)->fetchAll();
            $auteur = getAuteur($bdd)->fetchAll();
            include 'vue/vueMenu.php';
        } elseif ($_SESSION['roles'] == 2) {
            // Inclure la page de réservation de livres pour les patients
            include 'vue/vueConnexionPatient.php';
        }

        exit(); // S'assurer que le script s'arrête ici
    } else {
        echo "Pseudo ou mot de passe incorrect.";
        include "vue/vueConnexion.php"; // Réafficher la page de connexion en cas d'échec
    }
}

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['valid']) && $_SESSION['valid']) {
    $genre = getGenre($bdd)->fetchAll();
    $auteur = getAuteur($bdd)->fetchAll();
    header("Refresh:0; url=./index.php?action=menu");
} else {
    include "vue/vueConnexion.php"; // Inclure la vue de connexion si non connecté
}
?>
