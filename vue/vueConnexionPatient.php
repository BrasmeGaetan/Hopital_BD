<?php 
include_once 'modele/mesFonctionsAccesBDD.php'; 
$Connexion = connexionBDD();

// Récupérer les genres, auteurs et livres
$genres = getGenre($Connexion)->fetchAll(PDO::FETCH_ASSOC);
$auteurs = getAuteur($Connexion)->fetchAll(PDO::FETCH_ASSOC);
$livres = getLivreFromTitreGenreAuteurDate($Connexion, null, null, null, null, null, null);

// Récupérer les emprunts de l'utilisateur (ajouté pour le retour)
$utilisateur_id = $_SESSION['utilisateur_id'];
$emprunts_query = $Connexion->prepare("SELECT id, titre FROM emprunts WHERE utilisateur_id = :utilisateur_id AND date_retour_effective IS NULL");
$emprunts_query->execute(['utilisateur_id' => $utilisateur_id]);
$emprunts = $emprunts_query->fetchAll(PDO::FETCH_ASSOC);
?>

<body>
<div class="zone-inscription">
    <h1>Emprunter un livre</h1>
    <form action="./index.php?action=emprunt" method="POST">
        <label for="livre">Titre du livre :</label>
        <select id="livre" name="livre" required>
            <option value="">-- Veuillez choisir un livre --</option>
            <?php foreach ($livres as $livre): ?>
                <option value="<?= htmlspecialchars($livre['idlivre']) ?>"><?= htmlspecialchars($livre['titre']) ?> - <?= htmlspecialchars($livre['nom']) ?> <?= htmlspecialchars($livre['prenom']) ?></option>
            <?php endforeach; ?>
        </select>
        <label for="date">Date d'emprunt :</label>
        <input type="date" id="date" name="date" value="<?= date('Y-m-d') ?>" readonly>
        <input type="submit" value="Emprunter">
        <a href="./index.php?action=inscription">Voir tous les emprunts</a>
    </form>
</div>

<!-- Formulaire pour retourner un livre -->
<div class="zone-retour">
    <h1>Retourner un livre</h1>
    <form action="./index.php?action=retour" method="POST">
        <label for="emprunt_id">Sélectionnez un emprunt :</label>
        <select id="emprunt_id" name="emprunt_id" required>
            <option value="">-- Veuillez choisir un emprunt --</option>
            <?php if (!empty($emprunts)): ?>
                <?php foreach ($emprunts as $emprunt): ?>
                    <option value="<?= htmlspecialchars($emprunt['id']) ?>"><?= htmlspecialchars($emprunt['titre']) ?></option>
                <?php endforeach; ?>
            <?php else: ?>
                <option value="">Aucun emprunt trouvé</option>
            <?php endif; ?>
        </select>
        <input type="submit" value="Retourner le livre">
    </form>
</div>

<div class="zone-menu">
    <nav>
        <ul>
            <li><a href="./index.php?action=accueil">Accueil</a></li>
            <li><a href="./index.php?action=livres">Livres</a></li>
            <li><a href="./index.php?action=emprunts">Mes emprunts</a></li>
            <li><a href="./index.php?action=profil">Mon Profil</a></li>
            
            <?php if (isset($_SESSION['utilisateur_id'])): ?>
                <li>
                    <form action="./index.php?action=deconnexion" method="post">
                        <button type="submit">Déconnexion</button>
                    </form>
                </li>
                <li>
                    <form action="./index.php?action=oubli" method="post">
                        <button type="submit">Droit à l'oubli</button>
                    </form>
                </li>
            <?php else: ?>
                <li><a href="./index.php?action=connexion">Connexion</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</div>

</body>
