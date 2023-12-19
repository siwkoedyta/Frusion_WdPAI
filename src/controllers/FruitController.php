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

    public function fruit_list($messages = [])
    {
        if (!$this->isUserLoggedIn()) {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: $url/panel_logowania", true, 303);
            exit();
        }

        switch ($_SERVER['REQUEST_METHOD']) {
            case "GET":
                $this->renderFruitList();
                break;
            case "POST":
                switch ($_POST['type']) {
                    case "addFruit":
                        $this->handleAddFruit();
                        break;
                    case "removeFruit":
                        $this->handleRemoveFruit();
                        break;
                }
                break;
        }
    }

    private function isUserLoggedIn()
    {
        return isset($_COOKIE['logged_user']);
    }

    private function renderFruitList($fields = [])
    {
        $fruits = $this->fruitRepository->getAllFruit();
        $decryptedEmail = $this->getDecryptedEmail();
        $this->render('fruit_list', ['email' => $decryptedEmail, 'fruits' => $fruits] + $fields);
    }


    private function getDecryptedEmail()
    {
        $encryptionKey = '2w5z8eAF4lLknKmQpSsVvYy3cd9gNjRm';
        $iv = '1234567891011121';

        // Deszyfrowanie
        $decryptedData = openssl_decrypt($_COOKIE['logged_user'], 'aes-256-cbc', $encryptionKey, 0, $iv);

        return $decryptedData;
    }

    private function handleAddFruit()
    {
        $typeFruit = $_POST['typeFruit'];

        if (empty($typeFruit)) {
            $this->renderFruitList(["addFruitMsg" => "Fruit name invalid"]);
            exit;
        }

        $fruit = new Fruit($typeFruit, 0);
        $fruitRepository = new FruitRepository();
        $result = $fruitRepository->addFruit($fruit);

        if ($result) {
            $message = 'Fruit added successfully.';
        } else {
            $message = 'Failed to add fruit.';
        }
        $this->renderFruitList(["addFruitMsg" => $message]);
    }

    public function handleRemoveFruit()
    {
        $typeFruit = $_POST['typeFruit'];

        if (empty($typeFruit)) {
            $this->renderFruitList(["removeFruitMsg" => "Fruit name invalid"]);
            exit;
        }

        $result = $this->fruitRepository->removeFruit($typeFruit);

        if ($result) {
            $message = 'Fruit removed successfully.';
        } else {
            $message = 'Failed to remove fruit.';
        }
        $this->renderFruitList(["removeFruitMsg" => $message]);
    }
}



