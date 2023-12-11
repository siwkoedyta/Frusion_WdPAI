<?php
require_once 'AppController.php';

class AddClientController extends AppController{
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

    public function add_client_form() {
        // Sprawdź czy formularz został wysłany
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Odczytaj dane z formularza
            $name = $_POST['name'];
            $lastName = $_POST['last_name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Dodaj walidację (przykładowe sprawdzenie, należy dostosować do potrzeb)
            if (empty($name) || empty($lastName) || empty($email) || empty($password)) {
                // Handle validation error, for example:
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Invalid form data']);
                exit;
            }

            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Utwórz obiekt użytkownika
            $user = new User($name, $lastName, $email, $hashedPassword);

            // Użyj repozytorium, aby dodać użytkownika do bazy danych
            $userRepository = new UserRepository();
            $result = $userRepository->add_client_form($user);

            header('Content-Type: application/json');
            if ($result) {
                echo json_encode(['status' => 'success','message' => 'User added.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to add user.']);
            }
            exit;
        }
    }

}