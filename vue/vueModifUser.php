<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le compte</title>
</head>
<body>

<?php
// Initialiser le message d'erreur
$messageErreur = "";

// Vérifiez si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = trim($_POST['login']);
    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $motDePasse = trim($_POST['motDePasse']);
    $confirmerMotDePasse = trim($_POST['confirmerMotDePasse']);

    // Vérifiez que les mots de passe correspondent
    if ($motDePasse !== $confirmerMotDePasse) {
        $messageErreur = "Les mots de passe ne correspondent pas.";
    } else {
        // Hash du nouveau mot de passe
        $hashedPassword = password_hash($motDePasse, PASSWORD_DEFAULT);

        include_once 'modele/mesFonctionsAccesBDD.php'; // Assurez-vous que ce fichier est bien inclus
        $pdo = connexionBDD();

        $stmt = $pdo->prepare("UPDATE comptes SET login = ?, nom = ?, email = ?, mot_de_passe = ? WHERE id = ?");
        if ($stmt->execute([$login, $nom, $email, $hashedPassword, $idCompte])) {
            $messageErreur = "Informations mises à jour avec succès.";
        } else {
            $messageErreur = "Erreur lors de la mise à jour des informations.";
        }
    }
}

if ($messageErreur != "") {
    echo "<div class='error'>$messageErreur</div>";
}
?>

<form action="index.php?action=rectifier" method="post">
    <label><b>Login</b></label><br>
    <div class="loginUser">
        <input type="text" size="50" value="<?php echo htmlspecialchars($login); ?>" placeholder="Login" name="login" >
    </div>

    <label><b>Nom</b></label><br>
    <input type="text" name="nom" value="<?php echo htmlspecialchars($nom); ?>" placeholder="Nom" ><br><br>

    <label><b>Email</b></label><br>
    <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" placeholder="Email" ><br><br>

    <label><b>Mot de passe</b></label><br>
    <input type="password" name="motDePasse" placeholder="Nouveau mot de passe" ><br><br>

    <label><b>Confirmer le mot de passe</b></label><br>
    <input type="password" name="confirmerMotDePasse" placeholder="Confirmer mot de passe" ><br><br>

    <button type="submit">
        <b>Modifier les informations</b>
    </button>
</form>

</body>
</html>
