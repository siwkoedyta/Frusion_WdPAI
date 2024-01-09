<?php
class Box
{
    private $idBox;
    private $typeBox;
    private $weightBox;
    private $idAdmin;

    public function __construct($idBox, $typeBox, $weightBox, $idAdmin)
    {
        $this->idBox = $idBox;
        $this->typeBox = $typeBox;
        $this->weightBox = $weightBox;
        $this->idAdmin = $idAdmin;
    }

    public function getIdBox()
    {
        return $this->idBox;
    }

    public function getTypeBox()
    {
        return $this->typeBox;
    }

    public function getWeightBox()
    {
        return $this->weightBox;
    }

    public function getIdAdmin()
    {
        return $this->idAdmin;
    }

}