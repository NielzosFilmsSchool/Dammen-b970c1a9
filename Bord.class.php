<?php

spl_autoload_register(
    function ($class_name) {
        include $class_name . '.class.php';
    }
);

class Bord
{
    private $rows = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
    private $colums = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

    private $vakjes = [];
    private $colors;

    public function __construct()
    {
        $this->colors = new Colors();
        $this->createBord();
    }

    private function createBord()
    {
        $bg_color = "light_gray";
        $fg_color = "black";
        $switch_colors = false;
        for($y = 0;$y<10;$y++){
            for($x = 0;$x<10;$x++){
                if($switch_colors) {
                    $this->vakjes[] = new Vak($fg_color); 
                }else {
                    $vak = new Vak($bg_color);
                    if($y < 4) {
                        $pos = new Positie($this->colums[$x], $this->rows[$y]);
                        $steen = new Steen($pos, "black");
                        $vak->setSteen($steen);
                    } else if($y > 5) {
                        $pos = new Positie($this->colums[$x], $this->rows[$y]);
                        $steen = new Steen($pos, "blue");
                        $vak->setSteen($steen);
                    }else {
                        $vak->setSteen(null);
                    }
                    $this->vakjes[] = $vak;
                }

                if($switch_colors) {
                    $switch_colors = false;
                } else if(!$switch_colors) {
                    $switch_colors = true;
                }
            }
            if($switch_colors) {
                $switch_colors = false;
            } else if(!$switch_colors) {
                $switch_colors = true;
            }
        }
    }

    public function voerZetUit($zet, $spelerAanDeBeurt, $kanSlaan)
    {
        //f 8 naar e 7 werkt niet
        $r1 = $zet->getVanRij();
        $k1 = $zet->getVanKolom();
        $r2 = $zet->getNaarRij();
        $k2 = $zet->getNaarKolom();

        $steen = null;

        foreach($this->vakjes as $vakje) {
            $tmp_steen = $vakje->getSteen();
            if($vakje->containsSteen()) {
                $pos = $tmp_steen->getPositie();
                if($r1 == $pos->getY() && $k1 == $pos->getX()) {
                    echo "test".PHP_EOL;
                    $steen = $vakje->getSteen();
                    $new_pos = new Positie($k2, $r2);
                    if($kanSlaan) {
                        $r2_i = array_search($r2, $this->rows);
                        $k2_i = array_search($k2, $this->colums);
                        $r1_i = array_search($r1, $this->rows);
                        $k1_i = array_search($k1, $this->colums);

                        $r_diff = $r2_i - $r1_i;
                        $k_diff = $k2_i - $k1_i;

                        $r_i = $r2_i + $r_diff;
                        $k_i = $k2_i + $k_diff;

                        echo $this->colums[$k_i];
                        echo $this->rows[$r_i].PHP_EOL;

                        $new_pos->setPositie($this->colums[$k_i], $this->rows[$r_i]);
                    }
                    $steen->setPositie($new_pos);
                    $vakje->setSteen(null);
                }
            }
        }

        $index = (($this->toNumber($r2)-1) * 10)+$k2-1;
        if($kanSlaan) {
            $vak = $this->vakjes[$index];
            $vak->setSteen(null);
            $index += $index - ((($this->toNumber($r1)-1) * 10)+$k1-1);
        }
        $vak = $this->vakjes[$index];
        $vak->setSteen($steen);
        echo $vak->getSteen()->getPositie()->getX().PHP_EOL;
        echo $vak->getSteen()->getPositie()->getY().PHP_EOL;
    }

    private function toNumber($dest)
    {
        if ($dest) {
            return ord(strtolower($dest)) - 96;
        } else {
            return 0;
        }
    }

    public function printStatus()
    {
        system('cls');
        echo PHP_EOL;
        $row_count = 0;
        echo  " ".$this->rows[0]." ";
        for($i = 0;$i<count($this->vakjes);$i++){
            $vak = $this->vakjes[$i];
            if($vak->getSteen() != null) {
                $steen = $vak->getSteen();
                echo $this->colors->getColoredString(" ○ ", $steen->getColor(), $vak->getColor());
            }else {
                echo $this->colors->getColoredString("   ", "black", $vak->getColor());
            }

            $row_count++;
            if($row_count >= 10) {
                echo PHP_EOL;
                if($i/10+1 < count($this->rows)) {
                    echo  " ".$this->rows[$i/10+1]." ";
                }else {
                    echo "    1  2  3  4  5  6  7  8  9  10";
                }
                $row_count = 0;
            }
        }
        echo PHP_EOL;
    }

    public function getRows()
    {
        return $this->rows;
    }
    public function getColums()
    {
        return $this->colums;
    }

    public function getVakjes()
    {
        return $this->vakjes;
    }
}
