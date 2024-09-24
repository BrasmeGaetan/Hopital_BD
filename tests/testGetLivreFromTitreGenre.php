<?php

include_once '../modele/mesFonctionsAccesBDD.php';

$lePdo = connexionBDD();

var_dump(getLivreFromTitreGenre($lePdo,1,null));
var_dump(getLivreFromTitreGenre($lePdo,null,"Dragon"));
var_dump(getLivreFromTitreGenre($lePdo,1,"Dragon"));

$var = "";
var_dump(isset($var));