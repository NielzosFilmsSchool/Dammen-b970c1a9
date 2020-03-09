<?php

spl_autoload_register(
    function ($class_name) {
        include $class_name . '.class.php';
    }
);

class UserInterface
{
    public function vraagSpelerOmZet($spelerAanDeBeurt)
    {
        echo "$spelerAanDeBeurt is aan de beurt!\nTyp 'a 1 naar b 2' om een zet te doen".PHP_EOL;
        $move_str = strtoupper(readline());
        $move = explode(" ", $move_str);
        if(count($move) == 5) {
            $zet = new Zet($move[0], $move[1], $move[3], $move[4]);
            return $zet;
        }
        return null;
    }
}
