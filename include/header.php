<?php
require_once './Config/Customer.php';
require_once './Config/DBConnexion.php';
if (isset($_SESSION['user'])) {
    $bdd = new DBConnexion();
    $bdd = $bdd->getDd();
    // On récupere les données de l'utilisateur
    $req = $bdd->prepare('SELECT * FROM customer WHERE token = ?');
    $req->execute(array($_SESSION['user']));
    $data = $req->fetch();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LibNum CYU</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="text/javascript"></script>
    <link href="css/stylesheet.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">LibNum</a>
                <form action="" method="get">
                    <input type="search" name="terme">
                    <input type="submit" name="s" value="Rechercher">
                </form>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <?php
                        if (!isset($_SESSION['user'])) {
                        ?>
                            <li class="nav-item">
                                <a class="nav-link active" href="index.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="book.php">Book</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="connexion.php">Connexion</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="inscription.php">Inscription</a>
                            </li>
                        <?php
                        } else {
                        ?>
                            <li class="nav-item">
                                <a class="nav-link disabled">Bonjour, <?php echo $data['name_customer'], " ", $data['surname_customer']; ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="index.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="consultation.php">Consultation</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="myprofile.php">Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="deconnexion.php">Déconnexion</a>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>