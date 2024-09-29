<?php
include_once 'modele/mesFonctionsAccesBDD.php'; // Inclusion du fichier de fonctions pour l'accès à la BDD
session_start(); // Démarre une session pour la gestion des utilisateurs

$bdd = connexionBDD(); // Connexion à la base de données

if (isset($_GET["logout"])) { // Si l'utilisateur demande à se déconnecter
    unset($_SESSION['valid']); // Suppression de la variable de session
    session_unset(); // Libération des variables de session
    session_destroy(); // Destruction de la session
    include "vue/vueConnexion.php"; // Retour à la page de connexion
    exit(); // Sortie du script
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['pseudo']) && isset($_POST['mdp'])) { 
    // Récupération du pseudo et du hash du mot de passe de l'utilisateur
    $pseudo = $_POST['pseudo'];
    $mot_de_passe = $_POST['mdp'];

    // Récupérer le hash du mot de passe depuis la BDD pour le pseudo donné
    $hash = getHash($bdd, $pseudo); 

    // Vérifier si l'utilisateur existe et que le mot de passe correspond
    if (!empty($hash) && hash('sha256', $mot_de_passe) == $hash['mot_de_passe']) {
        // Si les identifiants sont corrects, créer une session valide
        $_SESSION['valid'] = true;
        $_SESSION['pseudo'] = $pseudo; // Optionnel, garder le pseudo en session
        
        // Charger d'autres données nécessaires pour l'application (exemple : genre, auteur)
        $Connexion = connexionBDD(); 
        $genre = getGenre($Connexion)->fetchAll(); 
        $auteur = getAuteur($Connexion)->fetchAll();

        // Affichage du menu principal
        include "vue/vueMenu.php";
    } else {
        // Si le pseudo ou le mot de passe est incorrect, on réaffiche le formulaire de connexion
        $messageErreur = "Identifiant ou mot de passe incorrect.";
        include "vue/vueConnexion.php";
    }
} elseif (isset($_SESSION['valid']) && $_SESSION['valid']) {
    // Si l'utilisateur est déjà connecté (session active), on affiche directement le menu
    $Connexion = connexionBDD();
    $genre = getGenre($Connexion)->fetchAll();
    $auteur = getAuteur($Connexion)->fetchAll();
    include "vue/vueMenu.php";
} else {
    // Sinon, on affiche le formulaire de connexion
    include "vue/vueConnexion.php";
}
?>
