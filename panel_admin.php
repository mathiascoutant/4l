<?php
include('bdd.php');

if (isset($_SESSION['id'])) {
    $verif_username = $bdd->prepare('SELECT * FROM users WHERE username = ?');
    $verif_username->execute(array($_SESSION['username']));
    $user = $verif_username->fetch();

    if ($user['admin_'] == 1) {

        if (isset($_POST['valider'])) {

            $verif_username = $bdd->prepare('SELECT * FROM users WHERE username = ?');
            $verif_username->execute(array($_POST['hidden']));
            $user = $verif_username->fetch();

            $update_admin = $bdd->prepare('UPDATE users SET admin_ = ? WHERE username = ?');
            $update_admin->execute(array($_POST['admin_'], $user['username']));

            header('Location: index.php');
        }


?>

        <!DOCTYPE html>
        <html lang="fr">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Panel Admin</title>
        </head>

        <body>
            <div>
                <a href="index.php">Accueil</a>
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
                <form method="post"><?php
                                    $users_select = $bdd->query('SELECT * FROM users WHERE id > 0');
                                    while ($user = $users_select->fetch()) { ?>
                        <p>Username : <input type="text" value="<?php echo $user['username']; ?>"> Email : <input type="text" value="<?php echo $user['email']; ?>"> Admin : <input name="admin_" type="text" value="<?php echo $user['admin_']; ?>"> <input type="hidden" name="hidden" value="<?php echo $user['username']; ?>"> <input type="submit" name="valider" value="Valider"></p>
                    <?php } ?>
                </form>
            </div>
        </body>

        </html>

<?php
    } else {
        header('Location: index.php');
    }
} else {
    header('Location: index.php');
} ?>