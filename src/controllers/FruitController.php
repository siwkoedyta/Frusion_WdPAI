<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/Fruit.php';
require_once __DIR__ . '/../repository/FruitRepository.php';


class FruitController extends AppController
{
    private $message = [];
    private $fruitRepository;

    public function __construct()
    {
        parent::__construct();
        $this->fruitRepository = new FruitRepository();
    }

    public function fruit_list() {
        if (!$this->isUserLoggedIn()) {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/panel_logowania", true, 303);
            exit();
        }

        $fruits = $this->fruitRepository->getAllFruit();
        $decryptedEmail = $this->getDecryptedEmail();
        $this->render('fruit_list', ['email' => $decryptedEmail, 'fruits' => $fruits]);
    }

    private function isUserLoggedIn()
    {
        return isset($_COOKIE['logged_user']);
    }

    private function getDecryptedEmail()
    {
        $encryptionKey = '2w5z8eAF4lLknKmQpSsVvYy3cd9gNjRm';
        $iv = '1234567891011121';

        // Deszyfrowanie
        $decryptedData = openssl_decrypt($_COOKIE['logged_user'], 'aes-256-cbc', $encryptionKey, 0, $iv);

        return $decryptedData;
    }

}



