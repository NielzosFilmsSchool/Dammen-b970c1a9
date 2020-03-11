<?php

class RegelControleur
{

    private $playable_color = "light_gray";

    public function isGeldigeZet($zet, $bord, $spelerAanDeBeurt, $kanSlaan)
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
                $kleur = "blue";
                $r_i = array_search($r1, $row);
                $k_i = array_search($k1, $colums);

                if($r_i-1 > 0) {
                    $r = $row[$r_i-1];
                    if($r2 == $r) {
                        if($k_i-1 >= 0 && $k_i+1 < count($colums)) {
                            if($k2 == $colums[$k_i-1]) {
                                return $this->getVak($r_i, $k_i, -1, -1, $vakjes, $kanSlaan, $kleur);
                            }
                            if($k2 == $colums[$k_i+1]) {
                                return $this->getVak($r_i, $k_i, -1, 1, $vakjes, $kanSlaan, $kleur);
                            }
                        }else if($k_i+1 < count($colums)) {
                            if($k2 == $colums[$k_i+1]) {
                                return $this->getVak($r_i, $k_i, -1, 1, $vakjes, $kanSlaan, $kleur);
                            }
                        }else if($k_i-1 >= 0) {
                            if($k2 == $colums[$k_i-1]) {
                                return $this->getVak($i, $r_i, $k_i, -1, -1, $vakjes, $kanSlaan, $kleur);
                            }
                        }
                    }else {
                        return false;
                    }
                }else {
                    return false;
                }
            }else {
                $kleur = "black";
                $r_i = array_search($r1, $row);
                $k_i = array_search($k1, $colums);

                if($r_i+1 > 0) {
                    $r = $row[$r_i+1];
                    if($r2 == $r) {
                        if($k_i-1 >= 0 && $k_i+1 < count($colums)) {
                            if($k2 == $colums[$k_i+1]) {
                                return $this->getVak($r_i, $k_i, 1, 1, $vakjes, $kanSlaan, $kleur);
                            }
                            if($k2 == $colums[$k_i-1]) {
                                return $this->getVak($r_i, $k_i, 1, -1, $vakjes, $kanSlaan, $kleur);
                            }
                        }else if($k_i+1 < count($colums)) {
                            if($k2 == $colums[$k_i+1]) {
                                return $this->getVak($r_i, $k_i, 1, +1, $vakjes, $kanSlaan, $kleur);
                            }
                        }else if($k_i-1 >= 0) {
                            if($k2 == $colums[$k_i-1]) {
                                return $this->getVak($r_i, $k_i, 1, -1, $vakjes, $kanSlaan, $kleur);
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

    private function getVak($r_i, $k_i, $r_offset, $k_offset, $vakjes, $kanSlaan, $kleur)
    {
        $index = ($r_i+$r_offset)*10 + $k_i+$k_offset;
        $vak = $vakjes[$index];
        if($kanSlaan) {
            return !$vak->containsSteenKleur($kleur);
        }else {
            return !$vak->containsSteen();
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
                                $returnValue = $this->vakDiagonaalTest($vak_L, $zet_id, "black", $i, $bord, 22);
                                if ($returnValue) {
                                    return true;
                                }
                            }
                            if($vak_R->containsSteen()) {
                                $returnValue = $this->vakDiagonaalTest($vak_R, $zet_id, "black", $i, $bord, 18);
                                if ($returnValue) {
                                    return true;
                                }
                            }
                        } else if($i-11 >= 0) {
                            $vak_L = $bord->getVakjes()[$i-11];
                            if($vak_L->containsSteen()) {
                                $returnValue = $this->vakDiagonaalTest($vak_L, $zet_id, "black", $i, $bord, 22);
                                if ($returnValue) {
                                    return true;
                                }
                            }
                        } else if($i-9 >= 0) {
                            $vak_R = $bord->getVakjes()[$i-9];
                            if($vak_R->containsSteen()) {
                                $returnValue = $this->vakDiagonaalTest($vak_R, $zet_id, "black", $i, $bord, 18);
                                if ($returnValue) {
                                    return true;
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
                                $returnValue = $this->vakDiagonaalTest($vak_L, $zet_id, "blue", $i, $bord, 22);
                                if ($returnValue) {
                                    return true;
                                }
                            }
                            if($vak_R->containsSteen()) {
                                $returnValue = $this->vakDiagonaalTest($vak_R, $zet_id, "blue", $i, $bord, 18);
                                if ($returnValue) {
                                    return true;
                                }
                            }
                        } else if($i+11 < $vak_count) {
                            $vak_L = $bord->getVakjes()[$i+11];
                            if($vak_L->containsSteen()) {
                                $returnValue = $this->vakDiagonaalTest($vak_L, $zet_id, "blue", $i, $bord, 22);
                                if ($returnValue) {
                                    return true;
                                }
                            }
                        } else if($i+9 < $vak_count) {
                            $vak_R = $bord->getVakjes()[$i+9];
                            if($vak_R->containsSteen()) {
                                $returnValue = $this->vakDiagonaalTest($vak_R, $zet_id, "blue", $i, $bord, 18);
                                if ($returnValue) {
                                    return true;
                                }
                            }
                        }
                    }
                }
            }
        }
        return false;
    }

    private function vakDiagonaalTest($testVak, $zet_id, $kleur, $i, $bord, $offset)
    {
        $testSteen = $testVak->getSteen();
        $vak_L_id = (($this->toNumber($testSteen->getPositie()->getY())-1) * 10)+$testSteen->getPositie()->getX()-1;
        if($testSteen->getColor() == $kleur && $zet_id != $vak_L_id) {
            if($kleur == "blue") {
                return $this->getSteenDiagonaal(-$offset, $bord, $testSteen, $i, $testVak);
            }
            if($kleur == "black") {
                return $this->getSteenDiagonaal($offset, $bord, $testSteen, $i, $testVak);
            }
        }
        return false;
    }

    private function vakDiagonaalTestZonderZet($testVak, $kleur, $i, $bord, $offset)
    {
        $testSteen = $testVak->getSteen();
        if($testSteen->getColor() == $kleur) {
            if($kleur == "blue") {
                return $this->getSteenDiagonaal(-$offset, $bord, $testSteen, $i, $testVak);
            }
            if($kleur == "black") {
                return $this->getSteenDiagonaal($offset, $bord, $testSteen, $i, $testVak);
            }
        }
        return false;
    }

    private function getSteenDiagonaal($offset, $bord, $testSteen, $i, $testVak)
    {
        $count = count($bord->getVakjes());
        if($offset < 0) {
            if($i+$offset >= 0) {
                return $this->getSteenOffset($i, $offset, $bord, $testVak);
            }
        }else {
            if($i+$offset < $count) {
                return $this->getSteenOffset($i, $offset, $bord, $testVak);
            }   
        }
        return false;
    }

    private function getSteenOffset($i, $offset, $bord, $testVak)
    {
        $steen = $bord->getVakjes()[$i+$offset];
        if(!$steen->containsSteen() && $testVak->getColor() == $this->playable_color) {
            return true;
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
                                $returnValue = $this->vakDiagonaalTestZonderZet($vak_L, "black", $i, $bord, 22);
                                if ($returnValue) {
                                    return true;
                                }
                            }
                            if($vak_R->containsSteen()) {
                                $returnValue = $this->vakDiagonaalTestZonderZet($vak_R, "black", $i, $bord, 18);
                                if ($returnValue) {
                                    return true;
                                }
                            }
                        } else if($i-11 >= 0) {
                            $vak_L = $bord->getVakjes()[$i-11];
                            if($vak_L->containsSteen()) {
                                $returnValue = $this->vakDiagonaalTestZonderZet($vak_L, "black", $i, $bord, 22);
                                if ($returnValue) {
                                    return true;
                                }
                            }
                        } else if($i-9 >= 0) {
                            $vak_R = $bord->getVakjes()[$i-9];
                            if($vak_R->containsSteen()) {
                                $returnValue = $this->vakDiagonaalTestZonderZet($vak_R, "black", $i, $bord, 18);
                                if ($returnValue) {
                                    return true;
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
                                $returnValue = $this->vakDiagonaalTestZonderZet($vak_L, "blue", $i, $bord, 22);
                                if ($returnValue) {
                                    return true;
                                }
                            }
                            if($vak_R->containsSteen()) {
                                $returnValue = $this->vakDiagonaalTestZonderZet($vak_R, "blue", $i, $bord, 18);
                                if ($returnValue) {
                                    return true;
                                }
                            }
                        } else if($i+11 < $vak_count) {
                            $vak_L = $bord->getVakjes()[$i+11];
                            if($vak_L->containsSteen()) {
                                $returnValue = $this->vakDiagonaalTestZonderZet($vak_L, "blue", $i, $bord, 22);
                                if ($returnValue) {
                                    return true;
                                }
                            }
                        } else if($i+9 < $vak_count) {
                            $vak_R = $bord->getVakjes()[$i+9];
                            if($vak_R->containsSteen()) {
                                $returnValue = $this->vakDiagonaalTestZonderZet($vak_R, "blue", $i, $bord, 18);
                                if ($returnValue) {
                                    return true;
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
