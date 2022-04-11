<?php
session_start();
require_once('./Config/DBConnexion.php');
require 'include/header.php';

$myPDO = new Database();
$myPDO = $myPDO->getDd();

if (!isset($_SESSION['connect'])) {
    $_SESSION['connect'] = false;
}

$ISBN = $_GET['ISBN'];
$request_sql_1 = "SELECT * FROM book WHERE ISBN=?";
$query_sql_1 = $myPDO->prepare($request_sql_1);
$query_sql_1->execute(array($ISBN));
$book = $query_sql_1->fetch();

$request_sql_2 = "SELECT * FROM written_by w JOIN author a
		ON w.id_author=a.id_author
		WHERE w.ISBN=?";
$query_sql_2 = $myPDO->prepare($request_sql_2);
$query_sql_2->execute(array($ISBN));
$author = $query_sql_2->fetch();
$purchase_date = date("Y-m-d");

if (isset($_POST['purchase'])) {
    $number_purchases = $book['number_purchases'] + 1;
    $purchase_date = date("Y-m-d");
    $id_customer = $_SESSION['id_customer'];
    $ISBN = $book['ISBN'];
    $evaluate = array(1.5, 1, 2, 2.5, 3, 3.5, 4, 4.5, 5, 3, 4, 5, 3.5, 4.5);
    $evaluate = $evaluate[rand(0, count($evaluate) - 1)];

    $request_sql_3 = "UPDATE book SET nbr_purchase=? WHERE ISBN=?";
    $query_sql_3 = $myPDO->prepare($request_sql_3);
    $query_sql_3->execute(array($number_purchases, $ISBN));

    $request_sql_4 = "UPDATE customer SET nbr_purchase= ? WHERE id_customer=? ";
    $query_sql_4 = $myPDO->prepare($request_sql_4);
    $query_sql_4->execute(array($number_purchases, $id_customer));

    $request_sql_5 = "INSERT INTO purchase(id_customer,ISBN,date_purchase, evaluate) VALUES(?,?,?,?)";
    $query_sql_5 = $myPDO->prepare($request_sql_5);
    $query_sql_5->execute(array($id_customer, $ISBN, $purchase_date, $evaluate));

?>
    <script type="text/javascript">
        window.alert('Your purchase has been successfully completed.');
    </script>

<?php header("location: myprofil.php");
} ?>

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="text/javascript"></script>
</head>

<body>
    <div>
        <div>
            <?php echo '<img src=' . $book['coverage'] . ' alt="Coverage of picture" />'; ?>
        </div>
    </div>
    <div>
        <div>
            <div>
                <h3><?php echo $book['title']; ?></h3>
                <p><?php echo $book['summary']; ?></p>
                <?php if ($_SESSION['connect'] == true) {
                ?>
                    <p>
                        <a href="myprofil.php">Return to...</a>
                        <?php
                        $id_customer = $_SESSION['id_customer'];
                        $request_sql = "SELECT * FROM purchase WHERE ISBN=? AND id_customer=?";
                        $query_sql = $myPDO->prepare($request_sql);
                        $query_sql->execute(array($ISBN, $id_customer));
                        $count = $query_sql->rowCount();
                        if ($count == 0) {
                        ?>
                    <form method="post" action="">
                        <input class="btn btn-info" name="purchase" type="submit" value="Buy" />
                    </form>
                <?php
                        } else {
                ?>
                    <input type="" class="btn btn-danger" name="purchase" value="Warning, You have already ordered this book." readonly />
                <?php
                        }
                ?>
                </p>
            <?php
                } else if ($_SESSION['connect'] == false) {
            ?>
                <a href="index.php?search=<?php echo $book['category'] ?>" class="btn btn-primary" role="button">Back to...</a>
                <input type="" class="btn btn-info" name="achat" value="Login to buy" readonly />
            <?php
                }
            ?>
            </div>
        </div>
        <div>
            <table>
                <tr>
                    <th>Gender</th>
                    <th>Category</th>
                    <th>Language</th>
                    <th>Note</th>
                    <th>Date_publication</th>
                <tr>
                    <td><?php echo $book['gender']; ?></td>
                    <td><?php
                        if ($book['category'] == 1) {
                            echo "Enfant";
                        } elseif ($book['category'] == 2) {
                            echo "Jeunesse";
                        } elseif ($book['category'] == 3) {
                            echo "Adulte";
                        }
                        ?>
                    </td>
                    <td><?php echo $book['language']; ?></td>
                    <td><?php echo $book['note']; ?></td>
                    <td><?php echo $book['date_publication']; ?></td>
                </tr>
            </table>
        </div>
        <div>
            <div>
                <div>
                    <h3>Author</h3>
                    <div>
                        <?php
                        if ($author['picture'] != "") {
                            echo '<img src=' . $author['picture'] . ' alt="Picture of author" />';
                        } else {
                        ?>
                            <img src='picture/author_unknown.jpg' alt="Author unknown" />
                        <?php
                        }
                        ?>
                        <div>
                            <h3><?php echo $author['name_author'] . " " . $author['surname_author']; ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>