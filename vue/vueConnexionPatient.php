<?php include_once 'modele/mesFonctionsAccesBDD.php'; ?>

<body>

    <div class="form-container">
        <h1>Emprunter un livre</h1>
        <form action="emprunter_livre.php" method="POST">
            <label for="titre">Titre du livre :</label>
            <input type="text" id="titre" name="titre" required>

            <label for="date">Date d'emprunt :</label>
            <input type="date" id="date" name="date" required>

            <label for="genre">Genre du livre :</label>
            <select id="genre" name="genre" required>
                <option value="">-- Veuillez choisir un genre --</option>
                <option value="roman">Manga</option>
                <option value="essai">Documentaire</option>
                <option value="biographie">Bande dessine</option>
                <option value="science-fiction">Science-fiction</option>
                <option value="fantasy">Roman</option>
            </select>

            <label for="auteur">Auteur du livre :</label>
            <select id="auteur" name="auteur" required>
                <option value="">-- Veuillez choisir un auteur --</option>
                <option value="auteur1">Auteur 1</option>
                <option value="auteur2">Auteur 2</option>
                <option value="auteur3">Auteur 3</option>
            </select>

            <label for="dateRetour">Date de retour prévue :</label>
            <input type="date" id="dateRetour" name="dateRetour" required>

            <input type="submit" value="Emprunter">
        </form>
    </div>

</body>