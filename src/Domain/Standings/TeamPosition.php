<?php
declare(strict_types=1);


namespace BallGame\Domain\Standings;


use BallGame\Domain\Team\Team;

class TeamPosition
{
    /**
     * @var int
     */
    private $goalsAgainst = 0;

    /**
     * @var int
     */
    private $goalsScored = 0;

    /**
     * @var int
     */
    private $wins = 0;

    /**
     * @var Team
     */
    private $team;

    public function __construct(Team $team)
    {
        $this->team = $team;
    }

    public function recordWin()
    {
        $this->wins += 1;
    }

    public function getPoints()
    {
        return $this->wins * 3;
    }

    public function recordGoalsScored(int $int)
    {
        $this->goalsScored += $int;
    }

    public function getGoalsScored()
    {
        return $this->goalsScored;
    }

    public function recordGoalsAgainst(int $int)
    {
        $this->goalsAgainst += $int;
    }

    public function getGoalsAgainst()
    {
        return $this->goalsAgainst;
    }

    /**
     * @return Team
     */
    public function getTeam()
    {
        return $this->team;
    }
}
