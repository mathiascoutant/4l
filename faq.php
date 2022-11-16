<?php

include 'bdd.php';

if (isset($_SESSION['id'])) {

    if (isset($_POST['envoyer_message'])) {


        if (!empty($_POST['message'])) {

            $verif_username = $bdd->prepare('SELECT * FROM users WHERE username = ?');
            $verif_username->execute(array($_SESSION['username']));
            $user = $verif_username->fetch();

            $insertion_message_faq = $bdd->prepare("INSERT INTO faq (username, message_, admin_) VALUES (?,?,?)");
            $insertion_message_faq->execute(array($user['username'], $_POST['message'], $user['admin_']));

            header('Location: faq.php');
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
        <a href="index.php">Accueil</a>
        <a href="faq.php">FAQ</a>
        <?php
        if (isset($_SESSION['id'])) { ?>
            <a href='profil.php?username=<?php echo $_SESSION['username']; ?>'><?php echo $_SESSION['username']; ?></a>
        <?php } ?>
        <?php
        $verif_username = $bdd->prepare('SELECT * FROM users WHERE username = ?');
        $verif_username->execute(array($_SESSION['username']));
        $user = $verif_username->fetch();

        if ($user['admin_'] == 1) { ?>
            <a href="panel_admin.php">Panel Admin</a>
        <?php } ?>
        <div>
            <form method="POST">
                <div>
                    <?php
                    $faq_select = $bdd->query('SELECT * FROM faq WHERE id > 0');
                    while ($faq = $faq_select->fetch()) {
                        if ($faq['admin_'] == 1) { ?>
                            <p style="color: red; text-align: right;"><?php echo $faq['message_']; ?> : <?php echo $faq['username']; ?></p>
                        <?php } else { ?>
                            <p><?php echo $faq['username']; ?>: <?php echo $faq['message_']; ?></p>
                        <?php } ?>
                    <?php } ?>
                    <textarea name="message" id="" cols="30" rows="4" placeholder="Message"></textarea>
                    <input type="submit" name="envoyer_message" value="Envoyer">
                </div>
            </form>
        </div>
    </body>

    </html>

<?php } else {
    header('Location: connexion.php');
}
?>