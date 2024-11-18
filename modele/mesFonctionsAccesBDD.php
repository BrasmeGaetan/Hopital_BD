<?php
function connexionBDD()
{
    try {
        include("autre/configDB.php");
        $ObjConnexion = new PDO(
            $bdd,
            $user,
            $password,
            array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
            )
        );
    } catch (PDOException $e) {

        echo $e->getMessage();
    }
    return $ObjConnexion;
}

function getGenre(PDO $Connexion)
{
    $requete = 'SELECT * FROM typelivre';
    $repReq = $Connexion->prepare($requete);
    $repReq->execute();
    return $repReq;
}
function getAuteur(PDO $Connexion)
{
    $requete = 'SELECT * FROM auteur ORDER BY nom';
    $repReq = $Connexion->prepare($requete);
    $repReq->execute();
    return $repReq;
}
function getId(PDO $Connexion)
{
    $requete = 'SELECT * FROM livre ORDER BY nom';
    $repReq = $Connexion->prepare($requete);
    $repReq->execute();
    return $repReq;
}

function getLivreFromTitreGenreAuteurDate($Connexion, $genre, $titre, $datePublication, $auteur, $cotation, $idlivre)
{
    $requete = 'SELECT titre, nom, prenom, resumeLivre,cotation,idlivre FROM livre JOIN auteur ON auteur.idauteur = livre.auteur WHERE 1=1';
    if (!empty($titre)) {
        $requete .= ' AND titre LIKE :titre';
    }
    if (!empty($genre)) {
        $requete .= ' AND genre = :genre';
    }
    if (!empty($idlivre)) {
        $requete .= ' AND idlivre = :idlivre';
    }
    if (!empty($auteur)) {
        $requete .= ' AND idauteur = :auteur';
    }
    if (!empty($datePublication)) {
        $requete .= ' AND datePublication = :datePublication';
    }
    if (!empty($cotation)) {
        $requete .= ' AND cotation = :cotation';
    }
    $requete .= ' ORDER BY titre;';
    echo $auteur;
    $repReq = $Connexion->prepare($requete);
    if (!empty($titre)) {
        $repReq->bindValue(':titre', "%" . $titre . "%", PDO::PARAM_STR);
    }
    if (!empty($genre)) {
        $repReq->bindValue(':genre', $genre, PDO::PARAM_INT);
    }
    if (!empty($idlivre)) {
        $repReq->bindValue(':idlivre', $idlivre, PDO::PARAM_INT);
    }
    if (!empty($auteur)) {
        $repReq->bindValue(':auteur', $auteur, PDO::PARAM_INT);
    }
    if (!empty($datePublication)) {

        $repReq->bindValue(':datePublication', $datePublication, PDO::PARAM_STR);
    }
    if (!empty($cotation)) {
        $repReq->bindValue(':cotation', $cotation, PDO::PARAM_STR);
    }
    $repReq->execute();
    return $repReq->fetchAll(PDO::FETCH_ASSOC);
}

function getLivresInfo($Connexion, $tri)
{
    $requete = 'SELECT idlivre,titre,LEFT(resumeLivre, 50),nom,prenom,libelle FROM livre JOIN typelivre ON typelivre.idtype = livre.genre JOIN auteur ON auteur.idauteur = livre.auteur ORDER BY genre';
    switch ($tri) {
        case 1:
            $requete .= ",idlivre";
            break;

        case 2:
            $requete .= ",titre";
            break;

        case 3:
            $requete .= ",nom";
            break;

        case 4:
            $requete .= ",LEFT(resumeLivre, 50)";
            break;

        default:
            break;
    }
    $repReq = $Connexion->prepare($requete);
    $repReq->execute();
    return $repReq->fetchAll(PDO::FETCH_ASSOC);
}

function getLivre($Connexion, $id)
{
    $requete = 'SELECT titre,resumeLivre,image,libelle,nom,prenom,datePublication,cotation FROM livre JOIN typelivre ON typelivre.idtype = livre.genre JOIN auteur ON auteur.idauteur = livre.auteur WHERE idlivre=:id';
    $repReq = $Connexion->prepare($requete);
    $repReq->bindValue(':id', $id, PDO::PARAM_INT);
    $repReq->execute();
    return $repReq->fetch(PDO::FETCH_ASSOC);
}

function ajouterLivre($bdd, $titre,  $idgenre, $idauteur, $resumeLivre, $datePublication, $cotation, $imagePath)
{
    $requete = "INSERT INTO livre (`titre`, `genre`, `auteur`, `resumeLivre`, `datePublication`, `cotation`, `image`) VALUES (:titre, :genre, :auteur, :resumeLivre, :datePublication, :cotation, :imagePath)";
    $repReq = $bdd->prepare($requete);
    $repReq->bindValue(':titre', $titre, PDO::PARAM_STR);
    $repReq->bindValue(':genre', $idgenre, PDO::PARAM_INT);
    $repReq->bindValue(':auteur', $idauteur, PDO::PARAM_INT);
    $repReq->bindValue(':resumeLivre', $resumeLivre, PDO::PARAM_STR);
    $repReq->bindValue(':datePublication', $datePublication, PDO::PARAM_STR);
    $repReq->bindValue(':cotation', $cotation, PDO::PARAM_STR);
    $repReq->bindValue(':imagePath', $imagePath, PDO::PARAM_STR);
    $repReq->execute();
}

function supprimerLivre($bdd, $idlivre) {
    $requete = "DELETE FROM livre WHERE idlivre = :idlivre";
    $repReq = $bdd->prepare($requete);
    $repReq->bindValue(':idlivre', $idlivre, PDO::PARAM_INT);
    return $repReq->execute();
}
function modifierLivre($bdd, $id, $titre,  $idgenre, $idauteur, $resumeLivre, $datePublication, $cotation, $imagePath)
{
    $requete = "UPDATE livre SET ";
    if (!empty($titre)) {
        $requete = $requete . "titre = :titre,";
    }
    if (!empty($idgenre) || $idgenre == 0) {
        $requete = $requete . "genre = :genre,";
    }
    if (!empty($idauteur) || $idauteur == 0) {
        $requete = $requete . "auteur = :auteur,";
    }
    if (!empty($resumeLivre)) {
        $requete = $requete . "resumeLivre = :resumeLivre,";
    }
    if (!empty($datePublication)) {
        $requete = $requete . "datePublication = :datePublication,";
    }
    if (!empty($cotation) || $cotation == 0) {
        $requete = $requete . "cotation = :cotation,";
    }
    if (!empty($imagePath)) {
        $requete = $requete . "image = :image,";
    }
    $requete = substr($requete, 0, -1);
    $requete = $requete . " WHERE idlivre = :id";
    $repReq = $bdd->prepare($requete);
    $repReq->bindValue(':id', $id, PDO::PARAM_INT);
    if (!empty($titre)) {
        $repReq->bindValue(':titre', $titre, PDO::PARAM_STR);
    }
    if (!empty($idgenre) || $idgenre == 0) {
        $repReq->bindValue(':genre', $idgenre, PDO::PARAM_INT);
    }
    if (!empty($idauteur) || $idauteur == 0) {
        $repReq->bindValue(':auteur', $idauteur, PDO::PARAM_INT);
    }
    if (!empty($resumeLivre)) {
        $repReq->bindValue(':resumeLivre', $resumeLivre, PDO::PARAM_STR);
    }
    if (!empty($datePublication)) {
        $repReq->bindValue(':datePublication', $datePublication, PDO::PARAM_STR);
    }
    if (!empty($cotation) || $cotation == 0) {
        $repReq->bindValue(':cotation', $cotation, PDO::PARAM_STR);
    }
    if (!empty($imagePath)) {
        $repReq->bindValue(':image', $imagePath, PDO::PARAM_STR);
    }
    $repReq->execute();
}

function getUser($bdd, $pseudo) {
    $requete = $bdd->prepare("SELECT pseudo, mdp, roles, id FROM utilisateurs WHERE pseudo = :pseudo");
    $requete->execute(['pseudo' => $pseudo]);
    
    $user = $requete->fetch(PDO::FETCH_ASSOC);
    
    if ($user === false) {
        echo "Aucun utilisateur trouvé avec ce pseudo.";
    }
    
    return $user;
}





function userExists($bdd, $pseudo) {
    $stmt = $bdd->prepare("SELECT COUNT(*) FROM utilisateurs WHERE pseudo = ?");
    $stmt->execute([$pseudo]);
    return $stmt->fetchColumn() > 0; // Retourne true si le pseudo existe déjà
}

function backup($bdd, $host,$user, $password){
    $requete_backup = $bdd->prepare("mysqldump --opt --host=$host --user=$user --password=$password dblogin5261 > backup");
    $output = null;
    $return_var = null;
    exec($requete_backup, $output, $return_var);
    
    if($return_var == 0){
        echo "Backup réussie !";
    }else{
        echo "Erreur lors du backup";
    }
}
function sauvegarderUtilisateur($bdd, $utilisateur_id) {
    try {
        // Récupérer les données utilisateur
        $requete = $bdd->prepare("SELECT * FROM utilisateurs WHERE id = :id");
        $requete->execute(['id' => $utilisateur_id]);
        $utilisateur = $requete->fetch(PDO::FETCH_ASSOC);

        if ($utilisateur) {
            // Créer un fichier JSON pour sauvegarder les données
            $backupDir = 'backups/';
            if (!is_dir($backupDir)) {
                mkdir($backupDir, 0755, true); // Créer le dossier si nécessaire
            }
            $backupFile = $backupDir . 'user_' . $utilisateur_id . '_' . date('Y-m-d_H-i-s') . '.json';
            file_put_contents($backupFile, json_encode($utilisateur));

            
        }
    } catch (Exception $e) {
        echo "Erreur lors de la sauvegarde des données : " . $e->getMessage() . "<br>";
    }
}
/* SELECT emprunts.id,livre.titre,utilisateurs.pseudo,date_emprunt,date_retour_prevue from emprunts JOIN livre.idlivre = emprunt.idlivre 
Join utilisateurs ON utilisateurs.id = emprunt.utilisateur_id 
where DATE_ADD(dateEmprunt, Interval 26 DAY) <= '2024-10-10' AND date_retour_effective is NULL; */


