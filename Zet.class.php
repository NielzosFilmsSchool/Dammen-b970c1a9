<?php

class Zet
{
    private $vanRij;
    private $vanKolom;
    private $naarRij;
    private $naarKolom;

    public function __construct($vanRij, $vanKolom, $naarRij, $naarKolom)
    {
        $this->vanRij = $vanRij;
        $this->vanKolom = $vanKolom;
        $this->naarRij = $naarRij;
        $this->naarKolom = $naarKolom;
    }

    public function getVanRij()
    {
        return $this->vanRij;
    }
    public function getVanKolom()
    {
        return $this->vanKolom;
    }

    public function getNaarRij()
    {
        return $this->naarRij;
    }
    public function getNaarKolom()
    {
        return $this->naarKolom;
    }
}
