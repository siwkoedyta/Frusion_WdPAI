<?php

require_once 'AppController.php';
require_once __DIR__ .'/../models/User.php';

class SecurityController extends AppController {

    public function panel_logowania()
    {

        $users = [
            new User('alice@example.com', 'user', '777111222', 'Johnson'),
            new User('bob@example.com', 'admin', '555555555', 'Smith'),
            new User('charlie@example.com', 'user', '666666666', 'Brown'),
            new User('diana@example.com', 'admin', '444555666', 'Williams'),
            new User('edward@example.com', 'user', '111222333', 'Miller'),
        ];


        if (!$this->isPost()) {
            return $this->render('panel_logowania');
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        $foundUser = null;

        foreach ($users as $user) {
            if ($user->getEmail() === $email) {
                $foundUser = $user;
                break;
            }
        }

        if (!$foundUser) {
            return $this->render('panel_logowania', ['messages' => ['The provided data is incorrect!']]);
        }

        if ($foundUser->getPassword()!== $password) {
            return $this->render('panel_logowania', ['messages' => ['The provided data is incorrect!']]);
        }

        // Logowanie udane - ustawienie ciasteczka
        $this->ustawCiasteczka($foundUser->getEmail());

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/panel_glowny");
    }

    // Funkcja do ustawiania ciasteczka logowania
    private function ustawCiasteczka($email) {
        $expire = time() + (60 * 60 * 24); // Przykładowy czas wygaśnięcia (1 dzień)
        setcookie('logged_user', $email, $expire, '/');
    }

    // Funkcja do usuwania ciasteczka logowania
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

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $user = new User($email, $hashedPassword, $mobile, $frusion_name);


        return $this->render('panel_logowania', ['messages' => ['You\'ve been succesfully registrated!']]);
    }
}