<?php
require_once 'AppController.php';
require_once __DIR__ . '/../repository/TransactionRepository.php';
require_once __DIR__ . '/../repository/BoxRepository.php';
require_once __DIR__ . '/../repository/FruitRepository.php';

class StatusFrusionController extends AppController
{
    private $message = [];
    private $transactionRepository;
    private $boxRepository;
    private $fruitRepository;

    private $authHelper;

    public function __construct()
    {
        parent::__construct();
        $this->transactionRepository = new TransactionRepository();
        $this->boxRepository = new BoxRepository();
        $this->fruitRepository = new FruitRepository();
        $this->authHelper = new AuthHelper();
    }

    public function status_frusion($messages = [])
    {
        if (!$this->authHelper->isUserLoggedIn()) {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/panel_logowania", true, 303);
            exit();
        }

        switch ($_SERVER['REQUEST_METHOD']) {
            case "GET":
                $this->renderStatusFrusion();
                break;
            case "POST":
                switch ($_POST['type']) {
                    case "fillteringByDatas":
                        $this->renderStatusFrusion();
                        break;
                }
                break;

        }
    }
    private function renderStatusFrusion($fields = [])
    {
        $decryptedEmail = $this->authHelper->getDecryptedEmail();
        $idAdmin = $this->getLoggedInAdminId();
        $selectedDateStarting = $_POST['selectedDateStarting'] ?? null;
        $selectedDateEnd = $_POST['selectedDateEnd'] ?? null;

        $data = $this->collectDataForStatusFrusion();

        $fields += [
            'email' => $decryptedEmail,
            'allBoxesSum' => array_sum($data['boxesSum']),
            'boxes' => $data['boxes'],
            'boxesSum' => $data['boxesSum'],
            'fruits' => $data['fruits'],
            'fruitsAmountSum' => $data['fruitsAmountSum'],
            'fruitsWeightSum' => $data['fruitsWeightSum'],
            'boxesSumForFruits' => $data['boxesSumForFruits'],
            'selectedDateStarting' => $selectedDateStarting,
            'selectedDateEnd' => $selectedDateEnd,
        ];

        $this->render('status_frusion', $fields);
    }

    public function collectDataForStatusFrusion()
    {
        $idAdmin = $this->authHelper->getLoggedInAdminId();
        $selectedDateStarting = $_POST['selectedDateStarting'] ?? null;
        $selectedDateEnd = $_POST['selectedDateEnd'] ?? null;
        $transactions = $this->transactionRepository->getTransactionsForAdmin($idAdmin, $selectedDateStarting, $selectedDateEnd);
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

    public function getAuthHelper() {
        return $this->authHelper;
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