<?php
session_start();
require 'include/header.php';
?>

<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">LibNum</h1>
            <p class="lead fw-normal text-white-50 mb-0">Librairie Numérique en Ligne</p>
        </div>
    </div>
</header>
<!-- <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
        <div class="carousel-item active">
            <div class="container">
            <div class="carousel-caption">
                <h1>LibNum Librairie Numérique en Ligne</h1>
				<p>LibNum vous permet de visualiser les livres disponible dans notre librairie. En vous inscrivant sur notre site, vous pourrez acheter les livres de votre choix, ou benéficier de suggestion du site. </p>
            </div>
            </div>
        </div>
        <div class="carousel-item">
        <div class="overlay-image" style="background-image:url(./images/slide2.webp);"></div>
            <div class="container">
            <div class="carousel-caption">
                <h1>Un annuaire !</h1>
                <p>LibNum vous permet de retrouver tout les livres que vous voulez lire!</p>
            </div>
            </div>
        </div>
        </div>
    </div> -->

<?php
//ajout de la table équipe puis trié en fonction des postes des joueurs
$bdd = new DBConnexion();
$bdd = $bdd->getDd();

$query = "SELECT * FROM book";
$check = $bdd->prepare($query);
$check->execute();

$bookData = $check->fetch();

$chercheAuteur = "SELECT * FROM written_by INNER JOIN book ON book.ISBN = written_by.ISBN INNER JOIN author ON written_by.id_author = author.id_author";
$checkCherche = $bdd->prepare($chercheAuteur);
$checkCherche->execute();
$author = $checkCherche->fetch(PDO::FETCH_ASSOC);
//$nameAuteur = "SELECT name_author from $chercheAuteur";
//$checkAuteur = $bdd->prepare($nameAuteur);
//$checkAuteur->execute();
?>
<!-- Section-->
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">

            <?php
            while ($row = $check->fetch(PDO::FETCH_ASSOC)) {
            ?>
                <div class="col mb-5">
                    <div class="card h-100">
                        <!-- Product image-->
                        <?php echo '<img class="card-img-top" src="data:image/jpeg;base64,' . base64_encode($row['coverage']) . '" alt="book cover"/ >';  ?>
                        <!-- Product details-->
                        <div class="card-body p-4">
                            <div class="text-center">
                                <!-- Product name-->
                                <h5 class="fw-bolder"><?php echo "Title : " . $row['title']; ?></h5>
                                <!-- Product reviews-->
                                <div class="d-flex justify-content small text-warning mb-2">
                                    <div class="bi-star-fill"></div>
                                    <div class="bi-star-fill"></div>
                                    <div class="bi-star-fill"></div>
                                    <div class="bi-star-fill"></div>
                                    <div class="bi-star-fill"></div>
                                </div>
                                <!-- Product price-->
                                <?php
                    echo "essai : " . $author('ISBN');
                ?>
                            </div>
                        </div>
                        <!-- Product actions-->
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="book.php">View</a></div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</section>

<?php
require 'include/footer.php';
?>