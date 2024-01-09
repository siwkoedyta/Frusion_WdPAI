<?php

class User {
    private $idUser;
    private $firstName;
    private $lastName;
    private $email;
    private $password;
    private $idAdmin;

    public function __construct($idUser, $firstName, $lastName, $email, $password,$idAdmin)
    {
        $this->idUser = $idUser;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->idAdmin = $idAdmin;
    }
    public function getIdUser()
    {
        return $this->idUser;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password): void
    {
        $this->password = $password;
    }

    public function getIdAdmin()
    {
        return $this->idAdmin;
    }

}