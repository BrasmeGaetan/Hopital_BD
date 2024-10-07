<?php

include "vue/vueInscription.php";
include_once '../modele/mesFonctionsAccesBDD.php'; // Assurez-vous que le chemin est correct
session_start(); // Démarre la session

$bdd = connexionBDD(); // Connexion à la base de données

// Si la requête est de type POST (soumission du formulaire)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier si la case des conditions d'utilisation est cochée
    if (!isset($_POST['accept_conditions'])) {
        echo "Vous devez accepter les conditions d'utilisation pour vous inscrire.";
        exit();
    }

    // Récupérer les données envoyées depuis le formulaire
    $pseudo = $_POST['pseudo'];
    $prenom = $_POST['prenom']; // Nouveau champ
    $email = $_POST['email'];
    $telephone = $_POST['telephone']; // Nouveau champ
    $mdp = $_POST['mdp'];
    $role = 1; // Valeur par défaut pour le rôle

    // Vérifier si le pseudo existe déjà
    $requeteVerif = $bdd->prepare("SELECT COUNT(*) FROM utilisateurs WHERE pseudo = :pseudo");
    $requeteVerif->execute(['pseudo' => $pseudo]);
    $exists = $requeteVerif->fetchColumn();

    if ($exists) {
        echo "Ce pseudo est déjà pris. Veuillez en choisir un autre.";
    } else {
        // Insertion du nouvel utilisateur avec toutes les informations
        $requete = $bdd->prepare("INSERT INTO utilisateurs (pseudo, prenom, email, telephone, mdp, role, dateValid) VALUES (:pseudo, :prenom, :email, :telephone, :mdp, :role, :dateValid)");
        $result = $requete->execute([
            'pseudo' => $pseudo,
            'prenom' => $prenom,
            'email' => $email,
            'telephone' => $telephone,
            'mdp' => $mdp,
            'role' => $role,
            'dateValid' => date("y-m-d")
        ]);

        if ($result) {
            echo "Inscription réussie ! Vous pouvez maintenant vous connecter.";
            header("controleur/connexion.php"); // Redirection vers la page de connexion
            exit();
        } else {
            echo "Erreur lors de l'inscription. Veuillez réessayer.";
        }
    }
} else {
    // Rediriger vers le formulaire d'inscription si ce n'est pas une requête POST
    header("vue/vueInscription.php");
    exit();
}
?>
