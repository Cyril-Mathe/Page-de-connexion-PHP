<?php
$cookie = filter_input(INPUT_COOKIE, "id");
if(!$cookie) {
    $cookie = bin2hex(random_bytes(8));
    setcookie("id", $cookie);
}

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
        $user = array("id"=> $cookie, "Identifiant"=> $identifiant, "Mot de passe"=> $motdepasse);

        $filePath = 'utilisateurs.json';
        if (file_exists($filePath)) {
            $existingData = file_get_contents($filePath);
            $users = $existingData ? json_decode($existingData, true) : [];
        } else {
            $users = [];
        }

        foreach ($users as $existingUser) {
            if ($existingUser['Identifiant'] === $identifiant) {
                $messageErreur3 = "Cet identifiant est déjà utilisé";
                break;
            }
        }

        if (!$messageErreur3) {
            $users[] = $user;

            file_put_contents($filePath, json_encode($users, JSON_PRETTY_PRINT));
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body>
    <h1>Inscription</h1>
    <a href="connexion.php">Connexion</a>

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
</body>
</html>