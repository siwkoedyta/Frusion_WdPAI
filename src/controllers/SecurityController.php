<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Admin.php';
require_once __DIR__ .'/../repository/UserRepository.php';
require_once __DIR__ .'/../repository/AdminRepository.php';

class SecurityController extends AppController {

    public function panel_rejerstracji()
    {
        $AdminRepository = new AdminRepository();

        if (!$this->isPost()) {
            return $this->render('panel_rejerstracji');
        }

        $email = isset($_POST['email']) ? $_POST['email'] : null;
        $password = isset($_POST['password']) ? $_POST['password'] : null;
        $confirmedPassword = isset($_POST['repeat_password']) ? $_POST['repeat_password'] : null;
        $phone = isset($_POST['mobile']) ? $_POST['mobile'] : null;
        $frusion_name = isset($_POST['frusion_name']) ? $_POST['frusion_name'] : null;

        if (!$email || !$password || !$confirmedPassword || !$phone || !$frusion_name) {
            return $this->render('panel_rejerstracji', ['messages' => ['Please fill in all the fields']]);
        }

        if (strlen(preg_replace('/[^a-zA-Z]/', '', $password)) < 4) {
            return $this->render('panel_rejerstracji', ['messages' => ['Password must contain at least 4 letters']]);
        }

        if ($password !== $confirmedPassword) {
            return $this->render('panel_rejerstracji', ['messages' => ['Please provide proper password']]);
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Dodanie administratora do bazy danych
        $admin = new Admin($email, $hashedPassword, $phone, $frusion_name);
        $AdminRepository->addAdmin($admin);

        return $this->render('panel_logowania', ['messages' => ['You\'ve been succesfully registrated!']]);
    }
    public function panel_logowania() {

        $userRepository = new UserRepository();
        $adminRepository = new AdminRepository();

        // Sprawdź, czy użytkownik lub admin są już zalogowani
        if ($this->isUserLoggedIn()) {
            $url = "http://$_SERVER[HTTP_HOST]";

            // Tutaj możesz umieścić swoją logikę do sprawdzania, czy zalogowany użytkownik to admin czy klient
            $decryptedEmail = $this->getDecryptedEmail();
            $foundUser = $userRepository->getUser($decryptedEmail);
            $foundAdmin = $adminRepository->getAdmin($decryptedEmail);

            if ($foundUser) {
                // Przykład: przekieruj na panel klienta, jeśli użytkownik jest zalogowany
                header("Location: $url/panel_klienta");
            } elseif ($foundAdmin) {
                // Przykład: przekieruj na panel główny, jeśli admin jest zalogowany
                header("Location: $url/panel_glowny");
            }

            return;
        }

        if (!$this->isPost()) {
            return $this->render('panel_logowania');
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        // Sprawdź, czy email należy do użytkownika
        $user = $userRepository->getUser($email);

        // Sprawdź, czy email należy do administratora
        $admin = $adminRepository->getAdmin($email);


        if ($user===false || $admin===false) {
            return $this->render('panel_logowania', ['messages' => ['The provided data is incorrect!']]);
        }

        $url = "http://$_SERVER[HTTP_HOST]";

        //password_verify($password, $user->getPassword())
        //password_verify($password, $admin->getPassword())
        if ($user && password_verify($password, $user->getPassword())) {
            $this->ustawCiasteczka($user->getEmail());
            header("Location: $url/panel_klienta");
        } elseif ($admin &&password_verify($password, $admin->getPassword())) {
            $this->ustawCiasteczka($admin->getEmail());
            header("Location: $url/panel_glowny");
        } else {
            return $this->render('panel_logowania', ['messages' => ['The provided data is incorrect!']]);
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