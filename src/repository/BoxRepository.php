<?php
require_once 'Repository.php';
require_once __DIR__ . '/../models/Box.php';
class BoxRepository extends Repository{
    private $authHelper;

    public function __construct()
    {
        parent::__construct();
        $this->authHelper = new AuthHelper();
    }
    public function getBox(int $boxId): ?Box
    {
        $stmt = $this->database->connect()->prepare('
        SELECT * FROM public."Box" WHERE "idBox" = :boxId
    ');

        $stmt->bindParam(':boxId', $boxId, PDO::PARAM_INT);
        $stmt->execute();

        $box = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($box === false) {
            return null;
        }

        return new Box(
            $box['idBox'],
            $box['typeBox'],
            $box['weightBox'],
            $box['idAdmin']
        );
    }
    public function getAllBoxesForAdmin(): array
    {
        $loggedInAdminId = $this->authHelper->getLoggedInAdminId();

        $boxes = [];
        $stmt = $this->database->connect()->prepare('SELECT * FROM public."Box" WHERE "idAdmin" = :loggedInAdminId');

        $stmt->bindParam(':loggedInAdminId', $loggedInAdminId, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $box) {
            $boxes[] = new Box(
                $box['idBox'],
                $box['typeBox'],
                $box['weightBox'],
                $box['idAdmin']
            );
        }

        return $boxes;
    }

    public function getAllBoxes(): array
    {
        $boxes = [];
        $stmt = $this->database->connect()->prepare('SELECT * FROM public."Box"');

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $box) {
            $boxes[] = new Box(
                $box['idBox'],
                $box['typeBox'],
                $box['weightBox'],
                $box['idAdmin']
            );
        }

        return $boxes;
    }
    public function getBoxById(int $idBox): ?Box
    {
        $stmt = $this->database->connect()->prepare('
    SELECT * FROM public."vwBoxView" WHERE "idBox" = :idBox
');

        $stmt->bindParam(':idBox', $idBox, PDO::PARAM_INT);
        $stmt->execute();

        $box = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($box === false) {
            return null;
        }

        return new Box(
            $box['idBox'],
            $box['typeBox'],
            $box['weightBox'],
            $box['idAdmin']
        );
    }

    public function boxNameExistsForAdmin($boxType,$idAdmin): bool
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public."Box" WHERE "typeBox" = :boxType AND "idAdmin" = :idAdmin
        ');

        $stmt->bindParam(':boxType', $boxType, PDO::PARAM_STR);
        $stmt->bindParam(':idAdmin', $idAdmin, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function addBoxes($typeBox, $weightBox): bool
    {
        try {
            $loggedInAdminId = $this->authHelper->getLoggedInAdminId();
            $stmt = $this->database->connect();

            $stmt->beginTransaction();

            $stmtInsertBox = $stmt->prepare('
            INSERT INTO public."Box" ("typeBox", "weightBox","idAdmin") 
            VALUES (:typeBox, :weightBox, :idAdmin)
        ');

            $stmtInsertBox->bindParam(':typeBox', $typeBox, PDO::PARAM_STR);
            $stmtInsertBox->bindParam(':weightBox', $weightBox, PDO::PARAM_INT);  // Corrected binding
            $stmtInsertBox->bindParam(':idAdmin', $loggedInAdminId, PDO::PARAM_INT);

            $stmtInsertBox->execute();

            $stmt->commit();

            return true; // Success
        } catch (PDOException $e) {
            $stmt = $this->database->connect();
            $stmt->rollBack();

            echo "Error: " . $e->getMessage();
            return false; // Error
        }
    }

    public function removeBox(string $idBox): bool
    {
        try {
            $stmt = $this->database->connect();

            $stmt->beginTransaction();

            $stmtDeleteBox = $stmt->prepare('
            DELETE FROM public."Box"
            WHERE "idBox" = :idBox
        ');

            $stmtDeleteBox->bindParam(':idBox', $idBox, PDO::PARAM_INT);
            $stmtDeleteBox->execute();

            $stmt->commit();

            return true; // Success
        } catch (PDOException $e) {
            $stmt = $this->database->connect();
            $stmt->rollBack();

            echo "Error: " . $e->getMessage();
            return false; // Error
        }
    }

    public function hasTransactionsForBox(string $idBox): bool
    {
        try {
            $stmt = $this->database->connect();

            $stmtCheckTransactions = $stmt->prepare('
            SELECT COUNT(*) as "transactionCount"
            FROM public."Transaction"
            WHERE "idBox" = :idBox
        ');

            $stmtCheckTransactions->bindParam(':idBox', $idBox, PDO::PARAM_INT);
            $stmtCheckTransactions->execute();

            $result = $stmtCheckTransactions->fetch(PDO::FETCH_ASSOC);

            return ($result['transactionCount'] > 0);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false; // Error
        }
    }


}