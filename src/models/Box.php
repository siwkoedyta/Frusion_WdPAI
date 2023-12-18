<?php
class Box
{
    private $idBox;
    private $typeBox;
    private $weightBox;

    public function __construct($typeBox, $weightBox)
    {
        $this->typeBox = $typeBox;
        $this->weightBox = $weightBox;
    }

    public function getIdBox()
    {
        return $this->idBox;
    }

    public function getTypeBox()
    {
        return $this->typeBox;
    }

    public function setTypeBox($typeBox)
    {
        $this->typeBox = $typeBox;
    }

    public function getWeightBox()
    {
        return $this->weightBox;
    }

    public function setWeightBox($weightBox)
    {
        $this->weightBox = $weightBox;
    }


}