<?php
session_start();
include_once 'modele/mesFonctionsAccesBDD.php';
echo "wuafbnaf";

if (!isset($_SESSION['valid']) || !$_SESSION['valid']) {
    echo "Vous devez être connecté pour emprunter un livre.";
    include 'vue/vueConnexion.php'; 
    exit();
}


$bdd = connexionBDD();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    var_dump($_POST); 

    
    $livre_id = $_POST['livre'];
    $date_emprunt = $_POST['date'];
    $date_retour_prevue = $_POST['dateRetour'];
    $genre = $_POST['genre'];
    $auteur = $_POST['auteur'];

    
    $utilisateur_id = $_SESSION['utilisateur_id'];

    
    
    $requete = $bdd->prepare("
        INSERT INTO emprunts (utilisateur_id, titre, date_emprunt, genre, auteur, date_retour_prevue)
        VALUES (:utilisateur_id, (SELECT titre FROM livre WHERE idlivre = :livre_id), :date_emprunt, :genre, :auteur, :date_retour_prevue)
    ");

    
    try {
        $success = $requete->execute([
            'utilisateur_id' => $utilisateur_id,
            'livre_id' => $livre_id,
            'date_emprunt' => $date_emprunt,
            'genre' => $genre,
            'auteur' => $auteur,
            'date_retour_prevue' => $date_retour_prevue
        ]);

        
        if ($success) {
            echo "Livre emprunté avec succès !";
            header("Refresh:0; url=./index.php?action=livres");
            exit();
        } else {
            echo "Une erreur est survenue lors de l'emprunt du livre.";
        }
    } catch (PDOException $e) {
        echo "Erreur lors de l'exécution de la requête : " . $e->getMessage(); 
    }

    
    include 'vue/vueConnexionPatient.php'; 
    exit();
}


include 'vue/vueConnexionPatient.php';
?>
