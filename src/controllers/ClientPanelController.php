<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/Transaction.php';
require_once __DIR__ . '/../models/Admin.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../repository/TransactionRepository.php';
require_once __DIR__ . '/../repository/UserRepository.php';
require_once __DIR__ . '/../repository/BoxRepository.php';
require_once __DIR__ . '/../repository/FruitRepository.php';


class ClientPanelController extends AppController
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

    public function panel_klienta($messages = [])
    {
        if (!$this->authHelper->isUserLoggedIn()) {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/panel_logowania", true, 303);
            exit();
        }

        switch ($_SERVER['REQUEST_METHOD']) {
            case "GET":
                $this->renderClientPanel();
                break;
        }
    }
    public function getLoggedInUserId()
    {
        $decryptedEmail = $this->authHelper->getDecryptedEmail();
        $user = $this->userRepository->getUser($decryptedEmail);

        if ($user) {
            return $user->getIdUser();
        }

        return null;
    }

    private function renderClientPanel($fields = [])
    {
        $decryptedEmail = $this->authHelper->getDecryptedEmail();
        $idUser = $this->getLoggedInUserId();
        $transactions = $this->transactionRepository->getTransactionsForAdmin($idUser);
        $this->render('panel_klienta', ['email' => $decryptedEmail] + $fields);
    }
    public function collectDataClientPanel()
    {
        $idUser = $this->getLoggedInUserId();
        $transactions = $this->transactionRepository->getTransactionsForUser($idUser);
        $boxes = $this->boxRepository->getAllBoxes();
        $fruits = $this->fruitRepository->getAllFruit();

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

            $fruit = $this->fruitRepository->getFruitByPriceIdForUser($transaction->getIdPriceFruit());
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
}



