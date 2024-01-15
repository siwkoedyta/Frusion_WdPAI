<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Admin.php';
require_once __DIR__ .'/../repository/UserRepository.php';
require_once __DIR__ .'/../repository/AdminRepository.php';
require_once __DIR__ .'/../repository/UserRepository.php';

class SecurityController extends AppController {
    private $authHelper;

    public function __construct()
    {
        parent::__construct();
        $this->authHelper = new AuthHelper();
    }

    public function panel_rejerstracji()
    {
        $AdminRepository = new AdminRepository();
        $UserRepository = new UserRepository();

        if (!$this->isPost()) {
            return $this->render('panel_rejerstracji');
        }

        $email = isset($_POST['email']) ? $_POST['email'] : null;

        if ($AdminRepository->adminExists($email)) {
            return $this->render('panel_rejerstracji', ['messages' => ['User with this email already exists!']]);
        }

        if ($UserRepository->userExists($email)) {
            return $this->render('panel_rejerstracji', ['messages' => ['Email already exists!']]);
        }

        $password = isset($_POST['password']) ? $_POST['password'] : null;
        $confirmedPassword = isset($_POST['repeat_password']) ? $_POST['repeat_password'] : null;
        $phone = isset($_POST['mobile']) ? $_POST['mobile'] : null;
        $frusion_name = isset($_POST['frusion_name']) ? $_POST['frusion_name'] : null;

        if (!$this->isPasswordValid($password)) {
            return $this->render('panel_rejerstracji', ['messages' => ['Passwords do not meet the requirements.']]);
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $admin = new Admin(null, $email, $hashedPassword, $phone, $frusion_name);
        $AdminRepository->addAdmin($admin);

        return $this->render('panel_logowania', ['messages' => ['You\'ve been successfully registered!']]);
    }
    public function panel_logowania() {

        $userRepository = new UserRepository();
        $adminRepository = new AdminRepository();

        if ($this->authHelper->isUserLoggedIn()) {
            $url = "http://$_SERVER[HTTP_HOST]";

            $decryptedEmail = $this->authHelper->getDecryptedEmail();
            $foundUser = $userRepository->getUser($decryptedEmail);
            $foundAdmin = $adminRepository->getAdmin($decryptedEmail);

            if ($foundUser) {
                header("Location: $url/panel_klienta");
            } elseif ($foundAdmin) {
                header("Location: $url/panel_glowny");
            }

            return;
        }

        if (!$this->isPost()) {
            return $this->render('panel_logowania');
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = $userRepository->getUser($email);
        $admin = $adminRepository->getAdmin($email);


        if ($user===false || $admin===false) {
            return $this->render('panel_logowania', ['messages' => ['The provided data is incorrect!']]);
        }

        $url = "http://$_SERVER[HTTP_HOST]";

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

    private function ustawCiasteczka($email) {
        $encryptionKey = '2w5z8eAF4lLknKmQpSsVvYy3cd9gNjRm';
        $iv = '1234567891011121';
        $cipher = "aes-256-cbc";
        $expire = time() + (60 * 60 * 24); // Przykładowy czas wygaśnięcia (1 dzień)
        $encryptedData = openssl_encrypt($email, $cipher, $encryptionKey, 0, $iv);
        setcookie('logged_user', $encryptedData, $expire, '/', '', true, true); //ustawiona flaga Secure-ciasteczko jest wysyłane tylko wtedy, gdy połączenie jest zabezpieczone, falga HttpOnly - zabezpiecza przed atakami XSS
    }

    private function usunCiasteczka() {
        setcookie('logged_user', '', time() - 3600, '/'); // Czas wygaśnięcia na przeszłą datę
    }

    public function wyloguj(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->usunCiasteczka();

            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/panel_logowania");
        } else {
            http_response_code(405);
            echo 'Metoda żądania nieprawidłowa';
        }
    }
    private function isPasswordValid($password)
    {
        return strlen($password) >= 4 && preg_match('/\d/', $password) && preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password);
    }
}