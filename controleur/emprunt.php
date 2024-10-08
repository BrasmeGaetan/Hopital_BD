<?php
session_start();
include_once 'modele/mesFonctionsAccesBDD.php';
echo "wuafbnaf";
// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['valid']) || !$_SESSION['valid']) {
    echo "Vous devez être connecté pour emprunter un livre.";
    include 'vue/vueConnexion.php'; // Inclure la vue de connexion
    exit();
}

// Connexion à la base de données
$bdd = connexionBDD();

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    var_dump($_POST); // Pour voir les données soumises

    // Récupérer les données du formulaire
    $livre_id = $_POST['livre'];
    
    // Date d'emprunt
    $date_emprunt = date('Y-m-d');
    
    // Date de retour prévue
    $date_retour_prevue = date('Y-m-d', strtotime($date_emprunt . ' + 3 weeks'));

    // Récupérer le genre et l'auteur du livre
    $livre_query = $bdd->prepare("SELECT genre, auteur FROM livre WHERE idlivre = :livre_id");
    $livre_query->execute(['livre_id' => $livre_id]);
    $livre_data = $livre_query->fetch(PDO::FETCH_ASSOC);

    $genre = $livre_data['genre'];
    $auteur = $livre_data['auteur'];

    
    $utilisateur_id = $_SESSION['utilisateur_id'];

    // Préparer la requête d'insertion de l'emprunt
    $requete = $bdd->prepare("
        INSERT INTO emprunts (utilisateur_id, titre, date_emprunt, genre, auteur, date_retour_prevue, date_retour_effective)
        VALUES (:utilisateur_id, (SELECT titre FROM livre WHERE idlivre = :livre_id), :date_emprunt, :genre, :auteur, :date_retour_prevue, NULL)
    ");

    // Exécuter la requête avec les données du formulaire
    try {
        $success = $requete->execute([
            'utilisateur_id' => $utilisateur_id,
            'livre_id' => $livre_id,
            'date_emprunt' => $date_emprunt,
            'genre' => $genre,
            'auteur' => $auteur,
            'date_retour_prevue' => $date_retour_prevue
        ]);

        // Vérifier si l'insertion a réussi
        if ($success) {
            echo "Livre emprunté avec succès !";
            header("Refresh:0; url=./index.php?action=livres");
            exit();
        } else {
            echo "Une erreur est survenue lors de l'emprunt du livre.";
        }
    } catch (PDOException $e) {
        echo "Erreur lors de l'exécution de la requête : " . $e->getMessage(); // Afficher l'erreur
    }

    // Inclure la vue du menu même en cas d'erreur
    include 'vue/vueConnexionPatient.php'; 
    exit();
}


include 'vue/vueConnexionPatient.php';
