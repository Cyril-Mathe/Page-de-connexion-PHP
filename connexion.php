<?php
session_start();

$messageErreur = null;
$messageErreur2 = null;
$messageErreur3 = null;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identifiant = filter_input(INPUT_POST, "identifiant");
    $motdepasse = filter_input(INPUT_POST, "motdepasse");

    if ($identifiant === "") {
        $messageErreur = "Veuillez rentrer votre identifiant, il est obligatoire";
    } 
    if ($motdepasse === "") {
        $messageErreur2 = "Veuillez entrer un mot de passe";
    }
    if (!$messageErreur && !$messageErreur2) {
        $filePath = 'utilisateurs.json';
        if (file_exists($filePath)) {
            $users = file_get_contents($filePath);
            $data = json_decode($users, true);
            foreach($data as $user) {
                if($identifiant === $user["Identifiant"] && $motdepasse === $user["Mot de passe"]) {
                    $_SESSION["connecte"] = true;
                } else {
                    $messageErreur3 = "Identifiant ou mot de passe invalide";
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    <h1>Connexion</h1>
    <a href="inscription.php">Inscription</a>

    <?php if($messageErreur): ?>
    <div>
        <p><?= $messageErreur ?></p>
    </div>
    <?php endif; ?>

    <?php if($messageErreur2): ?>
    <div>
        <p><?= $messageErreur2 ?></p>
    </div>
    <?php endif; ?>

    <?php if($messageErreur3): ?>
    <div>
        <p><?= $messageErreur3 ?></p>
    </div>
    <?php endif; ?>

    <form method="POST">
        <div>
            <label for="identifiant">Identifiant</label>
            <input type="text" id="mail" name="identifiant">
        </div>
        <div>
            <label for="motdepasse">Mot de passe</label>
            <input type="password" id="mdp" name="motdepasse">
        </div>
        <div>
        <input type="submit" value="Envoyer">
        </div>
    </form>

    <?php if(isset($_SESSION["connecte"]) && basename($_SERVER['PHP_SELF']) != 'dashboard.php'): ?>
        <?php header('Location: http://localhost/test/login/dashboard.php'); exit; ?>
    <?php endif; ?>
</body>
</html>