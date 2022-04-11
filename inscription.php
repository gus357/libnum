<?php
require 'include/header.php';
if (isset($_SESSION['user'])) {                                    // si la session existe pas soit si l'on est pas connecté on redirige
    header('Location:index.php');
    die();
}
?>

<div class="container">
    <div class="login-form">
        <?php
        if (isset($_GET['register_error'])) {
            $error = htmlspecialchars($_GET['register_error']);

            switch ($error) {
                case 'success':
        ?>
                    <div class="alert alert-success">
                        <strong>Inscription réussie</strong>
                    </div>
                <?php
                    break;

                case 'password':
                ?>
                    <div class="alert alert-danger">
                        <strong>Mot de passe incorrect</strong>
                    </div>
                <?php
                    break;
                case 'password_length':
                ?>
                    <div class="alert alert-danger">
                        <strong>Mot de passe pas assez long</strong>
                    </div>
                <?php
                    break;
                case 'email':
                ?>
                    <div class="alert alert-danger">
                        <strong>Adresse email non valide</strong>
                    </div>
                <?php
                    break;

                case 'email_length':
                ?>
                    <div class="alert alert-danger">
                        <strong>Adresse email pas assez longue</strong>
                    </div>
                <?php
                    break;

                case 'name_customer_length':
                ?>
                    <div class="alert alert-danger">
                        <strong>Votre nom est trop long</strong>
                    </div>
                <?php
                    break;
                case 'surname_customer_length':
                ?>
                    <div class="alert alert-danger">
                        <strong>Votre prenom est trop long </strong>
                    </div>
                <?php
                    break;
                case 'preference':
                ?>
                    <div class="alert alert-danger">
                        <strong>erreur preference</strong>
                    </div>
                <?php
                    break;

                case 'already':
                ?>
                    <div class="alert alert-danger">
                        <strong>Compte deja existant</strong>
                    </div>
                <?php
                    break;

                case 'fail':
                ?>
                    <div class="alert alert-danger">
                        <strong>Inscription non reussi</strong>
                    </div>
        <?php
                    break;
            }
        }
        ?>

        <form action="inscription_traitement.php" method="post">
            <h2 class="text-center">Inscription</h2>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name_customer">Nom</label>
                        <input type="text" id="name_customer" name="name_customer" class="form-control" placeholder="" required="required" />
                    </div>
                </div>
                <!--  col-md-6   -->

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="surname_customer">Prénom</label>
                        <input type="text" id="surname_customer" name="surname_customer" class="form-control" placeholder="" required="required" />
                    </div>
                </div>
                <!--  col-md-6   -->
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="" required="required" />
                    </div>
                </div>
                <!--  col-md-6   -->

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="profesion">Votre Profession</label>
                        <select class="form-control" name="profesion" required>
                            <option disabled selected value>Choisir une option</option>
                            <option value="informatique">Informatique</option>
                            <option value="finance">Finance</option>
                            <option value="communication">Communication</option>
                            <option value="santé">Santé</option>
                            <option value="chimie">Chimie</option>
                            <option value="physique">Physique</option>
                        </select>
                    </div>

                </div>
                <!--  col-md-6   -->

            </div>
            <!--  row   -->

            <div class="row">
                <div class="col-md-3">
                    <label for="gender">Genre</label>
                    <div class="form-group">
                        <select class="form-control" name="gender" required>
                            <option disabled selected value>Choisir une option</option>
                            <option value="female">Female</option>
                            <option value="male">Male</option>
                        </select>
                    </div>
                </div>
                <!--  col-md-3   -->

                <div class="col-md-3">
                    <label for="nationality">Nationalité</label>
                    <div class="form-group">
                        <select class="form-control" name="nationality" required>
                            <option disabled selected value>Choisir une option</option>
                            <option value="ENG_nat">Anglaise</option>
                            <option value="FRA_nat">Francaise</option>
                            <option value="CN_nat">Chinoise</option>
                            <option value="JAP_nat">Japonaise</option>
                            <option value="ESP_nat">Espagnol</option>
                        </select>
                    </div>
                </div>
                <!--  col-md-3   -->

                <div class="col-md-3">
                    <label for="age">Age</label>
                    <div class="form-group">
                        <input id="age" name="age" type="number" class="form-control" min="14" max="99" required="required" autocomplete="off">
                    </div>
                </div>
                <!--  col-md-3   -->

                <div class="col-md-3">
                    <label for="language">Language</label>
                    <div class="form-group">
                        <select class="form-control" name="language" required>
                            <option disabled selected value>Choisir une option</option>
                            <option value="ENG">Anglais</option>
                            <option value="FRA">Francais</option>
                            <option value="MAN">Mandarin</option>
                            <option value="JAP">Japonais</option>
                            <option value="ARB">Arabe</option>
                            <option value="ESP">Espagnol</option>
                        </select>
                    </div>
                </div>
                <!--  col-md-3   -->
            </div>
            <!--  row   -->

            <div class="row">
                <div class="col-md-12">
                    <label for="preference">Préférences</label>

                    <div class="form-group" name="preference" required>
                        <input class="form-check-input" type="checkbox" id="economie" name="preference[]" value="economie">
                        <label class="form-check-label" for="economie">economie</label>

                        <input class="form-check-input" type="checkbox" id="finance" name="preference[]" value="finance">
                        <label class="form-check-label" for="finance">finance</label>

                        <input class="form-check-input" type="checkbox" id="roman" name="preference[]" value="roman">
                        <label class="form-check-label" for="roman">roman</label>

                        <input class="form-check-input" type="checkbox" id="chimie" name="preference[]" value="chimie">
                        <label class="form-check-label" for="chimie">chimie</label>

                        <input class="form-check-input" type="checkbox" id="communication" name="preference[]" value="communication">
                        <label class="form-check-label" for="communication">communication</label>

                        <input class="form-check-input" type="checkbox" id="informatique" name="preference[]" value="informatique">
                        <label class="form-check-label" for="informatique">informatique</label>

                        <input class="form-check-input" type="checkbox" id="physique" name="preference[]" value="physique">
                        <label class="form-check-label" for="physique">physique</label>

                        <input class="form-check-input" type="checkbox" id="loisir" name="preference[]" value="loisir">
                        <label class="form-check-label" for="loisir">loisir</label>

                        <input class="form-check-input" type="checkbox" id="philosophie" name="preference[]" value="philosophie">
                        <label class="form-check-label" for="philosophie">philosophie</label>

                        <input class="form-check-input" type="checkbox" id="science" name="preference[]" value="science">
                        <label class="form-check-label" for="science">science</label>

                        <input class="form-check-input" type="checkbox" id="sante" name="preference[]" value="sante">
                        <label class="form-check-label" for="sante">sante</label>
                    </div>

                </div>
                <!--  col-md-12   -->

            </div>
            <!--  row   -->

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="" required="required" />
                    </div>
                </div>
                <!--  col-md-3   -->

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="password_retype">Re-enter votre mot de passe</label>
                        <input type="password" id="password_retype" name="password_retype" class="form-control" placeholder="" required="required" />
                    </div>
                </div>
                <!--  col-md-3   -->
            </div>
            <!--  row   -->

            <div class="text-center">
                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-lg">Inscription</button>
                </div>
            </div>
        </form>

        <form action="connexion.php" method="get">
            <div class="text-center">
                <h6>Vous avez déjà un compte?</h6>
                <a href="connexion.php"><button class="btn btn-outline-warning btn-lg">Connexion</button></a>
            </div>
        </form>
    </div>
</div>

<style>
    .login-form {
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