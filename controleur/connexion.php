<?php
include_once 'modele/mesFonctionsAccesBDD.php';
$bdd = connexionBDD();


$hash = getHash(connexionBDD(),$_POST['pseudo']);
if (isset($_GET["logout"])) {
    unset( $_SESSION['valid'] );
    session_unset();
    session_destroy();
}
if ($hash[0][0] == hash('sha256',$_POST['mdp']) || $_SESSION['valid']) {
    $_SESSION['valid'] = true;
    $Connexion = connexionBDD();
    $genre = getGenre($Connexion)->fetchAll();
    $auteur = getAuteur($Connexion)->fetchAll();
    include "vue/vueMenu.php";
}
else {
    include "vue/vueConnexion.php";
}
