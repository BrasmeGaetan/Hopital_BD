<?php

function controleurPrincipal($action){
    $lesActions = array();
    $lesActions["defaut"] = "accueil.php";
    $lesActions["chercher"] = "chercher.php";
    $lesActions["livre"] = "livre.php";
    $lesActions["contact"] = "contact.php";
    $lesActions["connexion"] = "connexion.php";
    $lesActions["menu"] = "menu.php";

    if (array_key_exists ( $action , $lesActions )){
        return $lesActions[$action];
    }
    else{
        return $lesActions["defaut"];
    }

}