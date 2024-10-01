<body>
    <div class="accueil-body">
        <div>
            <form method="post" class="zone-tri">
                <h1>Recherche</h1>
                <div class="critere-recherche">
                    <label for="critere-recherche">Critère de recherche</label>
                    <select name="critere-recherche" id="critere-recherche">
                        <div class="option">
                            <option value="">-- Veuillez choisir un critère de recherche --</option>
                            <option value="1">Référence</option>
                            <option value="2">Titre</option>
                            <option value="3">Auteur</option>
                            <option value="4">Résumé</option>
                        </div>
                    </select>
                </div>
                <div>
                    <input type="submit" value="Trier les résultats"></input>
                </div>
            </form>
        </div>
        <div>
            <ul class="listePrincipale">
                <?php
                $currentGenre = $donnees[0]['libelle'];
                ?>
                <li class="categorie-accueil">
                    <a href="#" class="titreCategorie"><?php echo $donnees[0]['libelle'] ?></a>
                    <ul class="sousCategories">
                        <?php
                        for ($i = 0; $i < count($donnees); $i++) {
                            if ($donnees[$i]['libelle'] != $currentGenre) { ?>
                    </ul>
                </li>
                <li class="categorie-accueil">
                    <a href="#" class="titreCategorie"><?php echo $donnees[$i]['libelle'] ?></a>
                    <ul class="sousCategories">
                    <?php
                                $currentGenre = $donnees[$i]['libelle'];
                            }
                    ?><li><a class="liste-items" href="./index.php?action=livre&demande=<?php echo $donnees[$i]['idlivre']; ?>"><?php for ($x = 0; $x < count($categories); $x++) { ?>
                                <p><?php echo $donnees[$i][$categories[$x]] ?></p>
                            <?php } ?>

                    </li></a><?php
                            }
                                ?>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</body>