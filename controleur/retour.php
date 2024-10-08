<?php
session_start();
include_once 'modele/mesFonctionsAccesBDD.php';

if (!isset($_SESSION['valid']) || !$_SESSION['valid']) {
    echo "Vous devez être connecté pour retourner un livre.";
    include 'vue/vueConnexion.php';
    exit();
}

$bdd = connexionBDD();

// Récupérer l'utilisateur connecté
$utilisateur_id = $_SESSION['utilisateur_id'];
echo var_dump($utilisateur_id);

// Récupérer les emprunts de l'utilisateur
$emprunts_query = $bdd->prepare("SELECT id, titre FROM emprunts WHERE utilisateur_id = :utilisateur_id AND date_retour_effective IS NULL");
$emprunts_query->execute(['utilisateur_id' => $utilisateur_id]);
$emprunts = $emprunts_query->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $emprunt_id = $_POST['emprunt_id'];
    $date_retour_effective = date('Y-m-d');

    $update_query = $bdd->prepare("UPDATE emprunts SET date_retour_effective = :date_retour WHERE id = :emprunt_id");
    $success = $update_query->execute([
        'date_retour' => $date_retour_effective,
        'emprunt_id' => $emprunt_id,
    ]);
    
    if ($success) {
        echo "Le livre a été retourné avec succès !";
    } else {
        echo "Une erreur est survenue lors du retour du livre.";
    }
}

include 'vue/vueConnexionPatient.php';
