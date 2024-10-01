<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="style.css"> <!-- Ajoute ton propre CSS -->
</head>
<body>
    <h2>Créer un compte patient</h2>
    <form method="POST" action="traitement_inscription.php"> <!-- Spécifie le fichier qui traitera l'inscription -->
        <label for="pseudo">Pseudo :</label>
        <input type="text" id="pseudo" name="pseudo" required>

        <label for="mdp">Mot de passe :</label>
        <input type="password" id="mdp" name="mdp" required>

        <button type="submit">Créer un compte</button>
    </form>

    <p>
        Déjà un compte ? 
        <a href="./index.php?action=connexion">Se connecter</a> <!-- Redirige vers la page de connexion -->
    </p>
</body>
</html>