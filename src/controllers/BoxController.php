<?php
require_once 'AppController.php';
require_once __DIR__ . '/../models/Box.php';
require_once __DIR__ . '/../repository/BoxRepository.php';


class BoxController extends AppController
{
    private $message = [];
    private $boxRepository;
    private $authHelper;


    public function __construct()
    {
        parent::__construct();
        $this->boxRepository = new BoxRepository();
        $this->authHelper = new AuthHelper();
    }
    public function boxes($messages = [])
    {
        if (!$this->authHelper->isUserLoggedIn()) {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: $url/panel_logowania", true, 303);
            exit();
        }

        switch ($_SERVER['REQUEST_METHOD']) {
            case "GET":
                $this->renderBoxList();
                break;
            case "POST":
                switch ($_POST['type']) {
                    case "addBox":
                        $this->handleAddBox();
                        break;
                    case "removeBox":
                        $this->handleRemoveBox();
                        break;
                }
                break;
        }
    }

    public function renderBoxList($fields = []) {
        $boxes = $this->boxRepository->getAllBoxesForAdmin();
        $decryptedEmail = $this->authHelper->getDecryptedEmail();
        $this->render('boxes', ['email' => $decryptedEmail,'boxes' => $boxes]+ $fields);
    }

    public function handleAddBox(){
        $typeBox = $_POST['box_name'];
        $weightBox = $_POST['box_weight'];

        if (empty($typeBox) || empty($weightBox)) {
            $this->renderBoxList(["addBoxMsg" => "Invalid form data"]);
            exit;
        }

        $loggedInAdminId = $this->boxRepository->getLoggedInAdminId();
        $boxNameExists = $this->boxRepository->boxNameExistsForAdmin($typeBox,$loggedInAdminId);
        if ($boxNameExists) {
            $this->renderBoxList(["addBoxMsg" => "Box already exists"]);
            exit;
        }
        $result = $this->boxRepository->addBoxes($typeBox, $weightBox);

        if ($result) {
            $message = 'Box added successfully.';
        } else {
            $message = 'Failed to add box.';
        }
        $this->renderBoxList(["addBoxMsg" => $message]);

    }

    public function handleRemoveBox(){
        $idBox = $_POST['idBox'];

        if (empty($idBox)) {
            $this->renderBoxList(["removeBoxMsg" => "Box name invalid"]);
            exit;
        }

        $result = $this->boxRepository->removeBox($idBox);

        if ($result) {
            $message = 'Box removed successfully.';
        } else {
            $message = 'Failed to remove box.';
        }
        $this->renderBoxList(["removeBoxMsg" => $message]);

    }

}



