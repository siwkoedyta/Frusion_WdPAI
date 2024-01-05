<?php

require_once 'AppController.php';

class ChangePasswordController extends AppController
{
    private $message = [];
    private $userRepository;
    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }
    public function change_password($messages = []) {
        if (!$this->isUserLoggedIn()) {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/change_password", true, 303);
            exit();
        }

        switch ($_SERVER['REQUEST_METHOD']) {
            case "GET":
                $this->renderChangePassword();
                break;
            case "POST":
                switch ($_POST['type']) {
                    case "changePassword":
                        $this->handleChangePassword();
                        break;
                }
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

    private function renderChangePassword($fields = [])
    {
        $decryptedEmail = $this->getDecryptedEmail();
        $this->render('change_password', ['email' => $decryptedEmail] + $fields);
    }

    public function handleChangePassword() {
        $currentPassword = $_POST['current_password'];
        $newPassword = $_POST['new_password'];
        $repeatNewPassword = $_POST['repeat_new_password'];

        if (empty($currentPassword) || empty($newPassword) || empty($repeatNewPassword)) {
            $this->renderChangePassword(["changePasswordMsg" => "Invalid form data"]);
            exit;
        }

        $userRepository = new UserRepository();
        $decryptedEmail = $this->getDecryptedEmail();
        $existingUser = $userRepository->getUser($decryptedEmail);

        if (!$existingUser || !password_verify($currentPassword, $existingUser->getPassword())) {
            $this->renderChangePassword(["changePasswordMsg" => "Invalid current password"]);
            exit;
        }

        if ($newPassword !== $repeatNewPassword) {
            $this->renderChangePassword(["changePasswordMsg" => "Passwords do not match"]);
            exit;
        }

        $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $existingUser->setPassword($hashedNewPassword);

        $result = $this->userRepository->setUserPassword($decryptedEmail,$hashedNewPassword);

        if ($result) {
            $message = 'Password has been changed.';
        } else {
            $message ="Password hasn't been changed.";
        }
        $this->renderChangePassword(["changePasswordMsg" => $message]);
    }

}