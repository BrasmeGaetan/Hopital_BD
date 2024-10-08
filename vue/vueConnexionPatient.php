<?php 
include_once 'modele/mesFonctionsAccesBDD.php'; 
$Connexion = connexionBDD();

// Récupérer les genres, auteurs et livres
$genres = getGenre($Connexion)->fetchAll(PDO::FETCH_ASSOC);
$auteurs = getAuteur($Connexion)->fetchAll(PDO::FETCH_ASSOC);
$livres = getLivreFromTitreGenreAuteurDate($Connexion, null, null, null, null, null, null);
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
        <a href="./index.php?action=inscription">Voir tous les emprunts : </a>
    </form>
</div>

<!-- Formulaire pour retourner un livre -->
<div class="zone-retour">
    <h1>Retourner un livre</h1>
    <form action="./index.php?action=retour" method="POST">
        <label for="emprunt_id">Sélectionnez un emprunt :</label>
        <select id="emprunt_id" name="emprunt_id" required>
            <option value="">-- Veuillez choisir un emprunt --</option>
            <?php foreach ($emprunts as $emprunt): ?>
                <option value="<?= htmlspecialchars($emprunt['id']) ?>"><?= htmlspecialchars($emprunt['titre']) ?></option>
            <?php endforeach; ?>
        </select>
        <input type="submit" value="Retourner le livre">
    </form>
</div>
</body>
