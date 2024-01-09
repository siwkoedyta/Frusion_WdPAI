<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Fruit.php';
require_once __DIR__ . '/../controllers/AuthHelper.php';

class FruitRepository extends Repository
{
    private $authHelper;

    public function __construct()
    {
        parent::__construct();
        $this->authHelper = new AuthHelper();
    }
    public function getFruit(int $fruitId): ?Fruit
    {
        $loggedInAdminId = $this->authHelper->getLoggedInAdminId();

        $stmt = $this->database->connect()->prepare('
        SELECT f."idFruit", f."typeFruit", f."idAdmin", p."idPrice", p."price"
        FROM public."Fruit" f
        LEFT JOIN public."FruitPrices" p ON f."idFruit" = p."idFruit"
        WHERE f."idFruit" = :fruitId AND f."idAdmin" = :loggedInAdminId
    ');

        $stmt->bindParam(':fruitId', $fruitId, PDO::PARAM_INT);
        $stmt->bindParam(':loggedInAdminId', $loggedInAdminId, PDO::PARAM_INT);
        $stmt->execute();

        $fruit = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($fruit === false) {
            return null;
        }

        return new Fruit(
            $fruit['idFruit'],
            $fruit['typeFruit'],
            $fruit['idPrice'],
            $fruit['price'],
            $fruit['idAdmin']
        );
    }
    public function getFruitByPriceId(int $priceId): ?Fruit
    {
        $loggedInAdminId = $this->authHelper->getLoggedInAdminId();

        $stmt = $this->database->connect()->prepare('
        SELECT f."idFruit", f."typeFruit", f."idAdmin", p."idPrice", p."price"
        FROM public."Fruit" f
        LEFT JOIN public."FruitPrices" p ON f."idFruit" = p."idFruit"
        WHERE p."idPrice" = :priceId AND f."idAdmin" = :loggedInAdminId
    ');

        $stmt->bindParam(':priceId', $priceId, PDO::PARAM_INT);
        $stmt->bindParam(':loggedInAdminId', $loggedInAdminId, PDO::PARAM_INT);
        $stmt->execute();

        $fruit = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($fruit === false) {
            return null;
        }

        return new Fruit(
            $fruit['idFruit'],
            $fruit['typeFruit'],
            $fruit['idPrice'],
            $fruit['price'],
            $fruit['idAdmin']
        );
    }

    public function getFruitByPriceIdForUser(int $priceId): ?Fruit
    {

        $stmt = $this->database->connect()->prepare('
        SELECT f."idFruit", f."typeFruit", f."idAdmin", p."idPrice", p."price"
        FROM public."Fruit" f
        LEFT JOIN public."FruitPrices" p ON f."idFruit" = p."idFruit"
        WHERE p."idPrice" = :priceId
    ');

        $stmt->bindParam(':priceId', $priceId, PDO::PARAM_INT);
        $stmt->execute();

        $fruit = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($fruit === false) {
            return null;
        }

        return new Fruit(
            $fruit['idFruit'],
            $fruit['typeFruit'],
            $fruit['idPrice'],
            $fruit['price'],
            $fruit['idAdmin']
        );
    }
    public function getFruitByName(string $fruitName): ?Fruit
    {
        $loggedInAdminId = $this->authHelper->getLoggedInAdminId();

        $stmt = $this->database->connect()->prepare('
        SELECT f."idFruit", f."typeFruit", f."idAdmin", p."idPrice", p."price"
        FROM public."Fruit" f
        LEFT JOIN public."FruitPrices" p ON f."idFruit" = p."idFruit"
        WHERE f."typeFruit" = :fruitName AND f."idAdmin" = :loggedInAdminId
    ');

        $stmt->bindParam(':fruitName', $fruitName, PDO::PARAM_STR);
        $stmt->bindParam(':loggedInAdminId', $loggedInAdminId, PDO::PARAM_INT);
        $stmt->execute();

        $fruit = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($fruit === false) {
            return null;
        }

        return new Fruit(
            $fruit['idFruit'],
            $fruit['typeFruit'],
            $fruit['idPrice'],
            $fruit['price'],
            $fruit['idAdmin']
        );
    }

    public function getFruitByNameForUser(string $fruitName): ?Fruit
    {
        $stmt = $this->database->connect()->prepare('
        SELECT f."idFruit", f."typeFruit", f."idAdmin", p."idPrice", p."price"
        FROM public."Fruit" f
        LEFT JOIN public."FruitPrices" p ON f."idFruit" = p."idFruit"
        WHERE f."typeFruit" = :fruitName
    ');

        $stmt->bindParam(':fruitName', $fruitName, PDO::PARAM_STR);
        $stmt->execute();

        $fruit = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($fruit === false) {
            return null;
        }

        return new Fruit(
            $fruit['idFruit'],
            $fruit['typeFruit'],
            $fruit['idPrice'],
            $fruit['price'],
            $fruit['idAdmin']
        );
    }

    public function getAllFruitForAdmin(): array
    {
        $loggedInAdminId = $this->authHelper->getLoggedInAdminId();

        $fruits = [];
        $stmt = $this->database->connect()->prepare('
        SELECT f."idFruit", f."typeFruit", p."idPrice", p."price", f."idAdmin"
        FROM public."Fruit" f
        LEFT JOIN public."FruitPrices" p ON f."idFruit" = p."idFruit"
        WHERE f."idAdmin" = :loggedInAdminId
    ');

        $stmt->bindParam(':loggedInAdminId', $loggedInAdminId, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $fruit) {
            $fruits[] = new Fruit(
                $fruit['idFruit'],
                $fruit['typeFruit'],
                $fruit['idPrice'],
                $fruit['price'],
                $fruit['idAdmin']
            );
        }

        return $fruits;
    }

    public function getAllFruit(): array
    {
        $fruits = [];
        $stmt = $this->database->connect()->prepare('
        SELECT f."idFruit", f."typeFruit", f."idAdmin", p."idPrice", p."price"
        FROM public."Fruit" f
        LEFT JOIN public."FruitPrices" p ON f."idFruit" = p."idFruit"
    ');

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $fruit) {
            $fruits[] = new Fruit(
                $fruit['idFruit'],
                $fruit['typeFruit'],
                $fruit['idPrice'],
                $fruit['price'],
                $fruit['idAdmin']
            );
        }

        return $fruits;
    }

    public function fruitTypeExistsForAdmin($typeFruit, $idAdmin): bool
    {
        $stmt = $this->database->connect()->prepare('
        SELECT *
        FROM public."Fruit" f
        WHERE f."typeFruit" = :fruitType AND f."idAdmin" = :idAdmin
    ');

        $stmt->bindParam(':fruitType', $typeFruit, PDO::PARAM_STR);
        $stmt->bindParam(':idAdmin', $idAdmin, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function addFruit($typeFruit): bool
    {
        try {
            $loggedInAdminId = $this->authHelper->getLoggedInAdminId();
            $stmt = $this->database->connect();

            $stmt->beginTransaction();

            $stmtFruit = $stmt->prepare('
            INSERT INTO public."Fruit" ("typeFruit", "idAdmin") 
            VALUES (:typeFruit, :idAdmin)
        ');

            $stmtFruit->bindParam(':typeFruit', $typeFruit, PDO::PARAM_STR);
            $stmtFruit->bindParam(':idAdmin', $loggedInAdminId, PDO::PARAM_INT);

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

    public function removeFruit(string $idFruit): bool
    {
        try {
            $stmt = $this->database->connect();

            $stmt->beginTransaction();

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

    public function setFruitPrice(string $idFruit, float $newPrice): bool
    {
        try {
            $stmt = $this->database->connect();

            $stmt->beginTransaction();

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