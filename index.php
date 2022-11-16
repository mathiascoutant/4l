<?php

include 'bdd.php';


?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
</head>

<body>
    <a href="faq.php">FAQ</a>
    <?php
    if (isset($_SESSION['id'])) { ?>
        <a href='profil.php?username=<?php echo $_SESSION['username']; ?>'><?php echo $_SESSION['username']; ?></a>
    <?php } else { ?>
        <a href="connexion.php">Connexion</a>
        <a href="inscription.php">Inscription</a>
    <?php } ?>
    <?php
    $verif_username = $bdd->prepare('SELECT * FROM users WHERE username = ?');
    $verif_username->execute(array($_SESSION['username']));
    $user = $verif_username->fetch();

    if ($user['admin_'] == 1) { ?>
        <a href="panel_admin.php">Panel Admin</a>
    <?php } ?>
</body>

</html>