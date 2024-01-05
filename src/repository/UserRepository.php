<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/User.php';

class UserRepository extends Repository
{
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
            $user['password']
        );
    }
    public function getUserById(int $userId): ?User
    {
        $stmt = $this->database->connect()->prepare('
        SELECT * FROM public."User" WHERE "idUser" = :userId
    ');

        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();

        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userData === false) {
            return null;
        }

        return new User(
            $userData['idUser'],
            $userData['firstName'],
            $userData['lastName'],
            $userData['email'],
            $userData['password']
        );
    }
    public function getUserByFirstLastName($firstName, $lastName): ?User
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public."User" WHERE "firstName" = :firstName AND "lastName" = :lastName
        ');

        $stmt->bindParam(':firstName', $firstName, PDO::PARAM_STR);
        $stmt->bindParam(':lastName', $lastName, PDO::PARAM_STR);
        $stmt->execute();

        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userData === false) {
            return null;
        }

        return new User(
            $userData['idUser'],
            $userData['firstName'],
            $userData['lastName'],
            $userData['email'],
            $userData['password']
        );
    }
    public function addClient(User $user): bool
    {
        try {
            $stmt = $this->database->connect()->prepare('
            INSERT INTO public."User" ("firstName", "lastName", "email", "password") 
            VALUES (:firstName, :lastName, :email, :password)
        ');

            $stmt->bindValue(':firstName', $user->getFirstName(), PDO::PARAM_STR);
            $stmt->bindValue(':lastName', $user->getLastName(), PDO::PARAM_STR);
            $stmt->bindValue(':email', $user->getEmail(), PDO::PARAM_STR);
            $stmt->bindValue(':password', $user->getPassword(), PDO::PARAM_STR);

            $stmt->execute();

            return true; // Sukces
        } catch (PDOException $e) {
            // Obsługa błędów
            echo "Error: " . $e->getMessage();
            return false; // Błąd
        }
    }

    public function updateUser(User $user): bool
    {
        try {
            $stmt = $this->database->connect()->prepare('
            UPDATE public."User" 
            SET "password" = :password
            WHERE "email" = :email
        ');

            $stmt->bindValue(':password', $user->getPassword(), PDO::PARAM_STR);
            $stmt->bindValue(':email', $user->getEmail(), PDO::PARAM_STR);

            $stmt->execute();

            return true; // Sukces
        } catch (PDOException $e) {
            // Obsługa błędów
            echo "Error: " . $e->getMessage();
            return false; // Błąd
        }
    }

}
