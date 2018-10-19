<?php
declare(strict_types=1);


namespace BallGame;


class GetTheBallRolling
{
    private $name;

    private function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function create(string $name)
    {
        return new self($name);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getBinaryGap(int $n) {
        $gap_length = 0;
        $max_gap_length = 0;
        $p = 0;
        do {
            $pow = pow(2, $p++);
            $bit = ($n & $pow) > 0;
            if ($bit) {
                $gap_length = 0;
            } else {
                $gap_length++;
            }
            if ($gap_length > $max_gap_length) $max_gap_length = $gap_length;
            echo($n . ', p:' . ($p-1) .',pow: '.$pow.', b: '. $bit."\n");
        } while ($pow < $n);
        return $max_gap_length;
    }
}
