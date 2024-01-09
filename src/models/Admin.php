<?php

class Admin
{
    private $idAdmin;
    private $email;
    private $password;
    private $phone;
    private $frusionName;
    public function __construct($idAdmin, $email, $password, $phone, $frusionName)
    {
        $this->idAdmin = $idAdmin;
        $this->email = $email;
        $this->password = $password;
        $this->phone = $phone;
        $this->frusionName = $frusionName;
    }
    public function getIdAdmin()
    {
        return $this->idAdmin;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function getFrusionName()
    {
        return $this->frusionName;
    }

}
