<?php
session_start();
require 'include/header.php';
if (isset($_SESSION['user'])) {
    header('Location:index.php');
    die();
}
?>

<div class="container">
    <div class="login-form">
        <?php
        if (isset($_GET['login_error'])) {
            $err = htmlspecialchars($_GET['login_error']);

            switch ($error) {
                case 'password':
        ?>
                    <div class="alert alert-danger">
                        <strong>Mot de passe incorrect</strong>
                    </div>
                <?php
                    break;

                case 'email':
                ?>
                    <div class="alert alert-danger">
                        <strong>Adresse email incorrect</strong>
                    </div>
                <?php
                    break;

                case 'not_available':
                ?>
                    <div class="alert alert-danger">
                        <strong>Compte non existant, merci de créer un compte</strong>
                    </div>
        <?php
                    break;
            }
        }
        ?>

        <form action="connexion_traitement.php" method="post">
            <h2 class="text-center">Connexion</h2>

            <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Email" required="required" autocomplete="off">
            </div>

            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Mot de passe" required="required" autocomplete="off">
            </div>

            <div class="text-center">
                <div class="form-group">
                    <button type="submit" class="btn btn-success  btn-block">Connexion</button>
                </div>
            </div>

        </form>

        <form action="inscription.php" method="get">
            <div class="text-center">
                <h6>Vous n'avez pas encore de compte?</h6>
                <a href="inscription.php"><button class="btn btn-outline-warning btn-block">Inscription</button></a>
            </div>
        </form>
    </div>
</div>

<style>
    .login-form {
        width: 400px;
        margin: 50px auto;
    }

    .login-form form {
        margin-bottom: 15px;
        background: #f7f7f7;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        padding: 30px;
    }

    .login-form form .form-group {
        margin-bottom: 10px;
    }

    .login-form h2 {
        margin: 0 0 15px;
    }

    .form-control,
    .btn {
        min-height: 38px;
        border-radius: 2px;
    }

    .btn {
        font-size: 15px;
        font-weight: bold;
    }
</style>

<?php
require 'include/footer.php';
?>