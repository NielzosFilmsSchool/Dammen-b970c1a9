<?php

class DamSpel
{
    private $bord;
    private $regelControleur;
    private $spelerAanDeBeurt;
    private $userInterface;

    public function __construct($bord, $regelControleur, $userInterface)
    {
        $this->bord = $bord;
        $this->regelControleur = $regelControleur;
        $this->userInterface = $userInterface;
        $this->spelerAanDeBeurt = "Blauw";
    }

    public function start()
    {
        $spelen = true;
        while($spelen){
            $this->bord->printStatus();
            $ask_again = true;
            while($ask_again){
                $zet = $this->userInterface->vraagSpelerOmZet($this->spelerAanDeBeurt);
                if(!$this->regelControleur->chekKanSlaan($zet, $this->bord, $this->spelerAanDeBeurt)) {
                    if($this->regelControleur->isGeldigeZet($zet, $this->bord, $this->spelerAanDeBeurt)) {
                        $ask_again = false;
                        $kanSlaan = $this->regelControleur->chekKanSlaanZonderZet($this->bord, $this->spelerAanDeBeurt);
                        echo "kanSlaan: $kanSlaan".PHP_EOL;
                        $this->bord->voerZetUit($zet, $this->spelerAanDeBeurt, $kanSlaan);

                        if($this->spelerAanDeBeurt == "Blauw") {
                            $this->spelerAanDeBeurt = "Zwart";
                        }else if($this->spelerAanDeBeurt == "Zwart") {
                            $this->spelerAanDeBeurt = "Blauw";
                        }
                    }else {
                        $this->bord->printStatus();
                        echo "Dat is geen geldige zet!".PHP_EOL;
                    }
                } else {
                    $this->bord->printStatus();
                    echo "Je bent verplicht te slaan!".PHP_EOL;
                }
            }

            $win = $this->regelControleur->chekWinConditie($this->bord);
            if($win == "black") {
                $this->bord->printStatus();
                echo "Zwart heeft het spel gewonnen!";
                $spelen = false;
            } else if($win == "blue") {
                $this->bord->printStatus();
                echo "Blauw heeft het spel gewonnen!";
                $spelen = false;
            }

        }
    }
}
