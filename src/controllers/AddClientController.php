<?php
require_once 'AppController.php';

class AddClientController extends AppController{
    private $message = [];
    private $userRepository;
    private $authHelper;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
        $this->authHelper = new AuthHelper();
    }
    public function add_client($messages = [])
    {
        if (!$this->authHelper->isUserLoggedIn()) {
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
        $decryptedEmail = $this->authHelper->getDecryptedEmail();
        $this->render('add_client', ['email' => $decryptedEmail] + $fields);
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

        $loggedInAdminId = $this->authHelper->getLoggedInAdminId();
        $userEmailExists = $this->userRepository->userEmailExistsForAdmin($email,$loggedInAdminId);
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