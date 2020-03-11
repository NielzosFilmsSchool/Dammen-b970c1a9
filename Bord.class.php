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
        for($y = 0;$y<count($this->colums);$y++){
            for($x = 0;$x<count($this->rows);$x++){
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
                        $vak->removeSteen(null);
                    }
                    $this->vakjes[] = $vak;
                }

                $switch_colors = !$switch_colors;
            }
            $switch_colors = !$switch_colors;
        }
    }

    public function voerZetUit($zet, $kanSlaan)
    {
        $r1 = $zet->getVanRij();
        $k1 = $zet->getVanKolom();
        $r2 = $zet->getNaarRij();
        $k2 = $zet->getNaarKolom();

        $steen = null;

        foreach($this->vakjes as $vakje) {
            if($vakje->containsSteen()) {
                $tmp_steen = $vakje->getSteen();
                $pos = $tmp_steen->getPositie();
                if($r1 == $pos->getY() && $k1 == $pos->getX()) {
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

                        if($k_i < 0 || $k_i > count($this->colums) || $r_i < 0 || $r_i > count($this->rows)) {
                            return false;
                        }

                        $new_pos->setPositie($this->colums[$k_i], $this->rows[$r_i]);
                    }
                    $tmp_steen->setPositie($new_pos);
                    $steen = $tmp_steen;
                    $vakje->removeSteen();
                }
            }
        }

        $index = (($this->toNumber($r2)-1) * 10)+$k2-1;
        if($kanSlaan) {
            $vak = $this->vakjes[$index];
            $vak->removeSteen(null);
            $index += $index - ((($this->toNumber($r1)-1) * 10)+$k1-1);
        }
        $vak = $this->vakjes[$index];
        $vak->setSteen($steen);
        return true;
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
            if($vak->containsSteen()) {
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
