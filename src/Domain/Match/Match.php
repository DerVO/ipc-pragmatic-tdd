<?php
declare(strict_types=1);

namespace BallGame\Domain\Match;

use BallGame\Domain\Team\Team;

class Match
{

    /**
     * @var \BallGame\Domain\Team\Team
     */
    private $teamHome;
    private $teamAway;
    /**
     * @var int
     */
    private $goalsHome;
    private $goalsAway;

    private function __construct(Team $teamHome, Team $teamAway, int $goalsHome, int $goalsAway)
    {
        $this->teamHome = $teamHome;
        $this->teamAway = $teamAway;
        $this->goalsHome = $goalsHome;
        $this->goalsAway = $goalsAway;

    }

    public static function create(Team $teamHome, Team $teamAway, int $goalsHome, int $goalsAway)
    {
        return new self($teamHome, $teamAway, $goalsHome, $goalsAway);
    }
}