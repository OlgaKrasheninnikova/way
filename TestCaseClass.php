<?php

/**
 * Хранит и агрегирует данные об одном кейсе сбора данных
 *
 * Class TestCase
 */
class TestCase {

    /** @var array $dots */
    private $dots = [];

    /** @var float */
    private $xSum = 0;

    /** @var float */
    private $ySum = 0;

    /** @var float */
    private $xAvg = 0;

    /** @var float */
    private $yAvg = 0;

    /**
     * @param float $x
     * @param float $y
     */
    public function addDot( float $x, float $y) : void {
        $this->dots[] = [$x, $y];
        $this->xSum += $x;
        $this->ySum += $y;
        $this->xAvg = null;
        $this->yAvg = null;
    }

    /**
     * @return float
     */
    public function getAvgX() : float {
        return is_null($this->xAvg) ? $this->xAvg = $this->xSum/count($this->dots) : $this->xAvg;
    }

    /**
     * @return float
     */
    public function getAvgY() : float {
        return is_null($this->yAvg) ? $this->yAvg = $this->ySum/count($this->dots) : $this->yAvg;
    }

    /**
     * Находит расстояние до наихудшей точки
     *
     * @return float
     */
    public function getWorstDotDistance() : float {
        $dMax = 0;
        foreach ($this->dots as $dot) {
            $d = $this->getDistanceBetweenDots($dot[0], $dot[1], $this->getAvgX(), $this->getAvgY());
            if ($d > $dMax) {
                $dMax = $d;
            }
        }
        return $dMax;
    }

    /**
     * @return bool
     */
    public function isEmpty() : bool {
        return count($this->dots) == 0;
    }


    /**
     * Находит расстояние между 2-я точками
     *     *
     * @param float $x1
     * @param float $y1
     * @param float $x2
     * @param float $y2
     * @return float
     */
    private function getDistanceBetweenDots(float $x1, float $y1, float $x2, float $y2) : float {
        return ( ($x1 - $x2)**2 + ($y1 - $y2)**2 ) **0.5;
    }


}