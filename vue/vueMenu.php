<div class="page-menu">
    <form action="./index.php?action=menu&choix=1" class="zone-menu" method="post" enctype="multipart/form-data">
        <h1>Ajouter un livre</h1>
        <div>
            <label for="titre-livre-saisie">Titre du livre :</label>
            <input type="text" id="titre-livre-saisie" name="zone-saisie-titre" maxlength="100" required />
        </div>
        <div>
            <label for="date-livre-saisie">Date du livre :</label>
            <input type="date" id="date-livre-saisie" name="zone-saisie-date" required />
        </div>
        <div>
            <label for="genre-livre-saisie">Genre du livre :</label>
            <select name="liste-genre-livre" id="genre-livre-saisie" required>
                <option value="">-- Veuillez choisir un genre --</option>
                <?php foreach ($genre as $g) { ?>
                    <option value="<?php echo $g[0]; ?>"><?php echo $g[1]; ?></option>
                <?php } ?>
            </select>
        </div>
        <div>
            <label for="auteur-livre">Auteur du livre :</label>
            <select name="liste-auteur-livre" id="auteur-livre-saisie" required>
                <option value="">-- Veuillez choisir un auteur --</option>
                <?php foreach ($auteur as $a) { ?>
                    <option value="<?php echo $a[0]; ?>"><?php echo $a[1]; ?></option>
                <?php } ?>
            </select>
        </div>
        <div>
            <label for="resume-livre">Résumé du livre :</label>
            <textarea id="resume-livre" name="livre-resume" required></textarea>
        </div>
        <div>
            <label for="cotation-livre">Cotation du Livre :</label>
            <input type="text" id="cotation-livre" name="zone-cotation" maxlength="100" required />
        </div>
        <div>
            <label for="image-livre">Image du Livre :</label>
            <input type="file" id="image-livre" name="zone-image" accept=".png,.jpg" required />
        </div>
        <div>
            <input type="submit" value="Ajouter" />
        </div>
    </form>

    <form action="./index.php?action=menu&choix=2" class="zone-menu" method="post" enctype="multipart/form-data">
        <h1>Modifier un livre</h1>
        <div>
            <label for="id-livre-saisie">Identifiant du livre :</label>
            <input type="text" id="id-livre-saisie" name="zone-saisie-id-update" required />
        </div>
        <div>
            <label for="titre-livre-saisie-update">Titre du livre :</label>
            <input type="text" id="titre-livre-saisie-update" name="zone-saisie-titre-update" maxlength="100" required />
        </div>
        <div>
            <label for="date-livre-saisie-update">Date du livre :</label>
            <input type="date" id="date-livre-saisie-update" name="zone-saisie-date-update" required />
        </div>
        <div>
            <label for="genre-livre-saisie-update">Genre du livre :</label>
            <select name="liste-genre-livre-update" id="genre-livre-saisie-update" required>
                <option value="">-- Veuillez choisir un genre --</option>
                <?php foreach ($genre as $g) { ?>
                    <option value="<?php echo $g[0]; ?>"><?php echo $g[1]; ?></option>
                <?php } ?>
            </select>
        </div>
        <div>
            <label for="auteur-livre-update">Auteur du livre :</label>
            <select name="liste-auteur-livre-update" id="auteur-livre-update" required>
                <option value="">-- Veuillez choisir un auteur --</option>
                <?php foreach ($auteur as $a) { ?>
                    <option value="<?php echo $a[0]; ?>"><?php echo $a[1]; ?></option>
                <?php } ?>
            </select>
        </div>
        <div>
            <label for="resume-livre-update">Résumé du livre :</label>
            <textarea id="resume-livre-update" name="livre-resume-update" required></textarea>
        </div>
        <div>
            <label for="cotation-livre-update">Cotation du Livre :</label>
            <input type="text" id="cotation-livre-update" name="zone-cotation-update" maxlength="100" required />
        </div>
        <div>
            <label for="image-livre-update">Nouvelle Image du Livre (si nécessaire) :</label>
            <input type="file" id="image-livre-update" name="zone-image-update" accept=".png,.jpg" />
        </div>
        <div>
            <input type="submit" value="Modifier" />
        </div>
    </form>

    <div class="zone-menu-ext-cont">
        <form action="./index.php?action=menu&choix=3" class="zone-menu-ext" method="post">
            <h1>Supprimer un livre</h1>
            <div>
                <label for="id-livre-saisie">Identifiant du livre :</label>
                <input type="text" name="id-livre-a-supprimer" id="id-livre-saisie" placeholder="Entrez l'ID du livre à supprimer" required />
            </div>
            <div>
                <input type="submit" value="Supprimer" />
            </div>
        </form>
    </div>

    <div class="zone-menu-ext-cont">
        <form action="./index.php?action=menu&choix=4" method="post">
            <h1>Rechercher les emprunts non retournés</h1>
            <div>
                <label for="delai-emprunt">Délai en jours :</label>
                <input type="number" id="delai-emprunt" name="delai_emprunt" required min="1" />
            </div>
            <div>
                <input type="submit" value="Rechercher" />
            </div>
        </form>
    </div>
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
