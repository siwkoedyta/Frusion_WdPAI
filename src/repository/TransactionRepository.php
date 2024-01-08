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
            $transactionData['transactionDate'],
            $transactionData['weight'],
            $transactionData['amount']
        );
    }

    public function getTransactionsForAdmin($idAdmin): array
    {
        $transactions = [];
        $stmt = $this->database->connect()->prepare('SELECT * FROM public."Transaction" where "idAdmin" = :adminId');

        $stmt->bindParam(':adminId', $idAdmin, PDO::PARAM_INT);
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
                $transactionData['transactionDate'],
                $transactionData['weight'],
                $transactionData['amount']
            );
        }
        return $transactions;
    }

    public function addTransaction($idUser, $idAdmin, $weightWithBoxes, $idBox, $numberOfBoxes, $idPrice, $transactionDate, $weight, $amount): bool
    {
        $stmt = $this->database->connect();
        try {
            $stmt->beginTransaction();

            $stmtTransaction = $stmt->prepare('
            INSERT INTO public."Transaction" ("idUser", "idAdmin", "weight_with_boxes", "idBox", "numberOfBoxes", "idPrice", "transactionDate", "weight", "amount")
            VALUES (:idUser, :idAdmin, :weightWithBoxes, :idBox, :numberOfBoxes, :idPrice, :transactionDate, :weight, :amount)
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
}