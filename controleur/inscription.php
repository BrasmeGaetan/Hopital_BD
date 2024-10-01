<?php

include "vue/vueInscription.php";


include_once '../modele/mesFonctionsAccesBDD.php'; // Assurez-vous que le chemin est correct
session_start(); // Démarre la session

$bdd = connexionBDD(); // Connexion à la base de données

// Si la requête est de type POST (soumission du formulaire)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $mdp = $_POST['mdp'];

    // Vérifier si le pseudo existe déjà
    $requeteVerif = $bdd->prepare("SELECT COUNT(*) FROM utilisateurs WHERE nom = :nom");
    $requeteVerif->execute(['nom' => $nom]);
    $exists = $requeteVerif->fetchColumn();

    if ($exists) {
        echo "Ce pseudo est déjà pris. Veuillez en choisir un autre.";
    } else {
        // Insertion du nouvel utilisateur
        $requete = $bdd->prepare("INSERT INTO utilisateurs (nom, mdp) VALUES (:nom, :mdp)");
        $result = $requete->execute(['nom' => $nom, 'mdp' => $mdp]);

        if ($result) {
            echo "Inscription réussie ! Vous pouvez maintenant vous connecter.";
            header("Location: ../connexion.php"); // Redirection vers la page de connexion
            exit();
        } else {
            echo "Erreur lors de l'inscription. Veuillez réessayer.";
        }
    }
} else {
    // Rediriger vers le formulaire d'inscription si ce n'est pas une requête POST

}
?>