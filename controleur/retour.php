<?php
session_start();
include_once 'modele/mesFonctionsAccesBDD.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['valid']) || !$_SESSION['valid']) {
    echo "Vous devez être connecté pour retourner un livre.";
    include 'vue/vueConnexion.php';
    exit();
}

$bdd = connexionBDD();

// Récupérer l'utilisateur connecté
$utilisateur_id = $_SESSION['utilisateur_id'];

// Récupérer les emprunts de l'utilisateur
$emprunts_query = $bdd->prepare("SELECT id, titre FROM emprunts WHERE utilisateur_id = :utilisateur_id AND date_retour_effective IS NULL");
$emprunts_query->execute(['utilisateur_id' => $utilisateur_id]);
$emprunts = $emprunts_query->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $emprunt_id = $_POST['emprunt_id'];
    $date_retour_effective = date('Y-m-d');

    if (empty($emprunt_id)) {
        echo "Aucun emprunt sélectionné.";
        exit();
    }

    $update_query = $bdd->prepare("UPDATE emprunts SET date_retour_effective = :date_retour WHERE id = :emprunt_id");
    $success = $update_query->execute([
        'date_retour' => $date_retour_effective,
        'emprunt_id' => $emprunt_id,
    ]);

    var_dump($emprunt_id); // Pour déboguer
    var_dump($success); // Pour déboguer
    
    if ($success) {
        echo "Le livre a été retourné avec succès !";
        include 'vue/vueConnexionPatient.php';
        exit();
    } else {
        echo "Une erreur est survenue lors du retour du livre.";
    }
}

include 'vue/vueConnexionPatient.php';
?>
