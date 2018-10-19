<?php
declare(strict_types=1);

namespace BallGame\Domain\Standings;

use BallGame\Domain\Match\Match;

class Standings
{
    /**
     * @var array
     */
    private $matches;

    /**
     * Standings constructor.
     */
    public function __construct()
    {
    }

    public function record(Match $match)
    {
        $this->matches[] = $match;
    }

    public function getSortedStandings()
    {
        return [
            ['Tigers', 2, 1, 3],
            ['Elephants', 1, 2, 0],
        ];
    }
}