<?php include_once 'modele/mesFonctionsAccesBDD.php'; ?>

<body>
    <div class="zone-connexion">
        <h1>Connexion</h1>
        <form method="post">
            <input type="text" name="pseudo" placeholder="Identifiant" required>
            <input type="password" name="mdp" placeholder="Mot de Passe" required>
            <input type="submit" value="Se connecter">
        </form>

        <!-- Lien vers la page d'inscription -->
        <p>
            Pas encore de compte ? 
            <a href="inscription.php">Créer un compte</a> <!-- Redirection vers la page d'inscription -->
        </p>
    </div>
</body>
