<?php
if(isset($_SESSION['connect']))
{
    if (isset($_SESSION['name_customer']))
    {
        $name = $_SESSION['name_customer'];
        $id_customer = $_SESSION['id_customer'];
    }
    else{
        $name = "";
    }
}

require_once("suggestion.php");
require_once('Config/db_connexion.php');

if(isset($_GET['page']) && !empty($_GET['page']))
{
    $current_page = (int) strip_tags($_GET['page']);
}
else{
    $current_page= 1;
}
$books_by_pages = 10;
$first_book= ($current_page * $books_by_pages) - $books_by_pages;

?>

<!DOCTYPE html>
    <html>
        <body>
            <div>
                <header>
                    <h1>Recommended books</h1>
                </header>
    <?php

    $suggestion = new Suggestion();
    $customer_preferences = $suggestion->getClient_preference_categories();
    $purchase_checking = "SELECT id_customer FROM purchase WHERE id_customer =? ";
    $query=$myPDO->prepare($purchase_checking);
    $query->execute(array($id_customer));
    $count = $query->rowCount();

    if($count !=0 & $_SESSION['choice'][0] == 1)
    {
        $suggests = $suggestion->getSuggestions($name);
        foreach ($suggests as $suggest)
        {
            ?>
               <div>
                <div>
                    <a href="consultation.php?ISBN=<?php echo  $suggest['ISBN'] ?>">
                        <?php if($suggest['picture_book'] != "")
                        {
                            ?>
                            <img src="<?php echo $suggest['picture_book']; ?>" alt="">
                            <?php }else {?>
                            <img src="picture/no_cover.jpg" alt="no cover available">
                        <?php } ?>
                    </a>
                </div>
               </div>
            <?php
        }
    }
    elseif($_SESSION['choice'][0] == 0)
    {
        $books_preferences = $suggestion->getClient_preference_categories();
        $suggests = $suggestion->filterBooks_by_different_criteria($books_preferences);
        $book_purchased = $suggestion->getPurchases_List_for_one_customers();
        foreach ($suggests as $suggest)
        {
            ?>
              <div>
                <div>
                    <a href="consultation.php?ISBN=<?php echo  $suggest['ISBN'] ?>">
                        <?php if($suggest['picture_book'] != "")
                        {
                            ?>
                            <img src="<?php echo $suggest['picture_book']; ?>" alt="">
                            <?php }else {?>
                            <img src="picture/no_cover.jp" alt="no cover available">
                        <?php } ?>
                    </a>
                </div>
              </div>
            <?php
        }
    }
    else
    {
     ?>
      <p><a href="#">You are a new customer, start shopping now </a><p>
        <?php
    }
        ?>
  </div>
 </body>
</html>
