<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Fruit.php';

class FruitRepository extends Repository
{
    public function getFruit(int $fruitId): ?Fruit
    {
        $stmt = $this->database->connect()->prepare('
        SELECT f."typeFruit", p."price"
        FROM public."Fruit" f
        LEFT JOIN public."FruitPrices" p ON f."idFruit" = p."idFruit"
        WHERE f."idFruit" = :fruitId
    ');

        $stmt->bindParam(':fruitId', $fruitId, PDO::PARAM_INT);
        $stmt->execute();

        $fruit = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($fruit === false) {
            return null;
        }

        return new Fruit(
            $fruit['typeFruit'],
            $fruit['priceFruit']
        );
    }

    public function getAllFruit(): array
    {
        $fruits = [];
        $stmt = $this->database->connect()->prepare('
        SELECT f."idFruit", f."typeFruit", p."price"
        FROM public."Fruit" f
        LEFT JOIN public."FruitPrices" p ON f."idFruit" = p."idFruit"
    ');

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $fruit) {
            $fruits[] = new Fruit(
                $fruit['typeFruit'],
                $fruit['price']
            );
        }

        return $fruits;
    }

    public function getAllFruitNames(): array
    {
        $stmt = $this->database->connect()->prepare('
        SELECT "typeFruit"
        FROM public."Fruit"
    ');

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_COLUMN);

        return $result;
    }


    public function addFruit(Fruit $fruit): bool
    {
        try {
            $stmt = $this->database->connect();

            // Start a transaction to ensure atomicity
            $stmt->beginTransaction();

            // Insert into "Fruit" table
            $stmtFruit = $stmt->prepare('
            INSERT INTO public."Fruit" ("typeFruit") 
            VALUES (:typeFruit)
        ');

            $typeFruit = $fruit->getTypeFruit();
            $stmtFruit->bindParam(':typeFruit', $typeFruit, PDO::PARAM_STR);
            $stmtFruit->execute();

            // Get the last inserted ID (idFruit)
            $idFruit = $stmt->lastInsertId();

            // Insert into "FruitPrices" table with a default price of 0
            $stmtPrice = $stmt->prepare('
            INSERT INTO public."FruitPrices" ("idFruit", "price", "datePrice") 
            VALUES (:idFruit, :price, CURRENT_DATE)
        ');

            $defaultPrice = 0.0; // Set your default price here
            $stmtPrice->bindParam(':idFruit', $idFruit, PDO::PARAM_INT);
            $stmtPrice->bindParam(':price', $defaultPrice, PDO::PARAM_STR);
            $stmtPrice->execute();

            // Commit the transaction
            $stmt->commit();

            return true; // Success
        } catch (PDOException $e) {
            // Rollback the transaction in case of an error
            $stmt = $this->database->connect();
            $stmt->rollBack();

            // Handle the error
            echo "Error: " . $e->getMessage();
            return false; // Error
        }
    }

    public function removeFruit(string $fruitName): bool
    {
        try {
            $stmt = $this->database->connect();

            // Start a transaction to ensure atomicity
            $stmt->beginTransaction();

            // Get the idFruit for the given fruitName
            $stmtGetId = $stmt->prepare('
            SELECT "idFruit"
            FROM public."Fruit"
            WHERE "typeFruit" = :fruitName
        ');

            $stmtGetId->bindParam(':fruitName', $fruitName, PDO::PARAM_STR);
            $stmtGetId->execute();

            $idFruitResult = $stmtGetId->fetch(PDO::FETCH_ASSOC);

            if (!$idFruitResult) {
                // Fruit not found
                $stmt->rollBack();
                return false;
            }

            $idFruit = $idFruitResult['idFruit'];

            // Delete records from FruitPrices table
            $stmtDeletePrices = $stmt->prepare('
            DELETE FROM public."FruitPrices"
            WHERE "idFruit" = :idFruit
        ');

            $stmtDeletePrices->bindParam(':idFruit', $idFruit, PDO::PARAM_INT);
            $stmtDeletePrices->execute();

            // Delete record from Fruit table
            $stmtDeleteFruit = $stmt->prepare('
            DELETE FROM public."Fruit"
            WHERE "idFruit" = :idFruit
        ');

            $stmtDeleteFruit->bindParam(':idFruit', $idFruit, PDO::PARAM_INT);
            $stmtDeleteFruit->execute();

            // Commit the transaction
            $stmt->commit();

            return true; // Success
        } catch (PDOException $e) {
            // Rollback the transaction in case of an error
            $stmt = $this->database->connect();
            $stmt->rollBack();

            // Handle the error
            echo "Error: " . $e->getMessage();
            return false; // Error
        }
    }

}