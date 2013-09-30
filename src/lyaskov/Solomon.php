<?php

namespace lyaskov;

class Solomon
{
    public function fight($demons)
    {
        $p = $demons;

        //$this->setDemons($demons);
        $this->setDemons($p);
        $count = $this->getCountDemons();
        for ($i = 0; $i <= $count; $i++) {
            $this->mas_ice[] = 0;
        }

        while ($this->isDemons()) {
            $posLeft = $this->getMaxLeft() + 1;
            $posRight = $this->getMaxRight() + 1;
//            if (($posRight - $posLeft) >= 3){
//                $posRight = $posLeft;
//            }
            $this->magGoTo($posRight - 1);
            $this->stickIce();
            $this->magGoTo($posLeft - 2);
            $this->stickIce();
        }
$v1 = $this->getAction();

$this->setAction("");
$this->setPositionMag(-1);
$this->mas_ice = array();
        $this->setDemons($p);
        $count = $this->getCountDemons();
        for ($i = 0; $i <= $count; $i++) {
            $this->mas_ice[] = 0;
        }

        while ($this->isDemons()) {
            $posLeft = $this->getMaxLeft() + 1;
            //$posRight = $this->getMaxRight() + 1;
            $posRight = $this->getMaxMaxLeft($posLeft-1) + 1;
            //if (($posRight - $posLeft) >= 3){
              //  $posRight = $posLeft;
            //}
            $this->magGoTo($posRight - 1);
            $this->stickIce();
            $this->magGoTo($posLeft - 2);
            $this->stickIce();
        }
$v2 = $this->getAction();

        if (mb_strlen($v2)<mb_strlen($v1))
            return $v2;
        else
            return $v1;
        //return $this->getAction();
    }

    public  $mas_ice = array();
    private $mas_demons;
    private $action = "";

    /**
     * @param string $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }
    private $indexMaxLeft;
    private $indexMaxRight;
    private $positionMag = -1;

//
//    public function __construct()
//    {
//        //$this->setDemons($demons);
////        $count = $this->getCountDemons();
////        for ($i = 0; $i <= $count; $i++) {
////            $this->mas_ice[] = 0;
////        }
//    }

    public function getIcePosition($position = 0)
    {
        if ($position < 0) {
            return null;
        }
        return $this->mas_ice[$position];
    }

    public function getDemonsPos($position = 0)
    {
        return $this->mas_demons[$position];
    }

    public function setIcePosition($position, $type)
    {
        $this->mas_ice[$position] = $type;
    }

    /**
     * @param mixed $positionMag
     */
    public function setPositionMag($positionMag)
    {
        $this->positionMag = $positionMag;
    }

    /**
     * @return mixed
     */
    public function getPositionMag()
    {
        return $this->positionMag;
    }

    /**
     * @param mixed $indexMaxLeft
     */
    public function setIndexMaxLeft($indexMaxLeft)
    {
        $this->indexMaxLeft = $indexMaxLeft;
    }

    /**
     * @return mixed
     */
    public function getIndexMaxLeft()
    {
        return $this->indexMaxLeft;
    }

    /**
     * @param mixed $indexMaxRight
     */
    public function setIndexMaxRight($indexMaxRight)
    {
        $this->indexMaxRight = $indexMaxRight;
    }

    /**
     * @return mixed
     */
    public function getIndexMaxRight()
    {
        return $this->indexMaxRight;
    }

    public function goMagToRight()
    {
        $pos = $this->getPositionMag();
        if ($this->getIcePosition($pos + 1) == 0) {
            $this->stickIce();
        }
        $this->setPositionMag($pos + 1);
        $this->action .= ">";
    }

    public function goMagToLeft()
    {
        $this->action .= "<";
        $pos = $this->getPositionMag();
        $this->setPositionMag($pos - 1);
    }

    public function stickIce()
    {
        $pos = $this->getPositionMag();
        switch ($this->getIcePosition($pos + 1)) {
            case 0: //Создаем лед
                $this->setIcePosition($pos + 1, 1);
                break;
            case 1: //Разбиваем лед
                $countBreakeIce = 0;
                for ($i = $pos + 1; $i <= $this->getCountDemons(); $i++) {
                    if ($this->getIcePosition($i)) {
                        $this->setIcePosition($i, 0);
                        $countBreakeIce++;
                        if ($countBreakeIce > 1) {
                            $this->demageDemons($i);
                        }
                    }
                }
                break;
        }

        $this->action .= "*";
    }

    public function demageDemons($position)
    {
        $this->mas_demons[$position - 1] = (($this->mas_demons[$position - 1] - 1) < 0) ? 0 : $this->mas_demons[$position - 1] - 1;
    }

    public function getAction()
    {
        return $this->action;
    }

    private function setDemons(array $demons)
    {
        $this->mas_demons = $demons;
    }

    public function getCountDemons()
    {
        return count($this->mas_demons);
    }

    /**
     * Ищем максимальній елемент с левой стороны
     *
     * @return int
     */
    public function getMaxLeft()
    {
        $count = $this->getCountDemons();
        $max = $this->mas_demons[0];
        $this->setIndexMaxLeft(0);
        for ($i = 0; $i < $count; $i++) {
            if ($max < $this->mas_demons[$i]) {
                $max = $this->mas_demons[$i];
                $this->setIndexMaxLeft($i);
            }
        }
        return $this->getIndexMaxLeft();
    }

    public function getMaxRight()
    {
        $count = $this->getCountDemons();
        $max = $this->mas_demons[$count - 1];
        $this->setIndexMaxRight($count - 1);
        for ($i = $count - 1; $i >= 0; $i--) {
            if ($max < $this->mas_demons[$i]) {
                $max = $this->mas_demons[$i];
                $this->setIndexMaxRight($i);
            }
        }
        return $this->getIndexMaxRight();
    }

    public function getMaxMaxLeft($posLeft){

        $count = $this->getCountDemons();
        if ($posLeft==$count) $posLeft--;
        $max = $this->mas_demons[$posLeft];
        $this->setIndexMaxLeft($posLeft);
        $count0 = 0;
        for ($i = $posLeft+1; $i < $count; $i++) {
            if ($this->getDemonsPos($i) == 0){
                $count0++;
            }
            else{
                $count0=0;
            }
            if ($count0>=3) break;
            if ($max <= $this->mas_demons[$i]) {
                $max = $this->mas_demons[$i];
                $this->setIndexMaxLeft($i);
            }
        }
        return $this->getIndexMaxLeft();
    }

    public function magGoTo($position = -1)
    {
        //Идем в право
        if ($this->getPositionMag() < $position) {
            for ($i = $this->getPositionMag() + 1; $i <= $position; $i++) {
                $this->goMagToRight();
            }
        }
        //Идем в лево
        if ($this->getPositionMag() > $position) {
            for ($i = $this->getPositionMag(); $i > $position; $i--) {
                $this->goMagToLeft();
            }
        }
    }

    public function isDemons()
    {
        if (array_sum($this->mas_demons)) {
            return true;
        }

        return false;
    }
}

//$demons = array(1, 1);

//$demons = explode(" ", '2 0 0 0 0 0 0 1 0 0 0 0 0 1 1 0 0 1 0 1');
//
//$ob = new Solomon();

//$ob->fight($demons);
//
//while ($ob->isDemons()) {
//    $posLeft = $ob->getMaxLeft() + 1;
//    $posRight = $ob->getMaxRight() + 1;
//    $ob->magGoTo($posRight - 1);
//    $ob->stickIce();
//    $ob->magGoTo($posLeft - 2);
//    $ob->stickIce();
//}
//
//echo $ob->getAction() . PHP_EOL;