<?php


require_once 'Repository.php';
require_once __DIR__ . '/../models/Admin.php';

class AdminRepository extends Repository
{

    public function getAdmin(string $email): ?Admin
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public."Admin" WHERE "email" = :email
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin === false) {
            return null;
        }

        return new Admin(
            $admin['idAdmin'],
            $admin['email'],
            $admin['password'],
            $admin['phone'],
            $admin['frusionName']
        );
    }
    public function adminExists($email): bool
    {
        $stmt = $this->database->connect()->prepare('
            SELECT COUNT(*) FROM public."Admin" WHERE "email" = :email
        ');

        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchColumn() > 0;
    }
    public function addAdmin(Admin $admin): void
    {
        $stmt = $this->database->connect()->prepare('
        INSERT INTO public."Admin" ("email", "password", "phone", "frusionName")
        VALUES (:email, :password, :phone, :frusionName)
    ');

        $email = $admin->getEmail();
        $password = $admin->getPassword();
        $phone = $admin->getPhone();
        $frusionName = $admin->getFrusionName();

        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':frusionName', $frusionName, PDO::PARAM_STR);

        $stmt->execute();
    }
}