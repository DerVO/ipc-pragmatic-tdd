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

        // calc length of binary representation
        $length_of_binary_representation = ceil(log($n, 2));

        // find the longest gap
        $gap_length = 0;
        $max_gap_length = 0;
        $gap_found = false;
        for ($p = 0; $p < $length_of_binary_representation; $p++) {
            $pow = pow(2, $p);
            $bit = ($n & $pow) > 0;
            if ($bit) {
                $gap_found = true;
                $gap_length = 0;
                if ($gap_length > $max_gap_length) $max_gap_length = $gap_length;
            } elseif ($gap_found) {
                $gap_length++;
            }
            echo("\n".$n . ', '.$length_of_binary_representation.', gap: '.$gap_length.', p:' . ($p) .', pow: '.$pow.', b: '. $bit);
        };
        return $max_gap_length;
    }
}
