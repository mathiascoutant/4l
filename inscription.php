<?php

include('bdd.php');

if (isset($_POST['valider'])) {

    if (!empty($_POST['email']) and !empty($_POST['password']) and !empty($_POST['password_conf']) and !empty($_POST['username'])) {

        $verif_email = $bdd->prepare('SELECT email FROM users WHERE email = ?');
        $verif_email->execute(array($_POST['email']));
        $email_exist = $verif_email->rowCount();

        if ($email_exist === 0) {

            $verif_username = $bdd->prepare('SELECT username FROM users WHERE username = ?');
            $verif_username->execute(array($_POST['username']));
            $username_exist = $verif_username->rowCount();

            if ($username_exist === 0) {

                if ($_POST['password'] == $_POST['password_conf']) {

                    $password_crypted = password_hash($_POST['password'], PASSWORD_BCRYPT);

                    $insertion_utilisateur = $bdd->prepare("INSERT INTO users (username, email, password_, admin_) VALUES (?,?,?,?)");
                    $insertion_utilisateur->execute(array($_POST['username'], $_POST['email'], $password_crypted, "0"));

                    header('Location: connexion.php');
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div>
        <form method="POST">
            <input type="text" placeholder="email" name="email">
            <br>
            <input type="text" placeholder="username" name="username">
            <br>
            <input type="password" placeholder="password" name="password">
            <br>
            <input type="password" placeholder="password conf" name="password_conf">
            <br>
            <input type="submit" value="envoyer" name="valider">
        </form>
    </div>
</body>

</html>