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
    public function addBoxes(Box $box): bool
    {
        try {
            $stmt = $this->database->connect()->prepare('
                INSERT INTO public."Box" ("typeBox", "weightBox") 
                VALUES (:typeBox, :weightBox)
            ');

            $typeBox = $box->getTypeBox();
            $weightBox = $box->getWeightBox();

            $stmt->bindParam(':typeBox', $typeBox, PDO::PARAM_STR);
            $stmt->bindParam(':weightBox', $weightBox, PDO::PARAM_INT);  // Corrected binding

            $stmt->execute();

            return true; // Sukces
        } catch (PDOException $e) {
            // Obsługa błędów
            echo "Error: " . $e->getMessage();
            return false; // Błąd
        }
    }


}