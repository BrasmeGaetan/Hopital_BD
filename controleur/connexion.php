<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once 'modele/mesFonctionsAccesBDD.php';

session_start(); // N'oublie pas d'initialiser la session

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
    
    // Affichage pour débogage
    var_dump($user); // Vérifier si le rôle est présent et correct
    if ($user && $_POST['mdp'] === $user['mdp']) { // Comparaison simple des mots de passe en clair
        $_SESSION['valid'] = true;
        $_SESSION['roles'] = $user['roles']; // Stocker le rôle dans la session
        
        // Affichage des informations de session pour débogage
        var_dump($_SESSION);
        
        // Redirection en fonction du rôle de l'utilisateur
        if ($_SESSION['roles'] == 1) {
            // Rediriger vers la page d'employé (gestion des livres)
            header("vue/vueMenu.php");
        } elseif ($_SESSION['roles'] == 2) {
            // Rediriger vers la page de réservation de livres pour les patients
            header("vue/vueConnexionPatient.php");
        }
        
        exit(); // Assurez-vous que le script s'arrête ici
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
