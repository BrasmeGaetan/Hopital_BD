<?php include_once 'modele/mesFonctionsAccesBDD.php'; ?>

<body>
    <div class="connexionPatient">
        <form method="post" action="./index.php?action=connexion">
            Quelle livre souhaitez vous emprunter ?
            <input type="text" name="pseudo" placeholder="Identifiant" required>
            <input class="btn" type="submit" value="Se connecter">
        </form>
    </div>
</body>