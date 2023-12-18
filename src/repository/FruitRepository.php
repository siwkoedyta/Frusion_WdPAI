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


}