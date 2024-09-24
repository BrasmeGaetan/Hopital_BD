<?php

include_once '../modele/mesFonctionsAccesBDD.php';

$lePdo = connexionBDD();

var_dump(getGenre($lePdo));