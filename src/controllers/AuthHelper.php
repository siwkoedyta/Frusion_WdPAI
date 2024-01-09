<?php

require_once __DIR__ . '/../repository/AdminRepository.php';

class AuthHelper
{

    public function isUserLoggedIn()
    {
        return isset($_COOKIE['logged_user']);
    }
    public function getLoggedInAdminId()
    {
        $loggedInAdminId = $this->getDecryptedAdminId();

        if ($loggedInAdminId) {
            return $loggedInAdminId;
        }

        return null;
    }

    public function getDecryptedAdminId()
    {
        $decryptedEmail = $this->getDecryptedEmail();
        $adminRepository = new AdminRepository();
        $admin = $adminRepository->getAdmin($decryptedEmail);

        if ($admin) {
            return $admin->getIdAdmin();
        }

        return null;
    }

    public function getDecryptedEmail()
    {
        $encryptionKey = '2w5z8eAF4lLknKmQpSsVvYy3cd9gNjRm';
        $iv = '1234567891011121';

        $decryptedData = openssl_decrypt($_COOKIE['logged_user'], 'aes-256-cbc', $encryptionKey, 0, $iv);

        return $decryptedData;
    }
}
?>