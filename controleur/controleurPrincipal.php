<?php

function controleurPrincipal($action){
    $lesActions = array();
    $lesActions["livre"] = "livre.php";
    $lesActions["defaut"] = "accueil.php";
    $lesActions["chercher"] = "chercher.php";
    $lesActions["livres"] = "livres.php";
    $lesActions["cookies"] = "cookies.php";
    $lesActions["contact"] = "contact.php";
    $lesActions["connexion"] = "connexion.php";
    $lesActions["menu"] = "menu.php";
    $lesActions["inscription"] = "inscription.php";
    $lesActions["emprunt"] = "emprunt.php";
    $lesActions["retour"] = "retour.php";
    $lesActions["oubli"] = "oubli.php";
    $lesActions["tournee"] = "tournee.php";

    if (array_key_exists ( $action , $lesActions )){
        return $lesActions[$action];
    }
    else{
        return $lesActions["defaut"];
    }

}