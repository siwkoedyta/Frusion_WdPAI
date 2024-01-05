<?php
require_once 'AppController.php';
require_once __DIR__ . '/../models/Box.php';
require_once __DIR__ . '/../repository/BoxRepository.php';


class BoxController extends AppController
{
    private $message = [];
    private $boxRepository;

    public function __construct()
    {
        parent::__construct();
        $this->boxRepository = new BoxRepository();
    }
    public function boxes($messages = [])
    {
        if (!$this->isUserLoggedIn()) {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: $url/panel_logowania", true, 303);
            exit();
        }

        switch ($_SERVER['REQUEST_METHOD']) {
            case "GET":
                $this->renderBoxList();
                break;
            case "POST":
                switch ($_POST['type']) {
                    case "addBox":
                        $this->handleAddBox();
                        break;
                    case "removeBox":
                        $this->handleRemoveBox();
                        break;
                }
                break;
        }
    }

    private function isUserLoggedIn() {
        return isset($_COOKIE['logged_user']);
    }
    private function getDecryptedEmail() {
        $encryptionKey = '2w5z8eAF4lLknKmQpSsVvYy3cd9gNjRm';
        $iv = '1234567891011121';

        // Deszyfrowanie
        $decryptedData = openssl_decrypt($_COOKIE['logged_user'], 'aes-256-cbc', $encryptionKey, 0, $iv);

        return $decryptedData;
    }


    public function renderBoxList($fields = []) {
        $boxes = $this->boxRepository->getAllBoxes();
        $decryptedEmail = $this->getDecryptedEmail();
        $this->render('boxes', ['email' => $decryptedEmail,'boxes' => $boxes]+ $fields);
    }

    public function handleAddBox()
    {
        $typeBox = $_POST['box_name'];
        $weightBox = $_POST['box_weight'];

        if (empty($typeBox) || empty($weightBox)) {
            $this->renderBoxList(["addBoxMsg" => "Invalid form data"]);
            exit;
        }

        $boxNameExists = $this->boxRepository->boxNameExists($typeBox);
        if ($boxNameExists) {
            $this->renderBoxList(["addBoxMsg" => "Box already exists"]);
            exit;
        }
        $result = $this->boxRepository->addBoxes($typeBox, $weightBox);

        if ($result) {
            $message = 'Box added successfully.';
        } else {
            $message = 'Failed to add box.';
        }
        $this->renderBoxList(["addBoxMsg" => $message]);

    }

    public function handleRemoveBox()
    {
        $idBox = $_POST['idBox'];

        if (empty($idBox)) {
            $this->renderBoxList(["removeBoxMsg" => "Box name invalid"]);
            exit;
        }

        $result = $this->boxRepository->removeBox($idBox);

        if ($result) {
            $message = 'Box removed successfully.';
        } else {
            $message = 'Failed to remove box.';
        }
        $this->renderBoxList(["removeBoxMsg" => $message]);

    }

}



