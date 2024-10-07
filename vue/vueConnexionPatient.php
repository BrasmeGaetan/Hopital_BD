<?php 
include_once 'modele/mesFonctionsAccesBDD.php'; 
$Connexion = connexionBDD(); // Assure-toi que cette fonction est bien définie pour la connexion à la base

// Récupérer les genres, auteurs et livres
$genres = getGenre($Connexion)->fetchAll(PDO::FETCH_ASSOC);
$auteurs = getAuteur($Connexion)->fetchAll(PDO::FETCH_ASSOC);
$livres = getLivreFromTitreGenreAuteurDate($Connexion, null, null, null, null, null, null); // Récupère tous les livres
?>

<body>
<div class="zone-inscription">
        <h1>Emprunter un livre</h1>
        <form action="./index.php?action=emprunt" method="POST">
            <!-- Titre du livre -->
            <label for="livre">Titre du livre :</label>
            <select id="livre" name="livre" required>
                <option value="">-- Veuillez choisir un livre --</option>
                <?php foreach ($livres as $livre): ?>
                    <option value="<?= htmlspecialchars($livre['idlivre']) ?>"><?= htmlspecialchars($livre['titre']) ?> - <?= htmlspecialchars($livre['nom']) ?> <?= htmlspecialchars($livre['prenom']) ?></option>
                <?php endforeach; ?>
            </select>

            <!-- Date d'emprunt -->
            <label for="date">Date d'emprunt :</label>
            <input type="date" id="date" name="date" required>

            <!-- Genre du livre -->
            <label for="genre">Genre du livre :</label>
            <select id="genre" name="genre" required>
                <option value="">-- Veuillez choisir un genre --</option>
                <?php foreach ($genres as $genre): ?>
                    <option value="<?= htmlspecialchars($genre['idtype']) ?>"><?= htmlspecialchars($genre['libelle']) ?></option>
                <?php endforeach; ?>
            </select>

            <!-- Auteur du livre -->
            <label for="auteur">Auteur du livre :</label>
            <select id="auteur" name="auteur" required>
                <option value="">-- Veuillez choisir un auteur --</option>
                <?php foreach ($auteurs as $auteur): ?>
                    <option value="<?= htmlspecialchars($auteur['idauteur']) ?>"><?= htmlspecialchars($auteur['nom']) ?> <?= htmlspecialchars($auteur['prenom']) ?></option>
                <?php endforeach; ?>
            </select>

            <!-- Date de retour prévue -->
            <label for="dateRetour">Date de retour prévue :</label>
            <input type="date" id="dateRetour" name="dateRetour" required>

            <input type="submit" value="Emprunter">
        </form>
    </div>
</body>
