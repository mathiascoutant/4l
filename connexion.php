<?php

include('bdd.php');


if (isset($_POST['valider'])) {

    if (!empty($_POST['username']) and !empty($_POST['password_'])) {

        $verif_username = $bdd->prepare('SELECT * FROM users WHERE username = ?');
        $verif_username->execute(array($_POST['username']));
        $user = $verif_username->fetch();
        $username_exist = $verif_username->rowCount();

        if ($username_exist === 1) {

            if (password_verify($_POST['password_'], $user['password_'])) {

                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                header('Location: index.php');
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/connexion.css">
    <title>Connexion</title>
</head>

<body>
    <div>
        <form method="POST">
            <input class="username" type="text" placeholder="Username" name="username">
            <input class="password" type="password" placeholder="Mot de passe" name="password_">
            <br>
            <input class="valider" type="submit" value="Valider" name="valider">
        </form>
    </div>
</body>

</html>