<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/User.php';

class UserRepository extends Repository
{
    private $authHelper;
    public function __construct()
    {
        parent::__construct();
        $this->authHelper = new AuthHelper();
    }
    public function getUser(string $email): ?User
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public."User" WHERE "email" = :email
        ');

        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user === false) {
            return null;
        }

        return new User(
            $user['idUser'],
            $user['firstName'],
            $user['lastName'],
            $user['email'],
            $user['password'],
            $user['idAdmin']
        );
    }
    public function getUserById(int $userId): ?User
    {
        $stmt = $this->database->connect()->prepare('
        SELECT * FROM public."User" WHERE "idUser" = :userId
    ');

        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user === false) {
            return null;
        }

        return new User(
            $user['idUser'],
            $user['firstName'],
            $user['lastName'],
            $user['email'],
            $user['password'],
            $user['idAdmin']
        );
    }
    public function getUserByFirstName($firstName, $lastName): ?User
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public."User" WHERE "firstName" = :firstName AND "lastName" = :lastName
        ');

        $stmt->bindParam(':firstName', $firstName, PDO::PARAM_STR);
        $stmt->bindParam(':lastName', $lastName, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user === false) {
            return null;
        }

        return new User(
            $user['idUser'],
            $user['firstName'],
            $user['lastName'],
            $user['email'],
            $user['password'],
            $user['idAdmin']
        );
    }
    public function addClient(string $firstName,string $lastName, string $email, string $password): bool
    {
        try {
            $loggedInAdminId = $this->authHelper->getLoggedInAdminId();
            $stmt = $this->database->connect();

            $stmt->beginTransaction();

            $stmtInsertUser = $this->database->connect()->prepare('
            INSERT INTO public."User" ("firstName", "lastName", "email", "password", "idAdmin") 
            VALUES (:firstName, :lastName, :email, :password, :idAdmin)
        ');

            $stmtInsertUser->bindValue(':firstName', $firstName, PDO::PARAM_STR);
            $stmtInsertUser->bindValue(':lastName', $lastName, PDO::PARAM_STR);
            $stmtInsertUser->bindValue(':email', $email, PDO::PARAM_STR);
            $stmtInsertUser->bindValue(':password', $password, PDO::PARAM_STR);
            $stmtInsertUser->bindParam(':idAdmin', $loggedInAdminId, PDO::PARAM_INT);

            $stmtInsertUser->execute();

            $stmt->commit();

            return true; // Sukces
        } catch (PDOException $e) {
            $stmt = $this->database->connect();
            $stmt->rollBack();

            echo "Error: " . $e->getMessage();
            return false; // Error
        }
    }

    public function userEmailExistsForAdmin(string $userEmail,$idAdmin): bool
    {
        $stmt = $this->database->connect()->prepare('
        SELECT *
        FROM public."User" u
        WHERE u."email" = :userEmail AND u."idAdmin" = :idAdmin
    ');

        $stmt->bindParam(':userEmail', $userEmail, PDO::PARAM_STR);
        $stmt->bindParam(':idAdmin', $idAdmin, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function setUserPassword(string $email, $password): bool
    {
        try {
            $stmt = $this->database->connect();

            $stmt->beginTransaction();

            $stmtSetUserPassword = $stmt->prepare('
                UPDATE public."User" 
                SET "password" = :newPassword
                WHERE "email" = :newEmail
            ');

            $stmtSetUserPassword->bindValue(':newPassword',$password, PDO::PARAM_STR);
            $stmtSetUserPassword->bindValue(':newEmail', $email, PDO::PARAM_STR);
            $stmtSetUserPassword->execute();

            $stmt->commit();

            return true; // Sukces
        } catch (PDOException $e) {
            $stmt = $this->database->connect();
            $stmt->rollBack();

            // Handle the error
            echo "Error: " . $e->getMessage();
            return false; // Error
        }
    }


}
