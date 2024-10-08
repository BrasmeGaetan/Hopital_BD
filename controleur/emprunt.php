<?php


session_start();
include_once 'modele/mesFonctionsAccesBDD.php';
// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['valid']) || !$_SESSION['valid']) {
    echo "Vous devez être connecté pour emprunter un livre.";
    include 'vue/vueConnexion.php'; // Inclure la vue de connexion
    exit();
}

// Connexion à la base de données
$bdd = connexionBDD();

// Vérifier si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Afficher les données reçues pour débogage
    var_dump($_POST); 

    // Récupérer l'ID du livre
    $livre_id = $_POST['livre'];

    // Dates d'emprunt
    $date_emprunt = date('Y-m-d');
    $date_retour_prevue = date('Y-m-d', strtotime($date_emprunt . ' + 3 weeks'));

    // Récupérer le genre et l'auteur du livre
    $livre_query = $bdd->prepare("SELECT genre, auteur, titre FROM livre WHERE idlivre = :livre_id");
    $livre_query->execute(['livre_id' => $livre_id]);
    $livre_data = $livre_query->fetch(PDO::FETCH_ASSOC);

    // Vérifier si le livre existe
    if ($livre_data) {
        $genre = $livre_data['genre'];
        $auteur = $livre_data['auteur'];
        $titre = $livre_data['titre'];
        

        // Récupérer l'utilisateur connecté
        $utilisateur_id = $_SESSION['utilisateur_id'];

        // Préparer la requête d'insertion
        $requete = $bdd->prepare("
            INSERT INTO emprunts (utilisateur_id, titre, date_emprunt, genre, auteur, date_retour_prevue, date_retour_effective)
            VALUES (:utilisateur_id, :titre, :date_emprunt, :genre, :auteur, :date_retour_prevue, NULL)
        ");

        try {
            // Exécuter la requête d'insertion
            $success = $requete->execute([
                'utilisateur_id' => $utilisateur_id,
                'titre' => $titre,
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
    } else {
        echo "Livre non trouvé.";
    }
}


include 'vue/vueConnexionPatient.php';
