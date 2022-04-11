<?php
session_start();
//book.ISBN, book.title, book.editor, book.category, book.gender, book.date_publication, book.summary, book.language, book.note, book.coverage FROM book
require_once './Config/Customer.php';
require_once './Config/DBConnexion.php';

if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    $email = strtolower($email);
    
    $db = new DBConnexion();
    $db = $db->getDd();

    $check = $db->prepare('SELECT name_customer, surname_customer, gender, age, profesion, language, nationality, email, password, token FROM customer WHERE email = ?');
    $check->execute(array($email));
    $data = $check->fetch();
    $row = $check->rowCount();


    if ($row > 0) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            if (password_verify($password, $data['password'])) {
                $_SESSION['user'] = $data['token'];
                header('Location: index.php'); /* redirection sur l'index pour le moment */
                die();
            } else {
                header('Location: connexion.php?login_error=password');
                die();
            }
        } else {
            header('Location: connexion.php?login_error=email');
            die();
        }
    } else {
        header('Location: connexion.php?login_error=not_available');
        die();
    }
} else {
    header('Location: connexion.php');
    die();
}
