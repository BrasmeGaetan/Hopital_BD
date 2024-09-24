<?php
include_once 'modele/mesFonctionsAccesBDD.php';

//  Partie d'appel au modèle si besoin 
$bdd = connexionBDD();

// Partie de traitement des données récupérées si besoin pour mise à disposition de la vue

if (!empty($_POST["critere-recherche"])) {
    $id = $_POST["critere-recherche"];
}else{
    $id = null;
}
$categories = array("idlivre","titre","nom","prenom","LEFT(resumeLivre, 50)");
$donnees = getLivresInfo($bdd,$id);

// appel du script de vue qui permet de gerer l'affichage des donnees
include "vue/vueAccueil.php";