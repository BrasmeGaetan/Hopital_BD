<?php include_once 'modele/mesFonctionsAccesBDD.php'; ?>
<body>
    <div class="zone-inscription">
        <h1>Créer un compte patient</h1>
        <form method="POST" action="traitement_inscription.php"> <!-- Spécifie le fichier qui traitera l'inscription -->
            <input type="text" name="pseudo" placeholder="Prenom" required>
            <input type="text" name="nom" placeholder="Nom" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="tel" name="numero" placeholder="Numéro de téléphone" required>
            <input type="password" name="mdp" placeholder="Mot de passe" required>
            <input class="btn" type="submit" value="Créer un compte">
        </form>

        <p>
            Déjà un compte ? 
            <a href="./index.php?action=connexion">Se connecter</a> <!-- Redirige vers la page de connexion -->
        </p>
    </div>
</body>
