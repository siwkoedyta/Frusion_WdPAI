<?php

class User {
    private $idUser;
    private $firstName;
    private $lastName;
    private $email;
    private $password;


    public function __construct($idUser, $firstName, $lastName, $email, $password)
    {
        $this->idUser = $idUser;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
    }
    public function getIdUser()
    {
        return $this->idUser;
    }

    public function setIdUser($idUser): void
    {
        $this->idUser = $idUser;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email): void
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password): void
    {
        $this->password = $password;
    }



}