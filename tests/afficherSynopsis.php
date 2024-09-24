<?php
// Inclure la logique pour récupérer le synopsis à partir de l'ID du livre
// Assurez-vous d'avoir l'ID du livre via $_GET['idLivre'] ou une méthode similaire
$synopsis = "Le synopsis du livre ici..."; 

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Synopsis du Livre</title>
</head>
<body>
    <h1>Synopsis du Livre</h1>
    <p><?php echo $synopsis; ?></p>
    <button onclick="window.print();">Imprimer / Enregistrer en PDF</button>
</body>
</html>

