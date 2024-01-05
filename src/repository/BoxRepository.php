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
            $box['idBox'],
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
                $box['idBox'],
                $box['typeBox'],
                $box['weightBox']
            );
        }

        return $boxes;
    }
    public function getBoxById(int $idBox): ?Box
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public."Box" WHERE "idBox" = :idBox
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
            $box['weightBox']
        );
    }

    public function boxNameExists($boxType): bool
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public."Box" WHERE "typeBox" = :boxType
        ');

        $stmt->bindParam(':boxType', $boxType, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function addBoxes($typeBox, $weightBox): bool
    {
        try {
            $stmt = $this->database->connect();

            $stmt->beginTransaction();

            $stmtInsertBox = $stmt->prepare('
            INSERT INTO public."Box" ("typeBox", "weightBox") 
            VALUES (:typeBox, :weightBox)
        ');

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


}