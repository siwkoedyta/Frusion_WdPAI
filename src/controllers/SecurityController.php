<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';

class SecurityController extends AppController {
    private $users;

    public function __construct() {
        parent::__construct();

        $this->users = [
            new User('alice@example.com', 'users', '777111222', 'Johnson', 'employee'),
            new User('bob@example.com', 'admin', '555555555', 'Smith', 'employee'),
            new User('charlie@example.com', 'user', '666666666', 'Brown', 'employee'),
            new User('diana@example.com', 'admin', '444555666', 'Williams', 'client'),
            new User('edward@example.com', 'user', '111222333', 'Miller', 'client'),
        ];
    }
    public function panel_rejerstracji()
    {
        if (!$this->isPost()) {
            return $this->render('panel_rejerstracji');
        }

        $email = isset($_POST['email']) ? $_POST['email'] : null;
        $password = isset($_POST['password']) ? $_POST['password'] : null;
        $confirmedPassword = isset($_POST['repeat_password']) ? $_POST['repeat_password'] : null;
        $mobile = isset($_POST['mobile']) ? $_POST['mobile'] : null;
        $frusion_name = isset($_POST['frusion_name']) ? $_POST['frusion_name'] : null;

        if (!$email || !$password || !$confirmedPassword || !$mobile || !$frusion_name) {
            return $this->render('panel_rejerstracji', ['messages' => ['Please fill in all the fields']]);
        }

        if (strlen(preg_replace('/[^a-zA-Z]/', '', $password)) < 4) {
            return $this->render('panel_rejerstracji', ['messages' => ['Password must contain at least 4 letters']]);
        }

        if ($password !== $confirmedPassword) {
            return $this->render('panel_rejerstracji', ['messages' => ['Please provide proper password']]);
        }
        // Dodanie soli do hasła
        $salt = bin2hex(random_bytes(16)); // Generowanie losowej soli
        $hashedPassword = password_hash($password . $salt, PASSWORD_DEFAULT);
        $user = new User($email, $hashedPassword, $mobile, $frusion_name);


        return $this->render('panel_logowania', ['messages' => ['You\'ve been succesfully registrated!']]);
    }
    public function panel_logowania() {
        if (isset($_COOKIE['logged_user'])) {
            $decryptedEmail = $this->getDecryptedEmail();
            $foundUser = $this->getUserByEmail($decryptedEmail);

            if (!$foundUser) {
                echo 'User not found!';
                return;
            }

            $userRole = $foundUser->getRole();
            $url = "http://$_SERVER[HTTP_HOST]";

            if ($userRole == 'client') {
                header("Location: {$url}/panel_klienta");
            } elseif ($userRole == 'employee') {
                header("Location: {$url}/panel_glowny");
            } else {
                echo 'Invalid user role!';
            }

            return;
        }

        if (!$this->isPost()) {
            return $this->render('panel_logowania');
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        $foundUser = null;

        foreach ($this->users as $user) {
            if ($user->getEmail() === $email) {
                $foundUser = $user;
                break;
            }
        }

        if (!$foundUser || $foundUser->getPassword() !== $password) {
            return $this->render('panel_logowania', ['messages' => ['The provided data is incorrect!']]);
        }

        $this->ustawCiasteczka($foundUser->getEmail());
        $userRole = $foundUser->getRole();
        $url = "http://$_SERVER[HTTP_HOST]";

        if ($userRole == 'client') {
            header("Location: {$url}/panel_klienta");
        } elseif ($userRole == 'employee') {
            header("Location: {$url}/panel_glowny");
        } else {
            echo 'Invalid user role!';
        }
    }

    private function getUserByEmail($email) {
        foreach ($this->users as $user) {
            if ($user->getEmail() === $email) {
                return $user;
            }
        }

        return null;
    }

    private function ustawCiasteczka($email) {
        $encryptionKey = '2w5z8eAF4lLknKmQpSsVvYy3cd9gNjRm';
        $iv = '1234567891011121';
        $cipher = "aes-256-cbc";
        $expire = time() + (60 * 60 * 24); // Przykładowy czas wygaśnięcia (1 dzień)
        $encryptedData = openssl_encrypt($email, $cipher, $encryptionKey, 0, $iv);
        setcookie('logged_user', $encryptedData, $expire, '/', '', true, true); //ustawiona flaga Secure-ciasteczko jest wysyłane tylko wtedy, gdy połączenie jest zabezpieczone, falga HttpOnly - zabezpiecza przed atakami XSS
    }

    private function usunCiasteczka() {
        setcookie('logged_user', '', time() - 3600, '/'); // Ustaw czas wygaśnięcia na przeszłą datę
    }

    public function wyloguj(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Usuń ciasteczko logowania
            $this->usunCiasteczka();

            // Przekieruj użytkownika na stronę logowania
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/panel_logowania");
        } else {
            // Obsługa błędu - nieprawidłowa metoda żądania
            http_response_code(405); // Method Not Allowed
            echo 'Metoda żądania nieprawidłowa';
        }
    }


    private function isUserLoggedIn()
    {
        return !empty($_COOKIE['logged_user']);
    }
    private function getDecryptedEmail() {
        $encryptionKey = '2w5z8eAF4lLknKmQpSsVvYy3cd9gNjRm';
        $iv = '1234567891011121';

        // Deszyfrowanie
        $decryptedData = openssl_decrypt($_COOKIE['logged_user'], 'aes-256-cbc', $encryptionKey, 0, $iv);

        return $decryptedData;
    }
    public function panel_glowny() {
        // Sprawdź, czy użytkownik jest zalogowany
        if (!$this->isUserLoggedIn()) {
            // Użytkownik nie jest zalogowany, przekieruj go na stronę logowania
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/panel_logowania", true, 303);
            exit();
        }

        // Odczytaj zdeszyfrowany email
        $decryptedEmail = $this->getDecryptedEmail();

        // Kontynuuj wyświetlanie strony panel_glowny
        $this->render('panel_glowny', ['email' => $decryptedEmail]);
    }

    public function panel_klienta() {
        if (!$this->isUserLoggedIn()) {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/panel_logowania", true, 303);
            exit();
        }

        $decryptedEmail = $this->getDecryptedEmail();
        $this->render('panel_klienta', ['email' => $decryptedEmail]);
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

    public function boxes() {
        if (!$this->isUserLoggedIn()) {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/panel_logowania", true, 303);
            exit();
        }

        $decryptedEmail = $this->getDecryptedEmail();
        $this->render('boxes', ['email' => $decryptedEmail]);
    }

    public function fruit_list() {
        if (!$this->isUserLoggedIn()) {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/panel_logowania", true, 303);
            exit();
        }

        $decryptedEmail = $this->getDecryptedEmail();
        $this->render('fruit_list', ['email' => $decryptedEmail]);
    }

    public function status_frusion() {
        if (!$this->isUserLoggedIn()) {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/panel_logowania", true, 303);
            exit();
        }

        $decryptedEmail = $this->getDecryptedEmail();
        $this->render('status_frusion', ['email' => $decryptedEmail]);
    }


}