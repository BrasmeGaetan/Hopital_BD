<?php include_once 'modele/mesFonctionsAccesBDD.php'; ?>
<div class="page-recherche">
    <form class="zone-recherche" method="post">
        <h1>Zone de recherche</h1>
        <div class="titre-livre-saisie">
            <label class="label-titre-livre-saisie" for="titre-livre-saisie">Titre du livre :</label>
            <input class="input-titre-livre-saisie" type="text" id="titre-livre-saisie" name="zone-saisie-titre" maxlength="100" />
        </div>
        <div>
            <label for="auteur-livre">Auteur du livre :</label>
            <select name="zone-saisie-auteur" id="zone-saisie-auteur">
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
        <div class="date-livre-saisie">
            <label class="label-date-livre-saisie" for="date-livre-saisie">Date du livre :</label>
            <input class="input-date-livre-saisie" type="date" id="date-livre-saisie" name="zone-saisie-date" maxlength="100" />
        </div>
        <div class="id-livre-saisie">
            <label class="label-id-livre-saisie" for="id-livre-saisie">Référence du livre :</label>
            <input class="input-id-livre-saisie" type="text" id="zone-saisie-idlivre" name="zone-saisie-idlivre" maxlength="100" />
        </div>
        <div class="cotation-livre-saisie">
            <label class="label-cotation-livre-saisie" for="label-cotation-livre-saisie">Cotation du livre :</label>
            <input class="input-cotation-livre-saisie" type="text" id="cotation-livre-saisie" name="zone-saisie-cotation" maxlength="100" />
        </div>
        <div class="genre-livre-saisie">
            <label class="label-genre-livre-saisie" for="genre-livre-saisie">Genre du livre :</label>
            <select class="select-genre-livre-saisie" name="liste-genre-livre" id="genre-livre-saisie">
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
          <input type="submit" value="Rechercher" />
        </div>
    </form>
    <div class="resultat-recherche">
        <div class="conteneur-recherche">
            <ul class="resultat-recherche-liste">
                <li>
                    <div>
                        <div>
                            <p>Référence du Livre</p>
                        </div>
                        <div>
                            <p>Titre du Livre</p>
                        </div>
                        <div>
                            <p>Auteur du Livre</p>
                        </div>
                        <div>
                            <p>Synopsis du Livre</p>
                        </div>
                    </div>
                </li>
                <?php
                if (isset($repReq) and !empty($repReq)) {
                    for ($i = 0; $i < count($repReq); $i++) { ?>
                        <li>
                            <a href="./index.php?action=livre&demande=<?php echo $repReq[$i]['idlivre']; ?>">
                                <div>
                                    <p><?php echo $repReq[$i]['idlivre'] ?></p>
                                </div>
                                <div>
                                    <p><?php echo $repReq[$i]['titre'] ?></p>
                                </div>
                                <div>
                                    <p><?php echo $repReq[$i]['nom'] . " " . $repReq[$i]['prenom'] ?></p>
                                </div>
                                <div>
                                    <p><?php echo substr($repReq[$i]['resumeLivre'], 0, 50) . "..." ?></p>
                                </div>
                            </a>
                        </li>
                <?php }
                } ?>
            </ul>
        </div>
    </div>
</div>