<?php
include_once 'modele/mesFonctionsAccesBDD.php';

session_start(); // Initialisation de la session

$bdd = connexionBDD(); // Connexion à la base de données

$tournees = tournee($bdd);
var_dump()
?>
