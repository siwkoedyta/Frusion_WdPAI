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

    public function boxes() {
        if (!$this->isUserLoggedIn()) {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/panel_logowania", true, 303);
            exit();
        }

        $boxes = $this->boxRepository->getAllBoxes();
        $decryptedEmail = $this->getDecryptedEmail();
        $this->render('boxes', ['email' => $decryptedEmail,'boxes' => $boxes]);
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
    public function add_boxes_form()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $typeBox = $_POST['box_name'];
            $weightBox = $_POST['box_weight'];

            if (empty($typeBox) || empty($weightBox)) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Invalid form data']);
                exit;
            }

            $box = new Box($typeBox, $weightBox);
            $boxRepository = new BoxRepository();
            $result = $boxRepository->addBoxes($box);

            header('Content-Type: application/json');
            if ($result) {
                echo json_encode(['status' => 'success', 'message' => 'Box added successfully']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to add box']);
            }

            exit;
        }
    }

    public function remove_boxes_form(){
        // Assuming you have a method to check if the user is logged in
        if (!$this->isUserLoggedIn()) {
            // Handle authentication error or redirect
            // For example:
            $this->render('login'); // Redirect to login page
            return;
        }

        // Assuming you have a method to get the decrypted email
        $decryptedEmail = $this->getDecryptedEmail();

        // Assuming you have a method to get the list of available boxes from the repository
        $boxes = $this->BoxRepository->getAllBoxes();

        $this->render('boxes', ['email' => $decryptedEmail, 'boxes' => $boxes]);
    }

}



