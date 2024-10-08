<?php
include "vue/vueInscription.php";
include_once '../modele/mesFonctionsAccesBDD.php'; 
session_start(); // Démarre la session

$bdd = connexionBDD(); // Connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['accept_conditions'])) {
        echo "Vous devez accepter les conditions d'utilisation pour vous inscrire.";
        exit();
    }

    $pseudo = $_POST['pseudo'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $mdp = $_POST['mdp'];
    $roles = 2;
    $date_validation = date('m/d/Y');

    // Vérification de la complexité du mot de passe
    if (strlen($mdp) < 8 || !preg_match('/[!@#$%^&*(),.?":{}|<>]/', $mdp)) {
        echo "Le mot de passe doit comporter au moins 8 caractères et inclure un caractère spécial.";
        exit();
    }

    $requeteVerif = $bdd->prepare("SELECT COUNT(*) FROM utilisateurs WHERE pseudo = :pseudo");
    $requeteVerif->execute(['pseudo' => $pseudo]);
    $exists = $requeteVerif->fetchColumn();

    if ($exists) {
        echo "Ce pseudo est déjà pris. Veuillez en choisir un autre.";
    } else {
        // Hachage du mot de passe
        $hashedMdp = password_hash($mdp, PASSWORD_DEFAULT);

        // Insertion du nouvel utilisateur
        $requete = $bdd->prepare("INSERT INTO utilisateurs (pseudo, prenom, email, telephone, mdp, roles, date_validation) VALUES (:pseudo, :prenom, :email, :telephone, :mdp, :roles, :date_validation)");
        $result = $requete->execute([
            'pseudo' => $pseudo,
            'prenom' => $prenom,
            'email' => $email,
            'telephone' => $telephone,
            'mdp' => $hashedMdp,
            'roles' => $roles,
            'date_validation' => $date_validation
        ]);

        if ($result) {
            echo "Inscription réussie ! Vous pouvez maintenant vous connecter.";
            include 'controleur/connexion.php'; // Redirection vers la page de connexion
            exit();
        } else {
            echo "Erreur lors de l'inscription. Veuillez réessayer.";
        }
    }
} else {
    exit();
}
?>
