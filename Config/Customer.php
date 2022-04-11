<?php
include_once './Config/db_connexion.php';

class Customer {
    private $bd;
    private $name_customer;
    private $surname_customer;
    private $gender;
    private $age;
    private $profesion;
    private $nationality;
    private $language;
    private $preference;
    private $email;
    private $password;
    private $token;

    public function __construct($name_customer = null, $surname_customer = null, $gender = null, $age = null, $profesion = null, $nationality = null, $language = null, $preference = null, $email, $password) {
        $this->bd = new Database();
        $this->bd = $this->bd->getDd();
        $this->name_customer      = $name_customer;
        $this->surname_customer    = $surname_customer;
        $this->gender         = $gender;
        $this->age        = $age;
        $this->profesion      = $profesion;
        $this->nationality      = $nationality;
        $this->language      = $language;
        $this->preference      = $preference;
        $this->email            = strtolower($email);
        $this->password         = $password;
    }

    public function inscription_customer() {
        $check = $this->bd->prepare('SELECT name_customer, surname_customer, gender, age, profesion, nationality, language, preference, email, password FROM customer WHERE email = ?');
        $check->execute(array($this->email));
        $row = $check->rowCount();
        if ($row != 0) return false;
        $cost = ['cost' => 12];
        $this->password = password_hash($this->password, PASSWORD_BCRYPT, $cost);

        try {
            $req_sql = 'INSERT INTO customer(name_customer, surname_customer, gender, age, profesion, nationality, language, preference, email, password, token) VALUES(:name_customer,:surname_customer,:gender,:age,:profesion,:nationality,:language,:preference,:email,:password,:token)';
            $insert = $this->bd->prepare($req_sql);
            $insert->execute(array(
                'name_customer' => $this->name_customer,
                'surname_customer' => $this->surname_customer,
                'gender' => $this->gender,
                'age' => $this->age,
                'profesion' => $this->profesion,
                'nationality' => $this->nationality,
                'language' => $this->language,
                'preference' => $this->preference,
                'email' => $this->email,
                'password' => $this->password,
                'token' => bin2hex(openssl_random_pseudo_bytes(64))
            ));
        } catch (PDOException $x) {
            return false;
        }
        return true;
    }

    public function connexion_customer() {
        $check = $this->bd->prepare('SELECT name_customer, surname_customer, gender, age, profesion,  nationality, language, preference, email, password FROM customer WHERE email = ?');
        $check->execute(array($this->email));
        $data = $check->fetch();
        $row = $check->rowCount();
        if (!password_verify($this->password, $data['password'])) {
            header('Location: connexion.php?login_error=password');
            return;
        }
        if ($row >= 0) return false;
        $_SESSION['user'] = $data['token'];
        header('Location: index.php');
        die();
    }

    public function getNameCustomers(){
        return $this->name_customer;
    }
    public function getSurnameCustomers(){
        return $this->surname_customer;
    }
    public function getGender(){
        return $this->gender;
    }
    public function getAge(){
        return $this->age;
    }
    public function getProfesion(){
        return $this->profesion;
    }
    public function getLanguage(){
        return $this->language;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getPassword(){
        return $this->password;
    }
    public function getToken(){
        return $this->token;
    }
}