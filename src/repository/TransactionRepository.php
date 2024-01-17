<?php
require_once 'Repository.php';
require_once __DIR__ . '/../models/Transaction.php';

class TransactionRepository extends Repository
{
    public function getTransaction(int $transactionId): ?Transaction
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public."Transaction" WHERE "idTransaction" = :transactionId
        ');

        $stmt->bindParam(':transactionId', $transactionId, PDO::PARAM_INT);
        $stmt->execute();

        $transactionData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($transactionData === false) {
            return null;
        }

        return new Transaction(
            $transactionData['idUser'],
            $transactionData['idAdmin'],
            $transactionData['weight_with_boxes'],
            $transactionData['idBox'],
            $transactionData['numberOfBoxes'],
            $transactionData['idPrice'],
            $transactionData['priceFruit'],
            $transactionData['transactionDate'],
            $transactionData['weight'],
            $transactionData['amount']
        );
    }

    public function getTransactionsForAdminByDate($idAdmin, $selectedDate)
    {
        $transactions = [];
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public."vwtransactions"
            WHERE "idAdmin" = :idAdmin AND "transactionDate" = :selectedDate
        ');

        $stmt->bindParam(':idAdmin', $idAdmin, PDO::PARAM_INT);
        $stmt->bindParam(':selectedDate', $selectedDate, PDO::PARAM_STR);

        return $this->extracted($stmt, $transactions);
    }
    public function getTransactionsForAdmin($idAdmin, $selectedDateStarting = null, $selectedDateEnd = null)
    {
        $transactions = [];
        $query = 'SELECT * FROM public."vwtransactions" WHERE "idAdmin" = :idAdmin';

        // Add date range condition to the query if dates are provided
        if ($selectedDateStarting && $selectedDateEnd) {
            $query .= ' AND "transactionDate" BETWEEN :selectedDateStarting AND :selectedDateEnd';
        }
        $stmt = $this->database->connect()->prepare($query);

        $stmt->bindParam(':idAdmin', $idAdmin, PDO::PARAM_INT);

        if ($selectedDateStarting && $selectedDateEnd) {
            $stmt->bindParam(':selectedDateStarting', $selectedDateStarting, PDO::PARAM_STR);
            $stmt->bindParam(':selectedDateEnd', $selectedDateEnd, PDO::PARAM_STR);
        }

        return $this->extracted($stmt, $transactions);
    }


    public function getTransactionsForUser($idUser): array
    {
        $transactions = [];
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public."vwtransactions" WHERE "idUser" = :idUser
        ');

        $stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
        return $this->extracted($stmt, $transactions);
    }

    public function getTransactionsForUserByDate($idUser, $selectedDate): array
    {
        $transactions = [];
        $stmt = $this->database->connect()->prepare('
        SELECT * FROM public."vwtransactions" WHERE "idUser" = :idUser AND DATE("transactionDate") = :selectedDate
    ');

        $stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
        $stmt->bindParam(':selectedDate', $selectedDate, PDO::PARAM_STR);

        return $this->extracted($stmt, $transactions);
    }

    public function addTransaction($idUser, $idAdmin, $weightWithBoxes, $idBox, $numberOfBoxes, $idPrice, $priceFruit, $transactionDate, $weight, $amount): bool
    {
        $stmt = $this->database->connect();
        try {
            $stmt->beginTransaction();

            $stmtTransaction = $stmt->prepare('
            INSERT INTO public."Transaction" ("idUser", "idAdmin", "weight_with_boxes", "idBox", "numberOfBoxes", "idPrice", "transactionDate", "weight", "amount", "priceFruit")
            VALUES (:idUser, :idAdmin, :weightWithBoxes, :idBox, :numberOfBoxes, :idPrice, :transactionDate, :weight, :amount, :priceFruit)
        ');

            $stmtTransaction->bindParam(':idUser', $idUser, PDO::PARAM_INT);
            $stmtTransaction->bindParam(':idAdmin', $idAdmin, PDO::PARAM_INT);
            $stmtTransaction->bindParam(':weightWithBoxes', $weightWithBoxes);
            $stmtTransaction->bindParam(':idBox', $idBox, PDO::PARAM_INT);
            $stmtTransaction->bindParam(':numberOfBoxes', $numberOfBoxes, PDO::PARAM_INT);
            $stmtTransaction->bindParam(':idPrice', $idPrice, PDO::PARAM_INT);
            $stmtTransaction->bindParam(':transactionDate', $transactionDate);
            $stmtTransaction->bindParam(':amount', $amount);
            $stmtTransaction->bindParam(':weight', $weight);
            $stmtTransaction->bindParam(":priceFruit", $priceFruit, PDO::PARAM_STR);

            $stmtTransaction->execute();

            $errorInfo = $stmtTransaction->errorInfo();
            if ($errorInfo[0] !== '00000') {
                throw new PDOException("SQL Error: " . $errorInfo[2]);
            }

            $stmt->commit();

            return true; // Success
        } catch (PDOException $e) {
            if ($stmt->inTransaction()) {
                $stmt->rollBack();
            }

            // Log the error message
            error_log("Error adding transaction: " . $e->getMessage());

            return false; // Error
        }
    }

    public function extracted($stmt, array $transactions): array
    {
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $transactionData) {
            $transactions[] = new Transaction(
                $transactionData['idUser'],
                $transactionData['idAdmin'],
                $transactionData['weight_with_boxes'],
                $transactionData['idBox'],
                $transactionData['numberOfBoxes'],
                $transactionData['idPrice'],
                $transactionData['priceFruit'],
                $transactionData['transactionDate'],
                $transactionData['weight'],
                $transactionData['amount']
            );
        }
        return $transactions;
    }
}