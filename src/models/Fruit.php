<?php

class Fruit
{
    private $idFruit;
    private $typeFruit;
    private $priceFruit;
    public function __construct($typeFruit, $priceFruit)
    {
        $this->typeFruit = $typeFruit;
        $this->priceFruit = $priceFruit;
    }

    public function getIdFruit()
    {
        return $this->idFruit;
    }

    public function setIdFruit($idFruit): void
    {
        $this->idFruit = $idFruit;
    }


    public function getTypeFruit()
    {
        return $this->typeFruit;
    }

    public function setTypeFruit($typeFruit): void
    {
        $this->typeFruit = $typeFruit;
    }

    public function getPriceFruit()
    {
        return $this->priceFruit;
    }

    public function setPriceFruit($priceFruit): void
    {
        $this->priceFruit = $priceFruit;
    }


}