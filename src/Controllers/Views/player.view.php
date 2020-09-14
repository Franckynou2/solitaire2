<?php
/**
 * src/Controllers/Views/players.view.php
 * Vue avec les données des joueurs
 * 
 */
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Player</title>
</head>

<body>
    <h1>Un joueur</h1>
    <p>
        <ul>
            <?php
                echo '<strong>' . $controller->getRepository()->findById($_GET['id'])->getName() . '</strong>';
                echo ' : <strong>' . $controller->getRepository()->findById($_GET['id'])->getTime() . '</strong>';
            ?>
        </ul>
    </p>
</body>

</html>