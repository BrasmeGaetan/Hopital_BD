<?php include_once 'modele/mesFonctionsAccesBDD.php'; ?>
<body>
    <div class="zone-inscription">
        <h1>Créer un compte patient</h1>
        <form method="POST" action="./index.php?action=inscription"> <!-- Spécifie le fichier qui traitera l'inscription -->
        <input type="text" name="pseudo" placeholder="Nom" required>
            <input type="text" name="prenom" placeholder="Prénom" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="tel" name="telephone" placeholder="Numéro de téléphone" required>
            <input type="password" name="mdp" placeholder="Mot de passe" required>
            <input type="hidden" name="role" value="1"> <!-- Champ caché pour le rôle -->
            <input class="btn" type="submit" value="Créer un compte">
        </form>

        <p>
            Déjà un compte ? 
            <a href="./index.php?action=connexion">Se connecter</a> <!-- Redirige vers la page de connexion -->
        </p>
    </div>
</body>
