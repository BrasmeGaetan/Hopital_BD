<?php
session_start();
include_once 'modele/mesFonctionsAccesBDD.php';

if (!isset($_SESSION['valid']) || !$_SESSION['valid']) {
    echo "Vous devez être connecté pour retourner un livre.";
    include 'vue/vueConnexion.php';
    exit();
}

$bdd = connexionBDD();

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

// Vous pouvez inclure la vue appropriée ici
include 'vue/vueConnexionPatient.php';
