<?php

include_once 'modele/mesFonctionsAccesBDD.php';

session_start(); 

$bdd = connexionBDD(); 

if (!$bdd) {
    die("Erreur de connexion à la base de données.");
}


if (isset($_GET["logout"])) {
    unset($_SESSION['valid']);
    session_unset();
    session_destroy();
    echo "Déconnexion réussie.";
    include "vue/vueConnexion.php"; 
    exit();
}


if (isset($_POST['pseudo']) && isset($_POST['mdp'])) {
    $user = getUser($bdd, $_POST['pseudo']);
    
    

    if ($user && $_POST['mdp'] === $user['mdp']) { 
        $_SESSION['valid'] = true;
        $_SESSION['roles'] = $user['roles']; 
        
        
        
        if ($_SESSION['roles'] == 1) {
            
            $genre = getGenre($bdd)->fetchAll();
            $auteur = getAuteur($bdd)->fetchAll();
            include 'vue/vueMenu.php';
        } elseif ($_SESSION['roles'] == 2) {
            
            include 'vue/vueConnexionPatient.php';
        }
        
        exit(); 
    } else {
        echo "Pseudo ou mot de passe incorrect.";
        include "vue/vueConnexion.php"; 
    }
}


if (isset($_SESSION['valid']) && $_SESSION['valid']) {
    $genre = getGenre($bdd)->fetchAll();
    $auteur = getAuteur($bdd)->fetchAll();
    echo "wfafwa";
    header("Refresh:0; url=./index.php?action=menu");
} else {
    include "vue/vueConnexion.php"; 
}
