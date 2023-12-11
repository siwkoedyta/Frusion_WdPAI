<?php

class Admin
{
    private $email;
    private $password;
    private $phone;
    private $frusionName;
    public function __construct($email, $password, $phone, $frusionName)
    {
        $this->email = $email;
        $this->password = $password;
        $this->phone = $phone;
        $this->frusionName = $frusionName;
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

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone): void
    {
        $this->phone = $phone;
    }

    public function getFrusionName()
    {
        return $this->frusionName;
    }

    public function setFrusionName($frusionName): void
    {
        $this->frusionName = $frusionName;
    }




}
