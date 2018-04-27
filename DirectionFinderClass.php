<?php

include "TestCaseClass.php";

/**
 * Класс для решения задачи "All Different Directions"
 *
 * Class DirectionFinder
 */
class DirectionFinder {

    const PRECISION = 2;

    const WAY_START = 'start';

    const WAY_TURN = 'turn';

    const WAY_WALK = 'walk';

    /**
     * @var array
     */
    private static $valid_instructions = [
        self::WAY_START => true,
        self::WAY_TURN => true,
        self::WAY_WALK => true,
    ];

    /**
     * Точка входа
     *
     * @param string $input
     * @return string
     */
    public function execute(string $input) : string {
        $result = "";
        $testCase = new TestCase();

        foreach ($this->tokenizeString($input) as $string) {
            if ('' == $string) {
                continue;
            }
            if (is_numeric($string)) {
                $this->addDataToResult($result, $testCase);
                $testCase = new TestCase();
            } else {
                $currentInstruction = null;
                $x = null;
                $y = null;
                $currentDegree = 0;
                foreach ($this->tokenizeString($string, ' ') as $i => $val) {

                    if (0 == $i && is_numeric($val)) {
                        $x = $val;
                    } else if (1 == $i && is_numeric($val)) {
                        $y = $val;
                    } else if ($this->isDirectionInstruction($val)) {
                        $currentInstruction = $val;
                    } else if (!is_null($currentInstruction) && is_numeric($val)) {
                        switch ($currentInstruction) {
                            case self::WAY_START:
                                $currentDegree = $val;
                                break;
                            case self::WAY_TURN:
                                $currentDegree += $val;
                                break;
                            case self::WAY_WALK:
                                $this->walk($x, $y, $currentDegree, $val);
                                break;
                        }
                        $currentInstruction = null;
                    }
                }
                if (isset($x) && isset($y)) {
                    $testCase->addDot($x, $y);
                } else {
                    throw new InvalidArgumentException('Bad data input');
                }
            }
        }
        $this->addDataToResult($result, $testCase);

        return trim($result);
    }

    /**
     * @param string $result
     * @param TestCase $caseData
     */
    private function addDataToResult(string &$result, TestCase $caseData) : void {
        if (!$caseData->isEmpty()) {
            $result .= round($caseData->getAvgX(), self::PRECISION) . " " . round($caseData->getAvgY(), self::PRECISION) . " " . round($caseData->getWorstDotDistance(), self::PRECISION) . "\n";
        }

    }

    /**
     * Является ли значение ключевым словом инструкции для перемещения
     *
     * @param string $val
     * @return bool
     */
    private function isDirectionInstruction(string $val) : bool {
        return isset(self::$valid_instructions[$val]);
    }


    /**
     * Перемещаение из точки (x,y) под углом degree на расстояние distance
     *
     * @param float $x
     * @param float $y
     * @param float $degree
     * @param float $distance
     */
    private function walk(float &$x, float &$y, float &$degree, float $distance) {
        if ($degree >= 360) {
            $degree = $degree % 360;
        }
        $x = $x + $distance * cos(deg2rad($degree));
        $y = $y + $distance * sin(deg2rad($degree));
    }

    /**
     * Возвращает следующий элемент строки
     *
     * @param string $input
     * @param string $delimiter
     * @return Generator
     */
    private function tokenizeString(string $input, string $delimiter = "\n") {

        $prev_pos = 0;
        while($pos = strpos($input, $delimiter, $prev_pos))
        {
            $substr = substr($input, $prev_pos, $pos - $prev_pos);
            yield $substr;
            $prev_pos = $pos + strlen($delimiter);
        }
        yield substr($input, $prev_pos);
    }


}