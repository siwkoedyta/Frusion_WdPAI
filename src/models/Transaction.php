<?php

class Transaction
{
    private $idTransaction;
    private $idUser;
    private $idAdmin;
    private $weightWithBoxes;
    private $idTypeBox;
    private $numberOfBoxes;
    private $idPriceFruit;
    private $transactionDate;
    private $weight;
    private $amount;

    public function __construct(
        $idUser,
        $idAdmin,
        $weightWithBoxes,
        $idTypeBox,
        $numberOfBoxes,
        $idPriceFruit,
        $transactionDate,
        $weight,
        $amount
    ) {
        $this->idUser = $idUser;
        $this->idAdmin = $idAdmin;
        $this->weightWithBoxes = $weightWithBoxes;
        $this->idTypeBox = $idTypeBox;
        $this->numberOfBoxes = $numberOfBoxes;
        $this->idPriceFruit = $idPriceFruit;
        $this->transactionDate = $transactionDate;
        $this->weight = $weight;
        $this->amount = $amount;
    }

    public function getIdTransaction()
    {
        return $this->idTransaction;
    }

    public function getIdUser()
    {
        return $this->idUser;
    }

    public function getIdAdmin()
    {
        return $this->idAdmin;
    }

    public function getWeightWithBoxes()
    {
        return $this->weightWithBoxes;
    }

    public function getIdTypeBox()
    {
        return $this->idTypeBox;
    }

    public function getNumberOfBoxes()
    {
        return $this->numberOfBoxes;
    }

    public function getIdPriceFruit()
    {
        return $this->idPriceFruit;
    }
    public function getTransactionDate()
    {
        return $this->transactionDate;
    }
    public function getWeight()
    {
        return $this->weight;
    }
    public function getAmount()
    {
        return $this->amount;
    }

}
