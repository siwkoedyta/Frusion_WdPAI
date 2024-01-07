<?php
require_once 'AppController.php';
require_once __DIR__ . '/../repository/StatusFrusionRepository.php';
require_once __DIR__ . '/../repository/TransactionRepository.php';
require_once __DIR__ . '/../repository/BoxRepository.php';
require_once __DIR__ . '/../repository/FruitRepository.php';

class StatusFrusionController extends AppController
{
    private $message = [];
    private $statusFrusionRepository;
    private $transactionRepository;
    private $boxRepository;
    private $fruitRepository;


    public function __construct()
    {
        parent::__construct();
        $this->statusFrusionRepository = new StatusFrusionRepository();
        $this->transactionRepository = new TransactionRepository();
        $this->boxRepository = new BoxRepository();
        $this->fruitRepository = new FruitRepository();

    }

    public function status_frusion($messages = [])
    {
        if (!$this->isUserLoggedIn()) {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/panel_logowania", true, 303);
            exit();
        }

        switch ($_SERVER['REQUEST_METHOD']) {
            case "GET":
                $this->renderStatusFrusion();
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

    private function renderStatusFrusion($fields = [])
    {
        $decryptedEmail = $this->getDecryptedEmail();

        $transactions = $this->transactionRepository->getAllTransactions();
        $boxes = $this->boxRepository->getAllBoxes();
        $fruits = $this->fruitRepository->getAllFruit();

        $boxesSum = [];
        $fruitsAmountSum = [];
        $fruitsWeightSum = [];

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

                // Accumulate the total weight for each fruit
                if (!isset($fruitsWeightSum[$fruitName])) {
                    $fruitsWeightSum[$fruitName] = $transaction->getWeight();
                } else {
                    $fruitsWeightSum[$fruitName] += $transaction->getWeight();
                }
            }
        }

// The code block you provided outside the main loop
        $fields += [
            'email' => $decryptedEmail,
            'allBoxesSum' => array_sum($boxesSum),
            'boxes' => $boxes,
            'boxesSum' => $boxesSum,
            'fruits' => $fruits,
            'fruitsAmountSum' => $fruitsAmountSum,
            'fruitsWeightSum' => $fruitsWeightSum,
        ];


        $this->render('status_frusion', $fields);
    }
}