<?php
session_start(); // Démarrer la session

// Détruire la session
unset($_SESSION['valid']);
session_unset();
session_destroy();

// Rediriger vers la page de connexion
header("controleur/connexion.php");
exit();
?>
