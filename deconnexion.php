<?php
session_destroy();
if(isset($_POST['deconnexion'])) {
    header('Location: http://localhost/test/login/connexion.php'); exit;
}
?>
<form method="POST">
<input type="submit" value="Deconnexion" name="deconnexion">
</form>