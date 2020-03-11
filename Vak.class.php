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
        if(!$this->containsSteen()) {
            $this->steen = $steen;
            return true;
        }
        return false;
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
        if($this->containsSteen()) {
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
