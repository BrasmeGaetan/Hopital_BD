<?php
include "mesFonctionsAccesBDD.php";

$backup_dir = "backup";
$backup_file = $backup_dir . $bdd . "_" . date('Y-m-d') . ".sql";

backup($bdd, $host, $user, $password);
?>
