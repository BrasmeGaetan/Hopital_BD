<?php

//  Partie d'appel au modèle si besoin 
include_once 'modele/mesFonctionsAccesBDD.php';
// Partie de traitement des données récupérées si besoin pour mise à disposition de la vue
$repReq = getLivre(connexionBDD(),intval($_GET["demande"],10));
// appel du script de vue qui permet de gerer l'affichage des donnees
include "vue/vueLivre.php";