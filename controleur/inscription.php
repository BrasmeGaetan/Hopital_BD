<?php
include "vue/vueInscription.php";  // Inclut la vue pour l'inscription
include_once 'modele/mesFonctionsAccesBDD.php';  // Fichier pour la connexion à la base de données
session_start();  // Démarre la session

$bdd = connexionBDD();  // Connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérification si l'utilisateur a accepté les conditions d'utilisation
    if (!isset($_POST['accept_conditions'])) {
        echo "Vous devez accepter les conditions d'utilisation pour vous inscrire.";
        exit();
    }

    // Récupération des données du formulaire
    $pseudo = $_POST['pseudo'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $mdp = $_POST['mdp'];
    $roles = 2;  // Rôle par défaut pour les utilisateurs normaux (2)
    $date_validation = date('Y-m-d');  // Format correct de la date pour MySQL (AAAA-MM-JJ)

    // Vérification de la complexité du mot de passe (au moins 8 caractères + un caractère spécial)
    if (strlen($mdp) < 8 || !preg_match('/[!@#$%^&*(),.?":{}|<>]/', $mdp)) {
        echo "Le mot de passe doit comporter au moins 8 caractères et inclure un caractère spécial.";
        exit();
    }

    // Vérification si le pseudo existe déjà dans la base de données
    $requeteVerif = $bdd->prepare("SELECT COUNT(*) FROM utilisateurs WHERE pseudo = :pseudo");
    $requeteVerif->execute(['pseudo' => $pseudo]);
    $exists = $requeteVerif->fetchColumn();

    if ($exists) {
        echo "Ce pseudo est déjà pris. Veuillez en choisir un autre.";
    } else {
        // Hachage du mot de passe pour plus de sécurité
        $hashedMdp = password_hash($mdp, PASSWORD_DEFAULT);

        // Insertion du nouvel utilisateur dans la base de données
        $requete = $bdd->prepare("INSERT INTO utilisateurs (pseudo, prenom, email, telephone, mdp, roles, date_validation) 
                                  VALUES (:pseudo, :prenom, :email, :telephone, :mdp, :roles, :date_validation)");
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
            include 'controleur/connexion.php'; 
            exit();
        } else {
            echo "Erreur lors de l'inscription. Veuillez réessayer.";
        }
    }
} else {
    exit();
}
?>
