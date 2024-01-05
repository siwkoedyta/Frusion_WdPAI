<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/Transaction.php';
require_once __DIR__ . '/../models/Admin.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../repository/TransactionRepository.php';
require_once __DIR__ . '/../repository/UserRepository.php';
require_once __DIR__ . '/../repository/BoxRepository.php';
require_once __DIR__ . '/../repository/FruitRepository.php';


class HomeController extends AppController
{
    private $message = [];
    private $transactionRepository;
    private $fruitRepository;
    private $boxRepository;

    private $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->transactionRepository = new TransactionRepository();
        $this->fruitRepository = new FruitRepository();
        $this->boxRepository = new BoxRepository();
        $this->userRepository = new UserRepository();
    }

    public function panel_glowny($messages = [])
    {
        if (!$this->isUserLoggedIn()) {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: $url/panel_logowania", true, 303);
            exit();
        }

        switch ($_SERVER['REQUEST_METHOD']) {
            case "GET":
                $this->renderHome();
                break;
            case "POST":
                switch ($_POST['type']) {
                    case "addTransaction":
                        $this->handleAddTransaction();
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

    private function renderHome($fields = [])
    {
        $decryptedEmail = $this->getDecryptedEmail();
        $this->render('panel_glowny', ['email' => $decryptedEmail] + $fields);
    }

    private function handleAddTransaction()
    {
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $idFruit = $_POST['id_fruit'];
        $weightWithBoxes = floatval($_POST['weight_modal']);
        $idBox = $_POST['id_box'];
        $numberOfBoxes = intval($_POST['number_of_boxes_modal']);

        if (empty($firstName) || empty($lastName) || empty($idFruit) || empty($weightWithBoxes) || empty($idBox) || empty($numberOfBoxes)) {
            $this->renderHome(["addTransactionMsg" => "Complete all data."]);
            exit;
        }



        $user = $this->userRepository->getUserByFirstLastName($firstName, $lastName);
        if(!$user) {
            $this->renderHome(["addTransactionMsg" => "User not found"]);
            exit;
        }

        $fruit = $this->fruitRepository->getFruit($idFruit);
        if(!$fruit) {
            $this->renderHome(["addTransactionMsg" => "Fruit not found"]);
            exit;
        }

        $box = $this->boxRepository->getBox($idBox);
        if(!$box) {
            $this->renderHome(["addTransactionMsg" => "Box not found"]);
            exit;
        }


        $priceFruit = floatval($fruit->getPriceFruit());
        $boxWeight = floatval($box->getWeightBox());

        $weight = $weightWithBoxes - $boxWeight * $numberOfBoxes;
        $weight = max(0, $weight);
        $amount = $weight * $priceFruit;

        $result = $this->transactionRepository->addTransaction(
            $user->getIdUser(),
            $this->getLoggedInAdminId(),
            $weightWithBoxes,
            $idBox,
            $numberOfBoxes,
            $fruit->getPriceId(),
            date('Y-m-d'),
            $weight,
            $amount
        );

        if ($result) {
            $message = 'Transaction added successfully.';
        } else {
            $message = 'Failed to add transaction.';
        }
        $this->renderHome(["addTransactionMsg" => $message]);
    }
    private function getLoggedInAdminId()
    {
        $decryptedEmail = $this->getDecryptedEmail();

        $adminRepository = new AdminRepository();
        $admin = $adminRepository->getAdmin($decryptedEmail);

        if ($admin) {
            return $admin->getIdAdmin();
        }

        return null;
    }
}



