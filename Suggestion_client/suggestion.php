<?php

class suggestion
{
    public function connection_test_local(): PDO
    {
        return new PDO('mysql:host=mysql-libnum.alwaysdata.net;dbname=libnum_pdi2022', 'libnum', 'pdiLibNum2022');
    }

    public function similarityPurchase_Between_Customers($customer1, $customer2, $options): float
    {
        $similarity_purchase = array();
        $sum = 0;

        foreach ($options[$customer1] as $key => $value) {
            if (array_key_exists($key, $options[$customer2])) {
                $similarity_purchase[$key] = 1;
            }
        }

        if (count($similarity_purchase) == 0) {
            return 0;
        }

        foreach ($options[$customer1] as $key => $value) {
            if (array_key_exists($key, $options[$customer2])) {
                $sum = $sum + pow($value - $options[$customer2][$key], 2);
            }
        }
        return  1 / (1 + sqrt($sum));
    }

    public function getPurchases_List_from_Customers(): array
    {
        $myPDO = $this->connection_test_local();

        $booksBuy = "SELECT customer.name_customer, group_concat(book.title SEPARATOR ';'), 
                        group_concat(purchase.evaluate SEPARATOR ';') FROM purchase INNER JOIN 
                        customer ON purchase.id_customer = customer.id_customer INNER JOIN 
                        book ON book.ISBN = purchase.ISBN GROUP BY customer.name_customer";

        $query_sql = $myPDO->prepare($booksBuy);
        $query_sql->execute(array());

        $result_array = array();
        while ($row = $query_sql->fetch()) {
            $books_array = explode(';', $row[1]);
            $evaluate_array = explode(';', $row[2]);
            $merge = array_combine($books_array, $evaluate_array);
            $result_array += array($row[0] => $merge);
        }
        return $result_array;
    }

    public function getPurchases_List_for_one_customers()
    {
        $myPDO = $this->connection_test_local();

        $books = array();
        $id_Customers = $_SESSION['id_customer'];

        $request_sql = "SELECT group_concat(book.title) FROM purchase INNER JOIN book ON book.ISBN = purchase.ISBN WHERE purchase.id_customer =?";
        $query_sql = $myPDO->prepare($request_sql);
        $query_sql->execute(array($id_Customers));
        while ($data = $query_sql->fetch()) {
            $booksBuy = explode(',', $data['group_concat(book.title)']);
            $books[] = $booksBuy;
        }
        return $books[0];
    }

    public function getClient_preference_categories(): array
    {
        $myPDO = $this->connection_test_local();

        $request_sql_1 = "SELECT name_customer, email, nationality, preference, age FROM customer WHERE id_customer =?";
        $query_sql_1 = $myPDO->prepare($request_sql_1);

        $customer_book = $this->getPurchases_List_for_one_customers();
        $id_Customers = $_SESSION['id_customer'];

        $query_sql_1->execute(array($id_Customers));
        $profile = $query_sql_1->fetch();
        $merge_books = array();
        $request_sql_2 = "SELECT b.title , b.note FROM book b JOIN written_by w ON w.ISBN = b.ISBN 
        JOIN author a ON a.id_author = w.id_author 
        WHERE b.gender =? OR b.category=?";
        $query_sql_2 = $myPDO->prepare($request_sql_2);
        $query_sql_2->execute([$profile['nationality'], $profile['category'], $profile['age'], implode(",", $customer_book)]);
        $books = $query_sql_2->fetchAll();
        foreach ($books as $book) {
            $merge_books += array($book['title'] => $book['note']);
        }
        return $merge_books;
    }

    public function filterBooks_by_different_criteria($books_Suggest): array
    {
        $myPDO = $this->connection_test_local();

        $books = array();
        if (isset($_POST['suggestion'])) {
            if ($_SESSION['choice'] != NULL) {
                $choose = $_SESSION['choice'];
                if (count($choose) > 1) {
                    $books_Suggest = array_merge($books_Suggest, $this->getClient_preference_categories());
                    $books_Suggest = array_reverse($books_Suggest);
                } elseif ($choose[0] == 0) {
                    $books_Suggest = $this->getClient_preference_categories();
                    array_multisort($books_Suggest, SORT_DESC);
                }
            }
        }
        foreach ($books_Suggest as $suggestion => $values) {
            if (count($books) < 10) {
                $request_sql = "SELECT * FROM book b JOIN written_by w ON w.ISBN = b.ISBN JOIN author a 
                ON a.id_author = w.id_author WHERE b.title = ? GROUP BY b.title ORDER BY b.note DESC";
                $query_sql = $myPDO->prepare($request_sql);
                $query_sql->execute(array($suggestion));
                $book =  $query_sql->fetch();
                if (isset($_POST['predilections'])) {
                    if (
                        $_SESSION['note'] != NULL || $_SESSION['category'] != NULL || $_SESSION['language'] != NULL
                        || $_SESSION['editor'] != NULL || $_SESSION['date_publication'] != NULL
                    ) {
                        if ($_SESSION['note'] != NULL) {
                            foreach ($_SESSION['note'] as $note) {
                                if ($book['note'] == $note) {
                                    if (array_search($book['title'], $books, true) == false) {
                                        $books[] = $book;
                                    }
                                }
                            }
                        }
                        if ($_SESSION['category'] != NULL) {
                            foreach ($_SESSION['category'] as $category) {
                                if ($book['category'] == $category) {
                                    if (array_search($book['title'], $books, true) == false) {
                                        $books[] = $book;
                                    }
                                }
                            }
                        }
                        if ($_SESSION['language'] != NULL) {
                            foreach ($_SESSION['language'] as $language) {
                                if ($book['language'] == $language) {
                                    if (array_search($book['title'], $books, true) == false) {
                                        $books[] = $book;
                                    }
                                }
                            }
                        }
                        if ($_SESSION['editor'] != NULL) {
                            foreach ($_SESSION['editor'] as $editor) {
                                if ($book['editor'] == $editor) {
                                    if (array_search($book['title'], $books, true) == false) {
                                        $books[] = $book;
                                    }
                                }
                            }
                        }
                        if ($_SESSION['date_publication'] != NULL) {
                            foreach ($_SESSION['date_publication'] as $date_publication) {
                                if ($book['date_publication'] == $date_publication) {
                                    if (array_search($book['title'], $books, true) == false) {
                                        $books[] = $book;
                                    }
                                }
                            }
                        }
                    } else {
                        $books[] = $book;
                    }
                } else {
                    $books[] = $book;
                }
            }
        }
        return $books;
    }

    public function getSuggestions($person): array
    {
        $final = array();
        $similarity_sum = array();
        global $classement;
        $classement = array();
        $similarity = 0;
        $preferences_list = $this->getPurchases_List_from_Customers();

        foreach ($preferences_list as $anotherPerson => $values) {
            if ($anotherPerson != $person) {
                $similarity = $this->similarityPurchase_Between_Customers($preferences_list, $person, $anotherPerson);
            }

            if ($similarity > 0) {
                foreach ($preferences_list[$anotherPerson] as $key => $value) {
                    if (!array_key_exists($key, $preferences_list[$person])) {
                        if (!array_key_exists($key, $final)) {
                            $final[$key] = 0;
                        }

                        $final[$key] += $preferences_list[$anotherPerson][$key] * $similarity;

                        if (!array_key_exists($key, $similarity_sum)) {
                            $similarity_sum[$key] = 0;
                        }

                        $similarity_sum[$key] += $similarity;
                    }
                }
            }
        }

        foreach ($final as $key => $value) {
            $classement[$key] = $value / $similarity[$key];
        }
        array_multisort($classement, SORT_DESC);

        $books = $this->filterBooks_by_different_criteria($classement);
        return $books;
    }
}
