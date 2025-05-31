<?php

include_once "./modele/mesFonctionAccesBDD.php";
if (!isConnected()) {
    include "vue/vueConnexion.php";
    return;
}


if ($_SESSION['loginName'] != null){
    $conn = connexionBDD();
   $response =  getData($conn,$_SESSION['loginName']);
   
   $data = [];
   $data["mail"]=$response[0][1];
   $data["login"]=$response[0][0];
   ;
   file_put_contents("./json/".$response[0][0].".json",json_encode($data));

   $link = realpath("./json/");

   $link = $link."\\".$response[0][0].".json";

   $hash = hash_file("sha256",$link);

   include "./vue/vueTelechargerDonnees.php";

}

?>