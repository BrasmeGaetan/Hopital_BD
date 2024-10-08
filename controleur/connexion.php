<?php
include_once 'modele/mesFonctionsAccesBDD.php';

session_start(); 

$bdd = connexionBDD(); 

if (!$bdd) {
    die("Erreur de connexion à la base de données.");
}


if (isset($_GET["logout"])) {
    unset($_SESSION['valid']);
    unset($_SESSION['roles']);
    unset($_SESSION['utilisateur_id']);
    session_unset();
    session_destroy();
    echo "Déconnexion réussie.";
    include "vue/vueConnexion.php"; 
    exit();
}

// Gestion de la connexion
if (isset($_POST['pseudo']) && isset($_POST['mdp'])) {
    $user = getUser($bdd, $_POST['pseudo']);
    
    // Affichage pour débogage

    if ($user && $_POST['mdp'] === $user['mdp']) { // Comparaison simple des mots de passe
        $_SESSION['valid'] = true;
        $_SESSION['roles'] = $user['roles'];

        // Redirection en fonction du rôle de l'utilisateur
        if ($_SESSION['roles'] == 1) {
            // Inclure la page d'employé (gestion des livres)
            $genre = getGenre($bdd)->fetchAll();
            $auteur = getAuteur($bdd)->fetchAll();
            include 'vue/vueMenu.php';
        } elseif ($_SESSION['roles'] == 2) {
            
            include 'vue/vueConnexionPatient.php';
        }
        
        exit(); // S'assurer que le script s'arrête ici
    } else {
        echo "Pseudo ou mot de passe incorrect.";
        include "vue/vueConnexion.php"; 
    }
}


if (isset($_SESSION['valid']) && $_SESSION['valid']) {
    $genre = getGenre($bdd)->fetchAll();
    $auteur = getAuteur($bdd)->fetchAll();
    header("Refresh:0; url=./index.php?action=menu");
} else {
    include "vue/vueConnexion.php"; 
}
?>
