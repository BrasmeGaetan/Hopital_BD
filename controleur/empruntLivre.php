<?php
session_start();
include "vue/vueConnexionPatient.php";
include_once 'modele/mesFonctionsAccesBDD.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['valid']) || !$_SESSION['valid']) {
    echo "Vous devez être connecté pour emprunter un livre.";
    header("vueConnexion.php"); // Redirection vers la page de connexion si non connecté
    exit();
}

// Connexion à la base de données
$bdd = connexionBDD();

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $titre = $_POST['titre'];
    $date_emprunt = $_POST['date'];
    $genre = $_POST['genre'];
    $auteur = $_POST['auteur'];
    $date_retour_prevue = $_POST['dateRetour'];

    // Récupérer l'utilisateur connecté
    $utilisateur_id = $_SESSION['utilisateur_id']; // On suppose que tu stockes l'ID de l'utilisateur dans la session

    // Préparer la requête d'insertion de l'emprunt
    $requete = $bdd->prepare("
        INSERT INTO emprunts (utilisateur_id, titre, date_emprunt, genre, auteur, date_retour_prevue)
        VALUES (:utilisateur_id, :titre, :date_emprunt, :genre, :auteur, :date_retour_prevue)
    ");

    // Exécuter la requête avec les données du formulaire
    $success = $requete->execute([
        'utilisateur_id' => $utilisateur_id,
        'titre' => $titre,
        'date_emprunt' => $date_emprunt,
        'genre' => $genre,
        'auteur' => $auteur,
        'date_retour_prevue' => $date_retour_prevue
    ]);

    // Vérifier si l'insertion a réussi
    if ($success) {
        echo "Livre emprunté avec succès !";
        // Redirection ou message de confirmation
        header("vueMenu.php");
        exit();
    } else {
        echo "Une erreur est survenue lors de l'emprunt du livre.";
    }
}
?>

