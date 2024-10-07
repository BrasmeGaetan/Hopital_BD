<?php
session_start(); // Démarre la session pour vérifier les variables de session

include_once 'modele/mesFonctionsAccesBDD.php';

// Vérification si l'utilisateur est connecté et a le rôle 1 (par exemple, un administrateur ou employé)
if (!isset($_SESSION['valid']) || $_SESSION['valid'] !== true || $_SESSION['roles'] != 1) {
    // Si l'utilisateur n'a pas le rôle approprié, on affiche un message et on redirige vers la page de connexion
    echo "Accès non autorisé.";
    include "vue/vueConnexion.php";
    exit(); // Stoppe l'exécution du script
}

$Connexion = connexionBDD();

if ($_GET["choix"] == 1) {
    if (!empty($_POST['zone-saisie-titre']) && !empty($_POST['liste-auteur-livre']) && !empty($_POST['liste-genre-livre']) && !empty($_POST['zone-saisie-date']) && !empty($_POST['zone-cotation']) && !empty($_POST["livre-resume"]) && !empty($_FILES["zone-image"]["name"])) {
        $target_dir = "img/";
        $target_file = $target_dir . basename($_FILES["zone-image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["zone-image"]["tmp_name"]);
        if ($check !== false) {
            $titre = $_POST['zone-saisie-titre'];
            $datePublication = $_POST['zone-saisie-date'];
            $cotation = $_POST['zone-cotation'];
            $resumeLivre = $_POST['livre-resume'];
            $idauteur = $_POST['liste-auteur-livre'];
            $idgenre = $_POST['liste-genre-livre'];
            if (!move_uploaded_file($_FILES["zone-image"]["tmp_name"], $target_file)) {
                echo '<script>alert("Upload image erreur")</script>';
            } else {
                ajouterLivre($Connexion, $titre,  $idgenre, $idauteur, $resumeLivre, $datePublication, $cotation, $target_file);
            }
        } else {
            echo '<script>alert("Image erreur")</script>';
        }
    } else {
        echo '<script>alert("Veuillez remplir chaque champ")</script>';
    }
} else if ($_GET["choix"] == 2) {
    if (!empty($_POST['zone-saisie-id-update'])) {
        $target_file = "";
        if (!empty($_FILES["zone-image-update"])) {
            $target_dir = "img/";
            $target_file = $target_dir . basename($_FILES["zone-image-update"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $check = getimagesize($_FILES["zone-image-update"]["tmp_name"]);
            if ($check !== false) {
                if (!move_uploaded_file($_FILES["zone-image-update"]["tmp_name"], $target_file)) {
                    echo '<script>alert("Upload erreur")</script>';
                }
            } else {
                echo '<script>alert("Image erreur")</script>';
            }
        }
        $id = $_POST['zone-saisie-id-update'];
        $titre = $_POST['zone-saisie-titre-update'];
        $datePublication = $_POST['zone-saisie-date-update'];
        $cotation = $_POST['zone-cotation-update'];
        $resumeLivre = $_POST['livre-resume-update'];
        $idauteur = $_POST['liste-auteur-livre-update'];
        $idgenre = $_POST['liste-genre-livre-update'];
        modifierLivre($Connexion, $id, $titre,  $idgenre, $idauteur, $resumeLivre, $datePublication, $cotation, $target_file);
    } else {
        echo '<script>alert("Veuillez renseigner un identifiant de livre")</script>';
    } 
} else if ($_GET["choix"] == 3) {
    if (!empty($_POST['id-livre-a-supprimer'])) {
        $idLivreASupprimer = $_POST['id-livre-a-supprimer'];
        $suppressionReussie = supprimerLivre($Connexion, $idLivreASupprimer);
        if ($suppressionReussie) {
            echo '<script>alert("Livre supprimé avec succès !")</script>';
        } else {
            echo '<script>alert("Erreur lors de la suppression du livre.")</script>';
        }
    } else {
        echo '<script>alert("Veuillez saisir l\'identifiant du livre à supprimer.")</script>';
    }
}

// Récupération des données pour les formulaires (liste des auteurs, genres)
$genre = getGenre($Connexion)->fetchAll();
$auteur = getAuteur($Connexion)->fetchAll();

// Inclusion de la vue
include "vue/vueMenu.php";
?>
