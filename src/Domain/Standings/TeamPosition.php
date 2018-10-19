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
    private $ties = 0;
    private $losses = 0;
    private $gamesPlayed = 0;
    private $points = 0;

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
        $this->gamesPlayed++;
        $this->wins += 1;
        $this->points += 3;
    }

    public function recordLoss()
    {
        $this->gamesPlayed++;
        $this->losses += 1;
        $this->points += 0;
    }

    public function recordTie()
    {
        $this->gamesPlayed++;
        $this->ties += 1;
        $this->points += 1;
    }

    public function getPoints()
    {
        return $this->points;
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

    public function getGoalDifference()
    {
        return $this->getGoalsScored() - $this->getGoalsAgainst();
    }

    /**
     * @return Team
     */
    public function getTeam()
    {
        return $this->team;
    }

    public function getGamesPlayed()
    {
        return $this->gamesPlayed;
    }

    public function getGamesWon()
    {
        return $this->wins;
    }

    public function getGamesTied()
    {
        return $this->ties;
    }

    public function getGamesLost()
    {
        return $this->losses;
    }
}
