<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once 'modele/mesFonctionsAccesBDD.php';
session_start(); // Démarre la session

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
    header("vue/vueConnexion.php"); // Redirection après déconnexion
    exit();
}

// Gestion de la connexion
if (isset($_POST['pseudo']) && isset($_POST['mdp'])) {
    $user = getUser($bdd, $_POST['pseudo']);

    if ($user && $_POST['mdp'] === $user['mdp']) { // Comparaison simple des mots de passe en clair
        $_SESSION['valid'] = true;
        header("vue/vueMenu.php"); // Redirection après connexion réussie
        exit();
    } else {
        echo "Pseudo ou mot de passe incorrect.";
    }
}

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['valid']) && $_SESSION['valid']) {
    $genre = getGenre($bdd)->fetchAll();
    $auteur = getAuteur($bdd)->fetchAll();
    include "vue/vueMenu.php";
} else {
    include "vue/vueConnexion.php";
}
?>
