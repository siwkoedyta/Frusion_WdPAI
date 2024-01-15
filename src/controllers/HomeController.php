<?php
session_start();

require_once 'AppController.php';
require_once __DIR__ . '/../models/Transaction.php';
require_once __DIR__ . '/../models/Admin.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../repository/TransactionRepository.php';
require_once __DIR__ . '/../repository/UserRepository.php';
require_once __DIR__ . '/../repository/BoxRepository.php';
require_once __DIR__ . '/../repository/FruitRepository.php';
require_once __DIR__ . '/../repository/AdminRepository.php';


class HomeController extends AppController
{
    private $message = [];
    private $transactionRepository;
    private $fruitRepository;
    private $boxRepository;
    private $userRepository;
    private $adminRepository;

    private $authHelper;

    public function __construct()
    {
        parent::__construct();
        $this->transactionRepository = new TransactionRepository();
        $this->fruitRepository = new FruitRepository();
        $this->boxRepository = new BoxRepository();
        $this->adminRepository = new AdminRepository();
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

        // Sprawdź czy istnieje komunikat o pomyślnym dodaniu transakcji
        if (isset($_GET['addTransactionMsg']) && $_GET['addTransactionMsg'] === 'success') {
            // Jeśli tak, wyczyść dane POST i przekieruj na stronę główną
            header("Location: /panel_glowny");
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
        $frusionName = ($this->adminRepository->getAdmin($decryptedEmail))->getFrusionName();
        $selectedDate = $_POST['selectedDate'] ?? date('Y-m-d');
        $transactions = $this->transactionRepository->getTransactionsForAdminByDate($idAdmin, $selectedDate);
        $data = $this->collectDataForOneDay();


        $fields += [
            'email' => $decryptedEmail,
            'frusionName' => $frusionName,
            'allBoxesSum' => array_sum($data['boxesSum']),
            'boxes' => $data['boxes'],
            'boxesSum' => $data['boxesSum'],
            'fruits' => $data['fruits'],
            'fruitsAmountSum' => $data['fruitsAmountSum'],
            'fruitsWeightSum' => $data['fruitsWeightSum'],
            'boxesSumForFruits' => $data['boxesSumForFruits'],
            'transactions' => $transactions,
            'selectedDate' => $selectedDate,
        ];

        $this->render('panel_glowny', $fields);
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

        if ($weight < 0) {
            $this->renderHome(["addTransactionMsg" => "Weight cannot be less than 0."]);
            exit;
        }
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
            // Pomyślnie dodano transakcję, przekieruj użytkownika na inną stronę
            header("Location: /panel_glowny?addTransactionMsg=success");
            exit;
        } else {
            // Błąd podczas dodawania transakcji
            $this->renderHome(["addTransactionMsg" => 'Failed to add transaction.']);
        }
    }

    public function collectDataForOneDay()
    {
        $idAdmin = $this->authHelper->getLoggedInAdminId();
        $selectedDate = $_POST['selectedDate'] ?? null;
        $transactions = $this->transactionRepository->getTransactionsForAdminByDate($idAdmin, $selectedDate);
        $boxes = $this->boxRepository->getAllBoxes();
        $fruits = $this->fruitRepository->getAllFruitForAdmin();

        $boxesSum = [];
        $fruitsAmountSum = [];
        $fruitsWeightSum = [];
        $boxesSumForFruits = [];

        foreach ($transactions as $transaction) {
            $box = $this->boxRepository->getBoxById($transaction->getIdTypeBox())->getTypeBox();

            if (!isset($boxesSum[$box])) {
                $boxesSum[$box] = $transaction->getNumberOfBoxes();
            } else {
                $boxesSum[$box] += $transaction->getNumberOfBoxes();
            }

            $fruit = $this->fruitRepository->getFruitByPriceId($transaction->getIdPriceFruit());
            if ($fruit !== null) {
                $fruitName = $fruit->getTypeFruit();
                if (!isset($fruitsAmountSum[$fruitName])) {
                    $fruitsAmountSum[$fruitName] = $transaction->getAmount();
                } else {
                    $fruitsAmountSum[$fruitName] += $transaction->getAmount();
                }

                if (!isset($fruitsWeightSum[$fruitName])) {
                    $fruitsWeightSum[$fruitName] = $transaction->getWeight();
                } else {
                    $fruitsWeightSum[$fruitName] += $transaction->getWeight();
                }

                if (!isset($boxesSumForFruits[$fruitName][$box])) {
                    $boxesSumForFruits[$fruitName][$box] = $transaction->getNumberOfBoxes();
                } else {
                    $boxesSumForFruits[$fruitName][$box] += $transaction->getNumberOfBoxes();
                }

            }
        }

        return [
            'transactions' => $transactions,
            'boxes' => $boxes,
            'fruits' => $fruits,
            'boxesSum' => $boxesSum,
            'fruitsAmountSum' => $fruitsAmountSum,
            'fruitsWeightSum' => $fruitsWeightSum,
            'boxesSumForFruits' => $boxesSumForFruits,
        ];
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



