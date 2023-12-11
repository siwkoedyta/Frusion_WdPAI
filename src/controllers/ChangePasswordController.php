<?php

require_once 'AppController.php';

class ChangePasswordController extends AppController
{
    public function change_password() {
        if (!$this->isUserLoggedIn()) {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/change_password", true, 303);
            exit();
        }

        $decryptedEmail = $this->getDecryptedEmail();
        $this->render('change_password', ['email' => $decryptedEmail]);
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

    public function change_password_form() {
        // Sprawdź czy formularz został wysłany
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Odczytaj dane z formularza
            $currentPassword = $_POST['current_password'];
            $newPassword = $_POST['new_password'];
            $repeatNewPassword = $_POST['repeat_new_password'];

            // Dodaj walidację (przykładowe sprawdzenie, należy dostosować do potrzeb)
            if (empty($currentPassword) || empty($newPassword) || empty($repeatNewPassword)) {
                // Handle validation error, for example:
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Invalid form data']);
                exit;
            }

            $userRepository = new UserRepository();
            $decryptedEmail = $this->getDecryptedEmail();
            $existingUser = $userRepository->getUser($decryptedEmail);

            if (!$existingUser || !password_verify($currentPassword, $existingUser->getPassword())) {
                // Handle invalid current password, for example:
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Invalid current password']);
                exit;
            }

            // Sprawdź, czy nowe hasło i powtórzone nowe hasło są identyczne
            if ($newPassword !== $repeatNewPassword) {
                // Handle validation error, for example:
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Passwords do not match']);
                exit;
            }

            // Aktualizacja hasła
            $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $existingUser->setPassword($hashedNewPassword);
            $userRepository->updateUser($existingUser);


            header('Content-Type: application/json');
            echo json_encode(['status' => 'success','message' => 'Password has been changed']);
            exit;
        }

    }

}