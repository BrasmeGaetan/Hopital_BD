<?php
session_start(); // Assurez-vous que la session est démarrée au tout début

// Vérification de la déconnexion
if (isset($_GET["action"]) && $_GET["action"] == "deconnexion") {
    // Gestion de la déconnexion
    unset($_SESSION['valid']);
    session_unset();
    session_destroy();
    header("Location: ./index.php?action=index"); // Redirige vers la page d'accueil ou l'index
    exit(); // Sortir du script pour éviter d'autres actions
}

include "inc/header.inc"; // Inclusion de l'en-tête
include "controleur/controleurPrincipal.php"; // Inclusion du contrôleur principal

// Vérification de l'action
if (isset($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = "index"; // Action par défaut
}

$fichier = controleurPrincipal($action); // Obtenir le fichier à inclure
include "controleur/$fichier"; // Inclusion du fichier de contrôleur
include "inc/footer.inc"; // Inclusion du pied de page
