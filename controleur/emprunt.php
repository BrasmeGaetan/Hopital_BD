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
    var_dump($_POST); // Pour le débogage

    $livre_id = $_POST['livre'];

    if (empty($livre_id)) {
        echo "Veuillez sélectionner un livre.";
        exit();
    }

    // Dates d'emprunt
    $date_emprunt = date('Y-m-d');
    $date_retour_prevue = date('Y-m-d', strtotime($date_emprunt . ' + 3 weeks'));

    // Récupérer le genre et l'auteur du livre
    $livre_query = $bdd->prepare("SELECT genre, auteur, titre FROM livre WHERE idlivre = :livre_id");
    $livre_query->execute(['livre_id' => $livre_id]);
    $livre_data = $livre_query->fetch(PDO::FETCH_ASSOC);

    if ($livre_data) {
        $genre = $livre_data['genre'];
        $auteur = $livre_data['auteur'];
        $titre = $livre_data['titre'];

        $utilisateur_id = $_SESSION['utilisateur_id'];

        // Vérification de l'emprunt existant
        $verif_query = $bdd->prepare("SELECT COUNT(*) FROM emprunts WHERE utilisateur_id = :utilisateur_id AND titre = :titre AND date_retour_effective IS NULL");
        $verif_query->execute(['utilisateur_id' => $utilisateur_id, 'titre' => $titre]);
        $emprunt_existant = $verif_query->fetchColumn();

        if ($emprunt_existant > 0) {
            echo "Vous avez déjà emprunté ce livre.";
            exit();
        }

        // Insertion de l'emprunt
        $requete = $bdd->prepare("
            INSERT INTO emprunts (utilisateur_id, titre, date_emprunt, genre, auteur, date_retour_prevue, date_retour_effective)
            VALUES (:utilisateur_id, :titre, :date_emprunt, :genre, :auteur, :date_retour_prevue, NULL)
        ");

        try {
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
                header("Location: ./index.php?action=livres");
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