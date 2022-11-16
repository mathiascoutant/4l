<?php

include 'bdd.php';

$verif_username = $bdd->prepare('SELECT * FROM users WHERE username = ?');
$verif_username->execute(array($_GET['username']));
$user = $verif_username->fetch();
$username_exist = $verif_username->rowCount();


if (isset($_POST['valider'])) {

    if (!empty($_POST['username']) and !empty($_POST['email'])) {

        $verif_username = $bdd->prepare('SELECT * FROM users WHERE username = ? AND email = ?');
        $verif_username->execute(array($_POST['username'], $_POST['email']));
        $user = $verif_username->fetch();
        $user_exist = $verif_username->rowCount();

        $verif_username_2 = $bdd->prepare('SELECT * FROM users WHERE username = ?');
        $verif_username_2->execute(array($_GET['username']));
        $user_user = $verif_username_2->fetch();

        if ($user_exist === 0) {

            if (!empty($_POST['password_'])) {

                if (strlen($_POST['password_']) >= 6) {

                    $password_crypted = password_hash($_POST['password_'], PASSWORD_BCRYPT);
                    $update_password = $bdd->prepare('UPDATE users SET password_ = ? WHERE username = ?');
                    $update_password->execute(array($_POST['password_'], $_GET['username']));
                } else {
                    echo "mdp pas assez long";
                }
            } else {
                if ($user_user['username'] != $_POST['username']) {
                    $update_password = $bdd->prepare('UPDATE users SET username = ? WHERE username = ?');
                    $update_password->execute(array($_POST['username'], $_GET['username']));

                    $_SESSION['username'] = $_POST['username'];
                }
                if ($user_user['email'] != $_POST['email']) {
                    $update_password = $bdd->prepare('UPDATE users SET email = ? WHERE username = ?');
                    $update_password->execute(array($_POST['email'], $_GET['username']));
                }
            }
            header('Location: index.php');
        } else {
            echo "username deja use";
        }
    }
}

if ($username_exist === 1) { ?>

    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Profil | <?php echo $_GET['username']; ?></title>
    </head>

    <body>
        <a href="index.php">Accueil</a>
        <a href="faq.php">FAQ</a>
        <?php
        $verif_username = $bdd->prepare('SELECT * FROM users WHERE username = ?');
        $verif_username->execute(array($_SESSION['username']));
        $user = $verif_username->fetch();

        if ($user['admin_'] == 1) { ?>
            <a href="panel_admin.php">Panel Admin</a>
        <?php } ?>
        <?php
        if (isset($_SESSION['id'])) { ?>
            <a href='profil.php?username=<?php echo $_SESSION['username']; ?>'><?php echo $_SESSION['username']; ?></a>
        <?php } ?>

        <form method="post">
            <label>Username: </label>
            <input type="text" name="username" placeholder="Username" value="<?php echo $_GET['username']; ?>">
            <br>
            <label>Email: </label>
            <input type="text" name="email" placeholder="Email" value="<?php echo $user['email']; ?>">
            <br>
            <label>Mot de passe: </label>
            <input type="text" name="password_" placeholder="Mot de passe">
            <br>
            <input type="submit" name="valider" value="Modifier">
        </form>
    </body>

    </html>

<?php } else { ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Profil</title>
    </head>

    <body>
        <h1>Username Inexistant</h1>
    </body>

    </html>

<?php } ?>