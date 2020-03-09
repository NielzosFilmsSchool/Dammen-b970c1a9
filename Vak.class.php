<?php

class Vak
{
    private $color;
    private $steen;

    public function __construct($color)
    {
        $this->color = $color;
        $this->steen = null;
    }

    public function setSteen($steen)
    {
        $this->steen = $steen;
    }

    public function removeSteen()
    {
        $this->steen = null;
    }

    public function getSteen()
    {
        return $this->steen;
    }

    public function containsSteen()
    {
        if($this->steen != null) {
            return true;
        }
        return false;
    }
    public function containsSteenKleur($steen_kleur)
    {
        if($this->steen != null) {
            if($this->steen->getColor() == $steen_kleur) {
                return true;
            }
        }
        return false;
    }

    public function getColor()
    {
        return $this->color;
    }

}
