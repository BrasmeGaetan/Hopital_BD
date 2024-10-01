<?php include_once 'modele/mesFonctionsAccesBDD.php'; ?>
<body>
    <div class="zone-connexion">
        <h1>Connexion</h1>
        <form method="post" action="connexion.php"> <!-- Assurez-vous que 'connexion.php' est le bon fichier pour traiter la connexion -->
            <input type="text" name="pseudo" placeholder="Identifiant" required>
            <input type="password" name="mdp" placeholder="Mot de Passe" required>
            <input class="btn" type="submit" value="Se connecter">
        </form>
        
        <p>
            Pas encore de compte ? 
            <a href="./index.php?action=inscription">Créer un compte</a> <!-- Redirection vers la page d'inscription -->
        </p>
    </div>
</body>


