<?php
include_once './Config/Customer.php';

if (!empty($_POST['name_customer']) && !empty($_POST['surname_customer']) && !empty($_POST['gender']) 
    && !empty($_POST['age']) && !empty($_POST['profesion']) && !empty($_POST['language'])
    && !empty($_POST['preference']) && !empty($_POST['nationality']) && !empty($_POST['email'])  
    && !empty($_POST['password']) && !empty($_POST['password_retype'])) {

    $name_customer = htmlspecialchars($_POST['name_customer']);
    $surname_customer = htmlspecialchars($_POST['surname_customer']);

    $gender = htmlspecialchars($_POST['gender']);
    $age = htmlspecialchars($_POST['age']);
    $profesion = htmlspecialchars($_POST['profesion']);

    $language = htmlspecialchars($_POST['language']);
    $preference = ($_POST['preference']);
    $nationality = htmlspecialchars($_POST['nationality']);

    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $password_retype = htmlspecialchars($_POST['password_retype']);

    if (strlen($email) > 250) {
        header('Location: inscription.php?register_error=email_length');
        return;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: inscription.php?register_error=email');
        return;
    }
    if ($password !== $password_retype) {
        header('Location: inscription.php?register_error=password');
        return;
    }
    if (strlen($password) < 8) {
        header('Location: inscription.php?register_error=password_length');
        return;
    }

    $pref="";
    foreach($preference as $pref_result){
        $pref.=$pref_result.",";
    }

    $customer = new Customer($name_customer, $surname_customer, $gender, $age, $profesion, $nationality, $language, $pref, $email, $password);
    if ($customer->inscription_customer()){
        header('Location:inscription.php?reg_err=success');
    } else {
        header('Location:inscription.php?reg_err=fail');
    }
}
?>
