<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/Fruit.php';
require_once __DIR__ . '/../repository/FruitRepository.php';
require_once __DIR__ . '/../repository/TransactionRepository.php';



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
                    case "setPrice":
                        $this->handleSetPrice();
                        break;
                }
                break;
        }
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
    private function renderFruitList($fields = [])
    {
        $fruits = $this->fruitRepository->getAllFruitForAdmin();
        $decryptedEmail = $this->getDecryptedEmail();
        $this->render('fruit_list', ['email' => $decryptedEmail, 'fruits' => $fruits] + $fields);
    }

    private function handleAddFruit()
    {
        $typeFruit = $_POST['typeFruit'];

        if (empty($typeFruit)) {
            $this->renderFruitList(["addFruitMsg" => "Fruit name invalid"]);
            exit;
        }

        $loggedInAdminId = $this->fruitRepository->getLoggedInAdminId();
        $fruitTypeExists = $this->fruitRepository->fruitTypeExistsForAdmin($typeFruit, $loggedInAdminId);

        if ($fruitTypeExists) {
            $this->renderFruitList(["addFruitMsg" => "Fruit already exists for this admin"]);
            exit;
        }

        $result = $this->fruitRepository->addFruit($typeFruit);

        if ($result) {
            $message = 'Fruit added successfully.';
        } else {
            $message = 'Failed to add fruit.';
        }

        $this->renderFruitList(["addFruitMsg" => $message]);
    }

    public function handleRemoveFruit()
    {
        $idFruit = $_POST['idFruit'];

        if (empty($idFruit)) {
            $this->renderFruitList(["removeFruitMsg" => "Fruit name invalid"]);
            exit;
        }

        $result = $this->fruitRepository->removeFruit($idFruit);

        if ($result) {
            $message = 'Fruit removed successfully.';
        } else {
            $message = 'Failed to remove fruit.';
        }
        $this->renderFruitList(["removeFruitMsg" => $message]);
    }

    private function handleSetPrice()
    {
        $idFruit = $_POST['idFruit'];
        $newPrice = $_POST['newPrice'];

        if (empty($idFruit) || !is_numeric($newPrice)) {
            $this->renderFruitList(["setPriceMsg" => "Invalid input"]);
            exit;
        }

        // Update the price
        $result = $this->fruitRepository->setFruitPrice($idFruit, $newPrice);

        if ($result) {
            $message = 'Price updated successfully.';
        } else {
            $message = 'Failed to update price.';
        }
        $this->renderFruitList(["setPriceMsg" => $message]);
    }
}



