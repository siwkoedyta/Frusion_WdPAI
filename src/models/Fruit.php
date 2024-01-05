<?php

class Fruit
{
    private $idFruit;
    private $typeFruit;
    private $priceId;
    private $priceFruit;

    public function __construct($idFruit, $typeFruit, $priceId, $priceFruit)
    {
        $this->idFruit = $idFruit;
        $this->typeFruit = $typeFruit;
        $this->priceId = $priceId;
        $this->priceFruit = $priceFruit;
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

}