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
    private $authHelper;

    public function __construct()
    {
        parent::__construct();
        $this->transactionRepository = new TransactionRepository();
        $this->fruitRepository = new FruitRepository();
        $this->boxRepository = new BoxRepository();
        $this->userRepository = new UserRepository();
        $this->authHelper = new AuthHelper();
    }

    public function panel_glowny($messages = [])
    {
        if (!$this->authHelper->isUserLoggedIn()) {
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
                    case "fillteringByData":
                        $this->renderHome();
                        break;
                }
            break;
        }
    }

    private function renderHome($fields = [])
    {
        $decryptedEmail = $this->authHelper->getDecryptedEmail();
        $idAdmin = $this->getLoggedInAdminId();
        $selectedDate = $_POST['selectedDate'] ?? null;
        $transactions = $this->transactionRepository->getTransactionsForAdminByDate($idAdmin, $selectedDate);
        $this->render('panel_glowny', ['email' => $decryptedEmail, 'transactions' => $transactions, 'selectedDate' => $selectedDate] + $fields);
    }

    private function handleAddTransaction()
    {
        if (!isset($_POST['first_name'], $_POST['last_name'], $_POST['id_fruit'], $_POST['weight_modal'], $_POST['id_box'], $_POST['number_of_boxes_modal'])) {
            $this->renderHome(["addTransactionMsg" => "Incomplete data provided."]);
            exit;
        }

        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $idFruit = $_POST['id_fruit'];
        $weightWithBoxes = floatval($_POST['weight_modal']);
        $idBox = $_POST['id_box'];
        $numberOfBoxes = intval($_POST['number_of_boxes_modal']);

        $user = $this->userRepository->getUserByFirstName($firstName, $lastName);
        $loggedInAdminId = $this->authHelper->getLoggedInAdminId();
        $userEmailExists = $this->userRepository->userEmailExistsForAdmin($user->getEmail(),$loggedInAdminId);
        if(!$userEmailExists) {
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
    public function getLoggedInAdminId()
    {
        $decryptedEmail = $this->authHelper->getDecryptedEmail();

        $adminRepository = new AdminRepository();
        $admin = $adminRepository->getAdmin($decryptedEmail);

        if ($admin) {
            return $admin->getIdAdmin();
        }

        return null;
    }
}



