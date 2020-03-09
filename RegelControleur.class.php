<?php

class RegelControleur
{
    public function isGeldigeZet($zet, $bord, $spelerAanDeBeurt)
    {
        if($zet == null) {
            return false;
        }

        $r1 = $zet->getVanRij();
        $k1 = $zet->getVanKolom();
        $r2 = $zet->getNaarRij();
        $k2 = $zet->getNaarKolom();

        $row = $bord->getRows();
        $colums = $bord->getColums();

        $vakjes = $bord->getVakjes();

        if(!in_array($r1, $row) || !in_array($r2, $row) || !in_array($k1, $colums) || !in_array($k2, $colums)) {
            return false;
        }else {
            if($spelerAanDeBeurt == "Blauw") {
                $r_i = array_search($r1, $row);
                $k_i = array_search($k1, $colums);

                if($r_i-1 > 0) {
                    $r = $row[$r_i-1];
                    if($r2 == $r) {
                        if($k_i-1 >= 0 && $k_i+1 < count($colums)) {
                            echo "meer dan en minder dan".PHP_EOL;
                            if($k2 == $colums[$k_i-1]) {
                                $index = ($r_i-1)*10 + $k_i-1;
                                echo $index.PHP_EOL;
                                $vak = $vakjes[$index];
                                return !$vak->containsSteenKleur("blue");
                            }
                            if($k2 == $colums[$k_i+1]) {
                                $index = ($r_i-1)*10 + $k_i+1;
                                echo $index.PHP_EOL;
                                $vak = $vakjes[$index];
                                return !$vak->containsSteenKleur("blue");
                            }
                        }else if($k_i+1 < count($colums)) {
                            echo "minder dan".PHP_EOL;
                            if($k2 == $colums[$k_i+1]) {
                                $index = ($r_i-1)*10 + $k_i+1;
                                $vak = $vakjes[$index];
                                return !$vak->containsSteenKleur("blue");
                            }
                        }else if($k_i-1 >= 0) {
                            echo "meer dan".PHP_EOL;
                            if($k2 == $colums[$k_i-1]) {
                                $index = ($r_i-1)*10 + $k_i-1;
                                $vak = $vakjes[$index];
                                return !$vak->containsSteenKleur("blue");
                            }
                        }
                    }else {
                        return false;
                    }
                }else {
                    return false;
                }
            }else {
                $r_i = array_search($r1, $row);
                $k_i = array_search($k1, $colums);

                if($r_i+1 > 0) {
                    $r = $row[$r_i+1];
                    if($r2 == $r) {
                        if($k_i-1 >= 0 && $k_i+1 < count($colums)) {
                            echo "meer dan en minder dan".PHP_EOL;
                            if($k2 == $colums[$k_i+1]) {
                                $index = ($r_i+1)*10 + $k_i+1;
                                echo $index.PHP_EOL;
                                $vak = $vakjes[$index];
                                return !$vak->containsSteenKleur("black");
                            }
                            if($k2 == $colums[$k_i-1]) {
                                $index = ($r_i+1)*10 + $k_i-1;
                                echo $index.PHP_EOL;
                                $vak = $vakjes[$index];
                                return !$vak->containsSteenKleur("black");
                            }
                        }else if($k_i+1 < count($colums)) {
                            echo "minder dan".PHP_EOL;
                            if($k2 == $colums[$k_i+1]) {
                                $index = ($r_i+1)*10 + $k_i+1;
                                $vak = $vakjes[$index];
                                return !$vak->containsSteenKleur("black");
                            }
                        }else if($k_i-1 >= 0) {
                            echo "meer dan".PHP_EOL;
                            if($k2 == $colums[$k_i-1]) {
                                $index = ($r_i+1)*10 + $k_i-1;
                                $vak = $vakjes[$index];
                                return !$vak->containsSteenKleur("black");
                            }
                        }
                    }else {
                        return false;
                    }
                }else {
                    return false;
                }
            }
        }
    }

    public function chekKanSlaan($zet, $bord, $spelerAanDeBeurt)
    {
        if($zet == null) {
            return false;
        }
        $r2 = $zet->getNaarRij();
        $k2 = $zet->getNaarKolom();
        $zet_id = (($this->toNumber($r2)-1) * 10)+$k2-1;
        $vak_count = count($bord->getVakjes());
        for($i = 0;$i<$vak_count;$i++) {
            $vak = $bord->getVakjes()[$i];
            if($vak->containsSteen()) {
                $steen = $vak->getSteen();
                if($spelerAanDeBeurt == "Blauw") {
                    if($steen->getColor() == "blue") {
                        if($i-11 >= 0 && $i-9 >= 0) {
                            $vak_L = $bord->getVakjes()[$i-11];
                            $vak_R = $bord->getVakjes()[$i-9];

                            if($vak_L->containsSteen()) {
                                $steen_L = $vak_L->getSteen();
                                $vak_L_id = (($this->toNumber($steen_L->getPositie()->getY())-1) * 10)+$steen_L->getPositie()->getX()-1;
                                if($steen_L->getColor() == "black" && $zet_id != $vak_L_id) {
                                    if($i-22 < $vak_count) {
                                        $vak_L2 = $bord->getVakjes()[$i-22];
                                        if(!$vak_L2->containsSteen()) {
                                            return true;
                                        }
                                    }
                                }
                            }
                            if($vak_R->containsSteen()) {
                                $steen_R = $vak_R->getSteen();
                                $vak_R_id = (($this->toNumber($steen_R->getPositie()->getY())-1) * 10)+$steen_R->getPositie()->getX()-1;
                                if($steen_R->getColor() == "black" && $zet_id != $vak_R_id) {
                                    if($i-18 < $vak_count) {
                                        $vak_R2 = $bord->getVakjes()[$i-18];
                                        if(!$vak_R2->containsSteen()) {
                                            return true;
                                        }
                                    }
                                }
                            }
                        } else if($i-11 >= 0) {
                            $vak_L = $bord->getVakjes()[$i-11];
                            if($vak_L->containsSteen()) {
                                $steen_L = $vak_L->getSteen();
                                $vak_L_id = (($this->toNumber($steen_L->getPositie()->getY())-1) * 10)+$steen_L->getPositie()->getX()-1;
                                if($steen_L->getColor() == "black" && $zet_id != $vak_L_id) {
                                    if($i-22 < $vak_count) {
                                        $vak_L2 = $bord->getVakjes()[$i-22];
                                        if(!$vak_L2->containsSteen()) {
                                            return true;
                                        }
                                    }
                                }
                            }
                        } else if($i-9 >= 0) {
                            $vak_R = $bord->getVakjes()[$i-9];
                            if($vak_R->containsSteen()) {
                                $steen_R = $vak_R->getSteen();
                                $vak_R_id = (($this->toNumber($steen_R->getPositie()->getY())-1) * 10)+$steen_R->getPositie()->getX()-1;
                                if($steen_R->getColor() == "black" && $zet_id != $vak_R_id) {
                                    if($i-18 < $vak_count) {
                                        $vak_R2 = $bord->getVakjes()[$i-18];
                                        if(!$vak_R2->containsSteen()) {
                                            return true;
                                        }
                                    }
                                }
                            }
                        }
                    }
                } else {
                    if($steen->getColor() == "black") {
                        if($i+11 < $vak_count && $i+9 < $vak_count) {
                            $vak_L = $bord->getVakjes()[$i+11];
                            $vak_R = $bord->getVakjes()[$i+9];

                            if($vak_L->containsSteen()) {
                                $steen_L = $vak_L->getSteen();
                                $vak_L_id = (($this->toNumber($steen_L->getPositie()->getY())-1) * 10)+$steen_L->getPositie()->getX()-1;
                                if($steen_L->getColor() == "blue" && $zet_id != $vak_L_id) {
                                    if($i+22 < $vak_count) {
                                        $vak_L2 = $bord->getVakjes()[$i+22];
                                        if(!$vak_L2->containsSteen()) {
                                            return true;
                                        }
                                    }
                                }
                            }
                            if($vak_R->containsSteen()) {
                                $steen_R = $vak_R->getSteen();
                                $vak_R_id = (($this->toNumber($steen_R->getPositie()->getY())-1) * 10)+$steen_R->getPositie()->getX()-1;
                                if($steen_R->getColor() == "blue" && $zet_id != $vak_R_id) {
                                    if($i+18 < $vak_count) {
                                        $vak_R2 = $bord->getVakjes()[$i+18];
                                        if(!$vak_R2->containsSteen()) {
                                            return true;
                                        }
                                    }
                                }
                            }
                        } else if($i+11 < $vak_count) {
                            $vak_L = $bord->getVakjes()[$i+11];
                            if($vak_L->containsSteen()) {
                                $steen_L = $vak_L->getSteen();
                                $vak_L_id = (($this->toNumber($steen_L->getPositie()->getY())-1) * 10)+$steen_L->getPositie()->getX()-1;
                                if($steen_L->getColor() == "blue" && $zet_id != $vak_L_id) {
                                    if($i+22 < $vak_count) {
                                        $vak_L2 = $bord->getVakjes()[$i+22];
                                        if(!$vak_L2->containsSteen()) {
                                            return true;
                                        }
                                    }
                                }
                            }
                        } else if($i+9 < $vak_count) {
                            $vak_R = $bord->getVakjes()[$i+9];
                            if($vak_R->containsSteen()) {
                                $steen_R = $vak_R->getSteen();
                                $vak_R_id = (($this->toNumber($steen_R->getPositie()->getY())-1) * 10)+$steen_R->getPositie()->getX()-1;
                                if($steen_R->getColor() == "blue" && $zet_id != $vak_R_id) {
                                    if($i+18 < $vak_count) {
                                        $vak_R2 = $bord->getVakjes()[$i+18];
                                        if(!$vak_R2->containsSteen()) {
                                            return true;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return false;
    }

    public function chekKanSlaanZonderZet($bord, $spelerAanDeBeurt)
    {
        $vak_count = count($bord->getVakjes());
        for($i = 0;$i<$vak_count;$i++) {
            $vak = $bord->getVakjes()[$i];
            if($vak->containsSteen()) {
                $steen = $vak->getSteen();
                if($spelerAanDeBeurt == "Blauw") {
                    if($steen->getColor() == "blue") {
                        if($i-11 >= 0 && $i-9 >= 0) {
                            $vak_L = $bord->getVakjes()[$i-11];
                            $vak_R = $bord->getVakjes()[$i-9];

                            if($vak_L->containsSteen()) {
                                $steen_L = $vak_L->getSteen();
                                $vak_L_id = (($this->toNumber($steen_L->getPositie()->getY())-1) * 10)+$steen_L->getPositie()->getX()-1;
                                if($steen_L->getColor() == "black") {
                                    if($i-22 < $vak_count) {
                                        $vak_L2 = $bord->getVakjes()[$i-22];
                                        if(!$vak_L2->containsSteen()) {
                                            return true;
                                        }
                                    }
                                }
                            }
                            if($vak_R->containsSteen()) {
                                $steen_R = $vak_R->getSteen();
                                $vak_R_id = (($this->toNumber($steen_R->getPositie()->getY())-1) * 10)+$steen_R->getPositie()->getX()-1;
                                if($steen_R->getColor() == "black") {
                                    if($i-18 < $vak_count) {
                                        $vak_R2 = $bord->getVakjes()[$i-18];
                                        if(!$vak_R2->containsSteen()) {
                                            return true;
                                        }
                                    }
                                }
                            }
                        } else if($i-11 >= 0) {
                            $vak_L = $bord->getVakjes()[$i-11];
                            if($vak_L->containsSteen()) {
                                $steen_L = $vak_L->getSteen();
                                $vak_L_id = (($this->toNumber($steen_L->getPositie()->getY())-1) * 10)+$steen_L->getPositie()->getX()-1;
                                if($steen_L->getColor() == "black") {
                                    if($i-22 < $vak_count) {
                                        $vak_L2 = $bord->getVakjes()[$i-22];
                                        if(!$vak_L2->containsSteen()) {
                                            return true;
                                        }
                                    }
                                }
                            }
                        } else if($i-9 >= 0) {
                            $vak_R = $bord->getVakjes()[$i-9];
                            if($vak_R->containsSteen()) {
                                $steen_R = $vak_R->getSteen();
                                $vak_R_id = (($this->toNumber($steen_R->getPositie()->getY())-1) * 10)+$steen_R->getPositie()->getX()-1;
                                if($steen_R->getColor() == "black") {
                                    if($i-18 < $vak_count) {
                                        $vak_R2 = $bord->getVakjes()[$i-18];
                                        if(!$vak_R2->containsSteen()) {
                                            return true;
                                        }
                                    }
                                }
                            }
                        }
                    }
                } else {
                    if($steen->getColor() == "black") {
                        if($i+11 < $vak_count && $i+9 < $vak_count) {
                            $vak_L = $bord->getVakjes()[$i+11];
                            $vak_R = $bord->getVakjes()[$i+9];

                            if($vak_L->containsSteen()) {
                                $steen_L = $vak_L->getSteen();
                                $vak_L_id = (($this->toNumber($steen_L->getPositie()->getY())-1) * 10)+$steen_L->getPositie()->getX()-1;
                                if($steen_L->getColor() == "blue") {
                                    if($i+22 < $vak_count) {
                                        $vak_L2 = $bord->getVakjes()[$i+22];
                                        if(!$vak_L2->containsSteen()) {
                                            return true;
                                        }
                                    }
                                }
                            }
                            if($vak_R->containsSteen()) {
                                $steen_R = $vak_R->getSteen();
                                $vak_R_id = (($this->toNumber($steen_R->getPositie()->getY())-1) * 10)+$steen_R->getPositie()->getX()-1;
                                if($steen_R->getColor() == "blue") {
                                    if($i+18 < $vak_count) {
                                        $vak_R2 = $bord->getVakjes()[$i+18];
                                        if(!$vak_R2->containsSteen()) {
                                            return true;
                                        }
                                    }
                                }
                            }
                        } else if($i+11 < $vak_count) {
                            $vak_L = $bord->getVakjes()[$i+11];
                            if($vak_L->containsSteen()) {
                                $steen_L = $vak_L->getSteen();
                                $vak_L_id = (($this->toNumber($steen_L->getPositie()->getY())-1) * 10)+$steen_L->getPositie()->getX()-1;
                                if($steen_L->getColor() == "blue") {
                                    if($i+22 < $vak_count) {
                                        $vak_L2 = $bord->getVakjes()[$i+22];
                                        if(!$vak_L2->containsSteen()) {
                                            return true;
                                        }
                                    }
                                }
                            }
                        } else if($i+9 < $vak_count) {
                            $vak_R = $bord->getVakjes()[$i+9];
                            if($vak_R->containsSteen()) {
                                $steen_R = $vak_R->getSteen();
                                $vak_R_id = (($this->toNumber($steen_R->getPositie()->getY())-1) * 10)+$steen_R->getPositie()->getX()-1;
                                if($steen_R->getColor() == "blue") {
                                    if($i+18 < $vak_count) {
                                        $vak_R2 = $bord->getVakjes()[$i+18];
                                        if(!$vak_R2->containsSteen()) {
                                            return true;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return false;
    }

    public function chekWinConditie($bord)
    {
        $zwart_count = 0;
        $blauw_count = 0;

        foreach($bord->getVakjes() as $vak) {
            if($vak->containsSteen()) {
                $steen = $vak->getSteen();
                if($steen->getColor() == "blue") {
                    $blauw_count++;
                } else if($steen->getColor() == "black") {
                    $zwart_count++;
                }
            }
        }

        if($zwart_count == 0) {
            return "blue";
        } else if($blauw_count == 0) {
            return "black";
        }
        return null;
    }

    private function toNumber($dest)
    {
        if ($dest) {
            return ord(strtolower($dest)) - 96;
        } else {
            return 0;
        }
    }
}
