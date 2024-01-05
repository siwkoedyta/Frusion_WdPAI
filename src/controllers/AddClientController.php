<?php
require_once 'AppController.php';

class AddClientController extends AppController{
    private $message = [];
    private $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }
    public function add_client($messages = [])
    {
        if (!$this->isUserLoggedIn()) {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/panel_logowania", true, 303);
            exit();
        }

        switch ($_SERVER['REQUEST_METHOD']) {
            case "GET":
                $this->renderClients();
                break;
            case "POST":
                switch ($_POST['type']) {
                    case "addClient":
                        $this->handleAddClient();
                        break;
                }
                break;
        }
    }

    private function renderClients($fields = [])
    {
        $decryptedEmail = $this->getDecryptedEmail();
        $this->render('add_client', ['email' => $decryptedEmail] + $fields);
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

    public function handleAddClient() {

        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
            $this->renderClients(["addUserMsg" => "Invalid form data"]);
            exit;
        }

        $userEmailExists = $this->userRepository->userEmailExists($email);
        if ($userEmailExists) {
            $this->renderClients(["addUserMsg" => "User already exists"]);
            exit;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $result = $this->userRepository->addClient($firstName,$lastName,$email,$hashedPassword);

        if ($result) {
            $message = 'User added successfully.';
        } else {
            $message = 'Failed to add user.';
        }
        $this->renderClients(["addUserMsg" => $message]);

    }

}