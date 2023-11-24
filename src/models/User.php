<?php

class User {
    private $email;
    private $password;
    private $mobile;
    private $frusionName;

    public function __construct(string $email, string $password, string $mobile, string $frusionName) {
        $this->email = $email;
        $this->password = $password;
        $this->mobile = $mobile;
        $this->frusionName = $frusionName;
    }

    public function getEmail(): string{
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(){
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
    public function getMobile(): string
    {
        return $this->mobile;
    }

    public function setMobile(string $mobile): void
    {
        $this->mobile = $mobile;
    }

    public function getFrusionName(): string
    {
        return $this->frusionName;
    }

    public function setFrusionName(string $frusionName): void
    {
        $this->frusionName = $frusionName;
    }


}