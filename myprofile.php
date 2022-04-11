<?php
session_start();

include('./Config/DBConnexion.php');
require_once("./Suggestion_client/suggestion.php");
require('include/header.php');

$myPDO = new Database();
$myPDO = $myPDO->getDd();

if (isset($_SESSION['connect'])) {
    if (isset($_GET['d'])) {
        session_destroy();
        $_SESSION['connect'] = false;
    }
}

if (!isset($_SESSION['user'])) {
    header('Location:index.php');
    die();
}

if (isset($_POST['preference'])) {
    if (isset($_POST['gender'])) {
        $_SESSION['gender'] = $_POST['gender'];
    } else $_SESSION['gender'] = NULL;

    if (isset($_POST['category'])) {
        $_SESSION['category'] = $_POST['category'];
    } else $_SESSION['category'] = NULL;

    if (isset($_POST['language'])) {
        $_SESSION['language'] = $_POST['language'];
    } else $_SESSION['language'] = NULL;

    if (isset($_POST['editor'])) {
        $_SESSION['editor'] = $_POST['editor'];
    } else  $_SESSION['editor'] = NULL;

    if (isset($_POST['date_publication'])) {
        $_SESSION['date_publication'] = $_POST['date_publication'];
    } else {
        $_SESSION['date_publication'] = NULL;
    }
}
if (isset($_POST['suggestion']) || isset($_POST['preference'])) {
    if (isset($_POST['choice'])) {
        $_SESSION['choice'] = $_POST['choice'];
    } else $_SESSION['choice'] = NULL;
} else {
    $_SESSION['choice'] = NULL;
}

$request_sql_1 = "SELECT DISTINCT gender FROM book WHERE gender != ''";
$query_sql_1 = $myPDO->prepare($request_sql_1);
$query_sql_1->execute(array());

$request_sql_2 = "SELECT DISTINCT name_author FROM author";
$query_sql_2 = $myPDO->prepare($request_sql_2);
$query_sql_2->execute(array());

$request_sql_3 = "SELECT DISTINCT category FROM book";
$query_sql_3 = $myPDO->prepare($request_sql_3);
$query_sql_3->execute(array());

$request_sql_4 = "SELECT DISTINCT language FROM book";
$query_sql_4 = $myPDO->prepare($request_sql_4);
$query_sql_4->execute(array());

$request_sql_5 = "SELECT DISTINCT date_publication FROM book";
$query_sql_5 = $myPDO->prepare($request_sql_5);
$query_sql_5->execute(array());



?>

<body>
    <div class="">
        <div id="">
            <?php
            if (!isset($_SESSION['user'])) {
            ?>
                <form method="post" action="">
                    <input type="text" name="email" placeholder="Email" required />
                    <input type="password" name="password" placeholder="Password" required />
                    <input type="submit" value="Login" />
                </form>

            <?php
            } else {
            ?>
                <div class="">
                </div>
                <div class="">
                    <ul class="">
                        <li class="" id=""><a href="myprofil.php">Book buy</a></li>
                        <li><a href="index.php?d=true">Log off</a></li>
                    </ul>
                </div>
            <?php
            }
            ?>
        </div>
    </div>

    <div class="">
        <div class="">
            <div class="">
                <form method="post" action="#">
                    <div id="">
                        <h3>Recommendations</h3>
                        <ul>
                            <li>
                                <div class="">
                                    <div class="">
                                        <a>
                                            <h4>Profile</h4>
                                        </a>
                                    </div>
                                    <div class="">
                                        <input class="form-check-input" type="checkbox" name="choice[]" value="0">
                                    </div>
                                </div>
                            </li>
                            <li">
                                <div class="">
                                    <div class="">
                                        <a>
                                            <h4>Purchases</h4>
                                        </a>
                                    </div>
                                    <div class="">
                                        <input class="form-check-input" type="checkbox" name="choice[]" value="1">
                                    </div>
                                </div>
                                </li>
                                <ul>
                    </div>
                    <input class="" name="recommandation" type="submit" value="Register">
                </form>
                <form method="post" action="#">
                    <div id=""">
                    <h3>Gender</h3>
                    <ul>
                        <?php while ($data = $query_sql_1->fetch()) { ?>
                            <li>
                                <div class="">
                                    <div class="">
                                        <a><?php echo $data['gender']; ?></a>
                                    </div>
                                    <div class="">
                                        <div class="">
                                            <input class="" type=" checkbox" name="gender[]" value="<?php echo $data['gender'] ?>">
                    </div>
            </div>
        </div>
        </li>
    <?php } ?>
    <ul>
    </div>
    <div id="">
        <h3>Author</h3>
        <ul>
            <?php while ($data_1 = $query_sql_2->fetch()) { ?>
                <li>
                    <div class="">
                        <div class="">
                            <a><?php echo $data_1['name_author']; ?></a>
                        </div>
                        <div class="">
                            <div class="form-check">
                                <input class="" type="checkbox" name="name_author[]" value="<?php echo $data_1['name_author'] ?>">
                            </div>
                        </div>
                </li>
            <?php
            }
            ?>
        </ul>
    </div>
    <div id="">
        <h3>Language</h3>
        <ul>
            <?php while ($data_2 = $query_sql_4->fetch()) { ?>
                <li>
                    <div class="">
                        <div class="">
                            <a><?php if ($data_2['language'] == "english") {
                                    echo "English";
                                } elseif ($data_2['language'] == "french") {
                                    echo "French";
                                }
                                ?>
                            </a>
                        </div>
                        <div class="">
                            <div class="">
                                <input class="" type="checkbox" name="language[]" value="<?php echo $data_2['language'] ?>">
                            </div>
                        </div>
                </li>
            <?php
            }
            ?>
        </ul>
    </div>
    <div id="">
        <h3>Date of publication</h3>
        <ul>
            <?php while ($data_3 = $query_sql_5->fetch()) { ?>
                <li>
                    <div class="">
                        <div class="">
                            <a><?php echo $data_3['date_publication']; ?></a>
                        </div>
                        <div class="">
                            <div class="">
                                <input class="" type="checkbox" name="date_publication[]" value="<?php echo $data_3['date_publication'] ?>">
                            </div>
                        </div>
                    </div>
                </li>
            <?php } ?>
            <ul>
    </div>
    <input class="" name="preferences" type="submit" value="Filter">
    </form>
    </div>
    <div class="">
        <h2>Home</h2>
        <div class="">
            <div class="">Home page</div>
            <div class="">
                <div class="">
                    <?php include('./Suggestion_client/suggestion_page.php'); ?>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>