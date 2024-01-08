<?php

class Fruit
{
    private $idFruit;
    private $typeFruit;
    private $priceId;
    private $priceFruit;
    private $idAdmin;


    public function __construct($idFruit, $typeFruit, $priceId, $priceFruit, $idAdmin)
    {
        $this->idFruit = $idFruit;
        $this->typeFruit = $typeFruit;
        $this->priceId = $priceId;
        $this->priceFruit = $priceFruit;
        $this->idAdmin = $idAdmin;
    }

    public function getIdFruit()
    {
        return $this->idFruit;
    }

    public function getTypeFruit()
    {
        return $this->typeFruit;
    }

    public function getPriceId()
    {
        return $this->priceId;
    }

    public function getPriceFruit()
    {
        return $this->priceFruit;
    }

    public function setPriceFruit($priceFruit): void
    {
        $this->priceFruit = $priceFruit;
    }

    public function getIdAdmin()
    {
        return $this->idAdmin;
    }

}