<?php include_once 'modele/mesFonctionsAccesBDD.php'; ?>
<body>
    <div class="zone-inscription">
        <h1>Créer un compte patient</h1>
        <form method="POST" action="./index.php?action=inscription"> 
            <input type="text" name="pseudo" placeholder="Nom" required>
            <input type="text" name="prenom" placeholder="Prénom" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="tel" name="telephone" placeholder="Numéro de téléphone" required>
            <input type="password" name="mdp" placeholder="Mot de passe" required>
            <input type="hidden" name="role" value="2"> 

            
            <div class="conditions-container">
                <input type="checkbox" name="accept_conditions" id="accept_conditions" required>
                <label for="accept_conditions">J'accepte les <a href="./index.php?action=cookies" target="_blank">conditions d'utilisation</a></label>
            </div>

            <input class="btn" type="submit" value="Créer un compte">
        </form>

        <p>
            Déjà un compte ? 
            <a href="./index.php?action=connexion">Se connecter</a> <!-- Redirige vers la page de connexion -->
        </p>
    </div>
</body>
