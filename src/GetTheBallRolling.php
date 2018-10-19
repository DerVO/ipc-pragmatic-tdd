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

    public function getBinaryGap(int $number)
    {
        $binary = decbin($number);

        $counting = false;
        $gap = 0;
        for ($i = 0; $i < strlen($binary); $i += 1) {
            if ($counting == true && $binary[$i] == 1) {
                $counting = false;
                continue;
            }

            if ($counting == false && $binary[$i] == 1) {
                $counting = true;
                continue;
            }

            if ($counting && $binary[$i] == 0) {
                $gap += 1;
            }
        }

        return $gap;
    }
}
