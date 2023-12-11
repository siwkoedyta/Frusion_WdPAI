<?php
require_once 'AppController.php';
require_once 'SecurityController.php';

class UserController extends AppController{
    private $UserRepository;

    public function __construct($UserRepository) {
        $this->UserRepository = $UserRepository;
    }
    public function add_client() {
        if (!$this->isUserLoggedIn()) {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/panel_logowania", true, 303);
            exit();
        }

        $decryptedEmail = $this->getDecryptedEmail();
        $this->render('add_client', ['email' => $decryptedEmail]);
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
    public function addUser() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Odbierz dane z formularza
            $firstName = $_POST["firstName"];
            $lastName = $_POST["lastName"];
            $email = $_POST["email"];
            $password = $_POST["password"];

            // Stwórz obiekt UserModel i dodaj do repozytorium
            $user = new User($firstName,$lastName, $email,$password);

            // Dodaj użytkownika
            $result = $this->UserRepository->addUser($user);

            if ($result) {
                // Sukces
                http_response_code(201); // Created
                echo json_encode(["message" => "User added successfully"]);
            } else {
                // Błąd
                http_response_code(500); // Internal Server Error
                echo json_encode(["message" => "Error adding user"]);
            }
        } else {
            // Nieprawidłowe żądanie
            http_response_code(400); // Bad Request
            echo json_encode(["message" => "Bad Request"]);
        }
    }
}