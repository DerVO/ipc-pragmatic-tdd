<?php
declare(strict_types=1);

namespace BallGame\Infrastructure;


use BallGame\Domain\Match\Match;

class MatchRepository
{
    /**
     * @var Match[]
     */
    private $matches;

    /**
     * @param Match $match
     */
    public function save(Match $match)
    {
        sleep(1);
        $this->matches[] = $match;
    }

    /**
     * @return Match[]
     */
    public function findAll()
    {
        sleep(1);
        return $this->matches;
    }

}