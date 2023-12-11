<?php

class Transaction {
    private $transactionID;
    private $userID;
    private $weight_with_boxes;
    private $weight;
    private $idBox;
    private $number_of_boxes;
    private $transactionDate;
    private $priceID;

    public function __construct($transactionID, $userID, $weight_with_boxes, $weight, $idBox, $number_of_boxes, $transactionDate, $priceID)
    {
        $this->transactionID = $transactionID;
        $this->userID = $userID;
        $this->weight_with_boxes = $weight_with_boxes;
        $this->weight = $weight;
        $this->idBox = $idBox;
        $this->number_of_boxes = $number_of_boxes;
        $this->transactionDate = $transactionDate;
        $this->priceID = $priceID;
    }


    public function getPriceID()
    {
        return $this->priceID;
    }

    public function setPriceID($priceID): void
    {
        $this->priceID = $priceID;
    }

    public function getTransactionDate()
    {
        return $this->transactionDate;
    }

    public function setTransactionDate($transactionDate): void
    {
        $this->transactionDate = $transactionDate;
    }

    public function getNumberOfBoxes()
    {
        return $this->number_of_boxes;
    }

    public function setNumberOfBoxes($number_of_boxes): void
    {
        $this->number_of_boxes = $number_of_boxes;
    }

    public function getIdBox()
    {
        return $this->idBox;
    }

    public function setIdBox($idBox): void
    {
        $this->idBox = $idBox;
    }

    public function getWeightWithBoxes()
    {
        return $this->weight_with_boxes;
    }

    public function setWeightWithBoxes($weight_with_boxes): void
    {
        $this->weight_with_boxes = $weight_with_boxes;
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function setWeight($weight): void
    {
        $this->weight = $weight;
    }

    public function getUserID()
    {
        return $this->userID;
    }

    public function setUserID($userID): void
    {
        $this->userID = $userID;
    }

    public function getTransactionID()
    {
        return $this->transactionID;
    }

    public function setTransactionID($transactionID): void
    {
        $this->transactionID = $transactionID;
    }


}
