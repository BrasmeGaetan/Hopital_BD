<?php

function controleurPrincipal($action){
    $lesActions = array();
    $lesActions["defaut"] = "accueil.php";
    $lesActions["chercher"] = "chercher.php";
    $lesActions["livres"] = "livres.php";
    $lesActions["cookies"] = "cookies.php";
    $lesActions["contact"] = "contact.php";
    $lesActions["connexion"] = "connexion.php";
    $lesActions["menu"] = "menu.php";
    $lesActions["inscription"] = "inscription.php";

    if (array_key_exists ( $action , $lesActions )){
        return $lesActions[$action];
    }
    else{
        return $lesActions["defaut"];
    }

}