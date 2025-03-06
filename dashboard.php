<?php
session_start();
if (!isset($_SESSION["connecte"])) {
    header('Location: http://localhost/test/login/connexion.php');
    exit;
}
$filePath = 'utilisateurs.json';
        if (file_exists($filePath)) {
            $users = file_get_contents($filePath);
            $data = json_decode($users, true);
        }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>Bienvenue <?= $data[0]["Identifiant"] ?></h1>
    <?php require_once 'deconnexion.php'; ?>
</body>
</html>