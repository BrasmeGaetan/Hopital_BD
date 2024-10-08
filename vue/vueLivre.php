<body class="template-body">
    <div class="description">
      <label for="toggleImages" class="conteneur-image">
        <img src="<?php echo $repReq["image"] ?>" alt="Image 1" class="image-principale" />
      </label>
      <div class="paragraph-book">
        <h2 class="paragraph-book-title"><?php echo $repReq["titre"] ?></h2>
        <div class="zone-description">
          <label for="">Auteur : </label>
          <p>
            <?php echo $repReq["nom"]; echo " ".$repReq["prenom"];?>
          </p>  
        </div>
        <div class="zone-description">
          <label for="">Genre : </label>
          <p>
            <?php echo $repReq["libelle"]?>
          </p>  
        </div>
        <div class="zone-description">
          <label for="">Publication : </label>
          <p>
            <?php echo $repReq["datePublication"]?>
          </p>  
        </div>
        <div class="zone-description">
          <label for="">Cotation : </label>
          <p>
            <?php echo $repReq["cotation"]?>
          </p>  
        </div>
        <p>
          <?php echo $repReq["resumeLivre"] ?>
        </p>
      </div>
    </div>
  </body>