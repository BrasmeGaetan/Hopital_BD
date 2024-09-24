<?php
include_once 'modele/mesFonctionsAccesBDD.php';
$Connexion = connexionBDD();
$genre = getGenre($Connexion)->fetchAll();
$auteur = getAuteur($Connexion)->fetchAll();
$repReq = getLivreFromTitreGenreAuteurDate($Connexion, $_POST['liste-genre-livre'], $_POST['zone-saisie-titre'], $_POST['zone-saisie-date'], $_POST['zone-saisie-auteur'], $_POST['zone-saisie-cotation'], $_POST['zone-saisie-idlivre']);
include "vue/vueChercher.php";