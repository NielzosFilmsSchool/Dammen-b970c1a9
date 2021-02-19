<?php

spl_autoload_register(
    function ($class_name) {
        include $class_name . '.class.php';
    }
);

/*system("cls");
echo "\n";*/

$colors = new Colors();

$bord = new Bord();
$regelControleur = new RegelControleur();
$userInterface = new UserInterface();

$damSpel = new DamSpel($bord, $regelControleur, $userInterface);

$damSpel->start();