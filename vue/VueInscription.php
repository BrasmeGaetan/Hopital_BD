<div class="zone-inscription">
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
</div>
</html>