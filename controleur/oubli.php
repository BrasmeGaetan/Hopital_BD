<?php
include_once 'modele/mesFonctionsAccesBDD.php';

$Connexion = connexionBDD();

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['utilisateur_id'])) {
    echo "Vous devez être connecté pour demander le droit à l'oubli.";
    exit;
}

$utilisateur_id = $_SESSION['utilisateur_id'];

// Étape 1 : Sauvegarder les données utilisateur
try {
    sauvegarderUtilisateur($Connexion, $utilisateur_id); // Sauvegarde des données utilisateur avant suppression

    // Étape 2 : Supprimer les emprunts associés à l'utilisateur
    $supprimerEmprunts = $Connexion->prepare("DELETE FROM emprunts WHERE utilisateur_id = :utilisateur_id");
    $supprimerEmprunts->execute(['utilisateur_id' => $utilisateur_id]);

    // Étape 3 : Supprimer les informations utilisateur
    $supprimerUtilisateur = $Connexion->prepare("DELETE FROM utilisateurs WHERE id = :utilisateur_id");
    $supprimerUtilisateur->execute(['utilisateur_id' => $utilisateur_id]);

    // Étape 4 : Détruire la session utilisateur
    session_destroy();

    echo "Vos données personnelles ont été supprimées avec succès.";
} catch (PDOException $e) {
    echo "Erreur lors de la suppression de vos données : " . $e->getMessage();
}
?>
