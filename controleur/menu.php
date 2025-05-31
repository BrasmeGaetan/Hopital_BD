<?php
session_start(); // Démarre la session pour vérifier les variables de session

include_once 'modele/mesFonctionsAccesBDD.php';

// Vérification si l'utilisateur est connecté et a le rôle 1
if (!isset($_SESSION['valid']) || $_SESSION['valid'] !== true || $_SESSION['roles'] != 1) {
    echo "Accès non autorisé.";
    include "vue/vueConnexion.php";
    exit(); // Stoppe l'exécution du script
}

$Connexion = connexionBDD();

if ($_GET["choix"] == 1) {
    if (!empty($_POST['zone-saisie-titre']) && !empty($_POST['liste-auteur-livre']) && !empty($_POST['liste-genre-livre']) && !empty($_POST['zone-saisie-date']) && !empty($_POST['zone-cotation']) && !empty($_POST["livre-resume"]) && !empty($_FILES["zone-image"]["name"])) {
        $target_dir = "img/";
        $target_file = $target_dir . basename($_FILES["zone-image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["zone-image"]["tmp_name"]);
        
        if ($check !== false) {
            $titre = $_POST['zone-saisie-titre'];
            $datePublication = $_POST['zone-saisie-date'];
            $cotation = $_POST['zone-cotation'];
            $resumeLivre = $_POST['livre-resume'];
            $idauteur = $_POST['liste-auteur-livre'];
            $idgenre = $_POST['liste-genre-livre'];
            
            if (!move_uploaded_file($_FILES["zone-image"]["tmp_name"], $target_file)) {
                echo '<script>alert("Erreur lors du téléchargement de l\'image")</script>';
            } else {
                ajouterLivre($Connexion, $titre,  $idgenre, $idauteur, $resumeLivre, $datePublication, $cotation, $target_file);
            }
        } else {
            echo '<script>alert("Le fichier téléchargé n\'est pas une image valide")</script>';
        }
    } else {
        echo '<script>alert("Veuillez remplir chaque champ")</script>';
    }
} else if ($_GET["choix"] == 2) {
    if (!empty($_POST['zone-saisie-id-update'])) {
        $target_file = "";
        if (!empty($_FILES["zone-image-update"])) {
            $target_dir = "img/";
            $target_file = $target_dir . basename($_FILES["zone-image-update"]["name"]);
            $check = getimagesize($_FILES["zone-image-update"]["tmp_name"]);
            if ($check !== false) {
                if (!move_uploaded_file($_FILES["zone-image-update"]["tmp_name"], $target_file)) {
                    echo '<script>alert("Erreur lors du téléchargement de l\'image")</script>';
                }
            } else {
                echo '<script>alert("Le fichier téléchargé n\'est pas une image valide")</script>';
            }
        }
        $id = $_POST['zone-saisie-id-update'];
        $titre = $_POST['zone-saisie-titre-update'];
        $datePublication = $_POST['zone-saisie-date-update'];
        $cotation = $_POST['zone-cotation-update'];
        $resumeLivre = $_POST['livre-resume-update'];
        $idauteur = $_POST['liste-auteur-livre-update'];
        $idgenre = $_POST['liste-genre-livre-update'];
        modifierLivre($Connexion, $id, $titre,  $idgenre, $idauteur, $resumeLivre, $datePublication, $cotation, $target_file);
    } else {
        echo '<script>alert("Veuillez renseigner un identifiant de livre")</script>';
    } 
} else if ($_GET["choix"] == 3) {
    if (!empty($_POST['id-livre-a-supprimer'])) {
        $idLivreASupprimer = $_POST['id-livre-a-supprimer'];
        $suppressionReussie = supprimerLivre($Connexion, $idLivreASupprimer);
        if ($suppressionReussie) {
            echo '<script>alert("Livre supprimé avec succès !")</script>';
        } else {
            echo '<script>alert("Erreur lors de la suppression du livre.")</script>';
        }
    } else {
        echo '<script>alert("Veuillez saisir l\'identifiant du livre à supprimer.")</script>';
    }
} else if ($_GET["choix"] == 4) {
    if (!empty($_POST['delai_emprunt'])) {
        $delai = intval($_POST['delai_emprunt']);
        $date_limite = date('Y-m-d', strtotime("-$delai days"));
        var_dump($date_limite);

        // Récupérer les emprunts non retournés depuis la date limite avec la nouvelle requête
        $query = $Connexion->prepare("
            SELECT emprunts.id, livre.titre, utilisateurs.pseudo, date_emprunt, date_retour_prevue
            FROM emprunts
            JOIN livre ON livre.idlivre = emprunts.idlivre
            JOIN utilisateurs ON utilisateurs.id = emprunts.utilisateur_id
            WHERE DATE_ADD(date_emprunt, INTERVAL 26 DAY) <= :date_limite
            AND date_retour_effective IS NULL
        ");
        $query->execute(['date_limite' => $date_limite]);
        $emprunts_non_retournes = $query->fetchAll(PDO::FETCH_ASSOC);

        // Afficher les résultats
        if ($emprunts_non_retournes) {
            echo "<h2>Emprunts non retournés :</h2>";
            echo "<ul>";
            foreach ($emprunts_non_retournes as $emprunt) {
                echo "<li>{$emprunt['titre']} - Emprunté par : {$emprunt['pseudo']} le : {$emprunt['date_emprunt']}</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>Aucun emprunt non retourné trouvé.</p>";
        }
    } else {
        echo '<script>alert("Veuillez entrer un délai valide.")</script>';
    }
}

// Récupération des données pour les formulaires (liste des auteurs, genres)
$genre = getGenre($Connexion)->fetchAll();
$auteur = getAuteur($Connexion)->fetchAll();

// Inclusion de la vue
include "vue/vueMenu.php";
?>
