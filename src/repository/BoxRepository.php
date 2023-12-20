<?php
require_once 'Repository.php';
require_once __DIR__ . '/../models/Box.php';
class BoxRepository extends Repository{
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
            $box['typeBox'],
            $box['weightBox']
        );
    }

    public function getAllBoxes(): array
    {
        $boxes = [];
        $stmt = $this->database->connect()->prepare('SELECT * FROM public."Box"');

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $box) {
            $boxes[] = new Box(
                $box['typeBox'],
                $box['weightBox']
            );
        }

        return $boxes;
    }
    public function getAllBoxNames(): array
    {
        $stmt = $this->database->connect()->prepare('
        SELECT "typeBox"
        FROM public."Box"
    ');

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_COLUMN);

        return $result;
    }

    public function addBoxes(Box $box): bool
    {
        try {
            $stmt = $this->database->connect();

            $stmt->beginTransaction();

            $stmtInsertBox = $stmt->prepare('
            INSERT INTO public."Box" ("typeBox", "weightBox") 
            VALUES (:typeBox, :weightBox)
        ');

            $typeBox = $box->getTypeBox();
            $weightBox = $box->getWeightBox();

            $stmtInsertBox->bindParam(':typeBox', $typeBox, PDO::PARAM_STR);
            $stmtInsertBox->bindParam(':weightBox', $weightBox, PDO::PARAM_INT);  // Corrected binding

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

    public function removeBox(string $boxName): bool
    {
        try {
            $stmt = $this->database->connect();

            $stmt->beginTransaction();

            $stmtGetId = $stmt->prepare('
            SELECT "idBox"
            FROM public."Box"
            WHERE "typeBox" = :boxName
        ');

            $stmtGetId->bindParam(':boxName', $boxName, PDO::PARAM_STR);
            $stmtGetId->execute();

            $idBoxResult = $stmtGetId->fetch(PDO::FETCH_ASSOC);

            if (!$idBoxResult) {
                $stmt->rollBack();
                return false;
            }

            $idBox = $idBoxResult['idBox'];

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


}