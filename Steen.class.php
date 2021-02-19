<?php

class Steen
{
    private $color; //red or blue
    private $position;

    public function __construct($position, $color)
    {
        $this->position = $position;
        $this->color = $color;
    }

    public function getPositie()
    {
        return $this->position;
    }

    public function setPositie($pos)
    {
        $this->position = $pos;
    }

    public function getColor()
    {
        return $this->color;
    }
}