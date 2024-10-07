

<div class="page-menu">
    <form action="./index.php?action=menu&choix=<?php echo 1 ?>" class="zone-menu" method="post" enctype="multipart/form-data">
        <h1>Ajouter un livre</h1>
        <div>
            <label for="titre-livre-saisie">Titre du livre :</label>
            <input type="text" id="titre-livre-saisie" name="zone-saisie-titre" maxlength="100" />
        </div>
        <div>
            <label for="date-livre-saisie">Date du livre :</label>
            <input type="date" id="date-livre-saisie" name="zone-saisie-date" maxlength="100" />
        </div>
        <div>
            <label for="genre-livre-saisie">Genre du livre :</label>
            <select name="liste-genre-livre" id="genre-livre-saisie">
                <option value="">-- Veuillez choisir un genre --</option>
                <?php
                for ($i = 0; $i < count($genre); $i++) { ?>
                    <option value="<?php echo $genre[$i][0]; ?>">
                        <?php echo $genre[$i][1]; ?>
                    </option>
                <?php }
                ?>
            </select>
        </div>
        <div>
            <label for="auteur-livre">Auteur du livre :</label>
            <select name="liste-auteur-livre" id="auteur-livre-saisie">
                <option value="">-- Veuillez choisir un auteur --</option>
                <?php
                for ($i = 0; $i < count($auteur); $i++) { ?>
                    <option value="<?php echo $auteur[$i][0]; ?>">
                        <?php echo $auteur[$i][1]; ?>
                    </option>
                <?php }
                ?>
            </select>
        </div>

        <div>
            <label for="resume-livre"> Resume du livre :</label>
            <textarea type="textarea" id="resume-livre" name="livre-resume"></textarea>
        </div>
        <div>
            <label for="cotation-livre">Cotation du Livre :</label>
            <input type="text" id="cotation-livre" name="zone-cotation" maxlength="100" />
        </div>
        <div>
            <label for="image-livre">Image du Livre :</label>
            <input type="file" id="image-livre" name="zone-image" maxlength="100" accept=".png,.jpg" />
        </div>
        <div>
            <input type="submit" value="Ajouter" />
        </div>
    </form>
    <form action="./index.php?action=menu&choix=<?php echo 2 ?>" class="zone-menu" method="post" enctype="multipart/form-data">
        <h1>Modifier un livre</h1>
        <div>
            <label for="id-livre-saisie">Identifiant du livre :</label>
            <input type="text" id="id-livre-saisie" name="zone-saisie-id-update">
        </div>
        <div>
            <label for="titre-livre-saisie">Titre du livre :</label>
            <input type="text" id="titre-livre-saisie" name="zone-saisie-titre-update" maxlength="100" />
        </div>
        <div>
            <label for="date-livre-saisie">Date du livre :</label>
            <input type="date" id="date-livre-saisie" name="zone-saisie-date-update" maxlength="100" />
        </div>
        <div>
            <label for="genre-livre-saisie">Genre du livre :</label>
            <select name="liste-genre-livre-update" id="genre-livre-saisie">
                <option value="">-- Veuillez choisir un genre --</option>
                <?php
                for ($i = 0; $i < count($genre); $i++) { ?>
                    <option value="<?php echo $genre[$i][0]; ?>">
                        <?php echo $genre[$i][1]; ?>
                    </option>
                <?php }
                ?>
            </select>
        </div>
        <div>
            <label for="auteur-livre">Auteur du livre :</label>
            <select name="liste-auteur-livre-update" id="auteur-livre-saisie">
                <option value="">-- Veuillez choisir un auteur --</option>
                <?php
                for ($i = 0; $i < count($auteur); $i++) { ?>
                    <option value="<?php echo $auteur[$i][0]; ?>">
                        <?php echo $auteur[$i][1]; ?>
                    </option>
                <?php }
                ?>
            </select>
        </div>

        <div>
            <label for="resume-livre"> Resume du livre :</label>
            <textarea type="textarea" id="resume-livre" name="livre-resume-update"></textarea>
        </div>
        <div>
            <label for="cotation-livre">Cotation du Livre :</label>
            <input type="text" id="cotation-livre" name="zone-cotation-update" maxlength="100" />
        </div>
        <div>
            <label for="image-livre">Image du Livre :</label>
            <input type="file" id="image-livre" name="zone-image-update" maxlength="100" accept=".png,.jpg" />
        </div>
        <div>
            <input type="submit" value="Ajouter" />
        </div>
    </form>

</div>
<div class="zone-menu-ext-cont">
    <form action="./index.php?action=menu&choix=3" class="zone-menu-ext" method="post" enctype="multipart/form-data">
            <h1>Supprimer un livre</h1>
            <div>
                <label for="id-livre-saisie">Identifiant du livre :</label>
                <input type="text" name="id-livre-a-supprimer" id="id-livre-saisie" placeholder="Entrez l'ID du livre à supprimer">
            </div>
            <div>
                <input type="submit" value="Supprimer" />
            </div>
    </form>
</div>
