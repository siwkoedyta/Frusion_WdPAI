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

            $stmt->beginTransaction();

            $stmtFruit = $stmt->prepare('
            INSERT INTO public."Fruit" ("typeFruit") 
            VALUES (:typeFruit)
        ');

            $typeFruit = $fruit->getTypeFruit();
            $stmtFruit->bindParam(':typeFruit', $typeFruit, PDO::PARAM_STR);
            $stmtFruit->execute();

            $idFruit = $stmt->lastInsertId();

            $stmtPrice = $stmt->prepare('
            INSERT INTO public."FruitPrices" ("idFruit", "price", "datePrice") 
            VALUES (:idFruit, :price, CURRENT_DATE)
        ');

            $defaultPrice = 0.0;
            $stmtPrice->bindParam(':idFruit', $idFruit, PDO::PARAM_INT);
            $stmtPrice->bindParam(':price', $defaultPrice, PDO::PARAM_STR);
            $stmtPrice->execute();

            $stmt->commit();

            return true; // Success
        } catch (PDOException $e) {
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

            $stmt->beginTransaction();

            $stmtGetId = $stmt->prepare('
            SELECT "idFruit"
            FROM public."Fruit"
            WHERE "typeFruit" = :fruitName
        ');

            $stmtGetId->bindParam(':fruitName', $fruitName, PDO::PARAM_STR);
            $stmtGetId->execute();

            $idFruitResult = $stmtGetId->fetch(PDO::FETCH_ASSOC);

            if (!$idFruitResult) {
                $stmt->rollBack();
                return false;
            }

            $idFruit = $idFruitResult['idFruit'];

            $stmtDeletePrices = $stmt->prepare('
            DELETE FROM public."FruitPrices"
            WHERE "idFruit" = :idFruit
        ');

            $stmtDeletePrices->bindParam(':idFruit', $idFruit, PDO::PARAM_INT);
            $stmtDeletePrices->execute();

            $stmtDeleteFruit = $stmt->prepare('
            DELETE FROM public."Fruit"
            WHERE "idFruit" = :idFruit
        ');

            $stmtDeleteFruit->bindParam(':idFruit', $idFruit, PDO::PARAM_INT);
            $stmtDeleteFruit->execute();

            $stmt->commit();

            return true; // Success
        } catch (PDOException $e) {
            $stmt = $this->database->connect();
            $stmt->rollBack();

            echo "Error: " . $e->getMessage();
            return false; // Error
        }
    }

    public function setFruitPrice(string $typeFruit, float $newPrice): bool
    {
        try {
            $stmt = $this->database->connect();

            $stmt->beginTransaction();

            // Get the ID of the fruit
            $stmtGetId = $stmt->prepare('
                SELECT "idFruit"
                FROM public."Fruit"
                WHERE "typeFruit" = :typeFruit
            ');

            $stmtGetId->bindParam(':typeFruit', $typeFruit, PDO::PARAM_STR);
            $stmtGetId->execute();

            $idFruitResult = $stmtGetId->fetch(PDO::FETCH_ASSOC);

            if (!$idFruitResult) {
                $stmt->rollBack();
                return false;
            }

            $idFruit = $idFruitResult['idFruit'];

            // Update the price
            $stmtUpdatePrice = $stmt->prepare('
                UPDATE public."FruitPrices"
                SET "price" = :newPrice
                WHERE "idFruit" = :idFruit
            ');

            $stmtUpdatePrice->bindParam(':newPrice', $newPrice, PDO::PARAM_STR);
            $stmtUpdatePrice->bindParam(':idFruit', $idFruit, PDO::PARAM_INT);
            $stmtUpdatePrice->execute();

            $stmt->commit();

            return true; // Success
        } catch (PDOException $e) {
            $stmt = $this->database->connect();
            $stmt->rollBack();

            // Handle the error
            echo "Error: " . $e->getMessage();
            return false; // Error
        }
    }

}