<?php
declare(strict_types=1);

namespace BallGame\Domain\Standings;

use BallGame\Domain\Team\Team;

class TeamPosition
{
    const POINTS_PER_LOSS = 0;
    const POINTS_PER_DRAW = 1;
    const POINTS_PER_WIN = 3;

    /**
     * @var Team
     */
    private $team;
    /**
     * @var int
     */
    private $gamesPlayed = 0;
    private $wins = 0;
    private $draws = 0;
    private $losses = 0;
    private $points = 0;
    private $goalsScored = 0;
    private $goalsReceived = 0;

    /**
     * TeamPosition constructor.
     * @param Team $team
     */
    public function __construct(Team $team)
    {
        $this->team = $team;
    }

    public function recordGame(int $goalsScored, int $goalsReceived) {
        $this->recordGoalsScored($goalsScored);
        $this->recordGoalsReceived($goalsReceived);
        if ($goalsScored > $goalsReceived) {
            $this->recordWin();
        } elseif ($goalsScored == $goalsReceived) {
            $this->recordDraw();
        } else {
            $this->recordLoss();
        }
    }

    public function recordWin()
    {
        $this->gamesPlayed++;
        $this->wins++;
        $this->points += self::POINTS_PER_WIN;
    }

    public function recordDraw()
    {
        $this->gamesPlayed++;
        $this->draws++;
        $this->points += self::POINTS_PER_DRAW;
    }

    public function recordLoss()
    {
        $this->gamesPlayed++;
        $this->losses++;
        $this->points += self::POINTS_PER_LOSS;
    }

    public function recordGoalsScored(int $goalsScored)
    {
        $this->goalsScored += $goalsScored;
    }

    public function recordGoalsReceived(int $goalsReceived)
    {
        $this->goalsReceived += $goalsReceived;
    }

    public function getPoints()
    {
        return $this->points;
    }

    public function getGoalsScored()
    {
        return $this->goalsScored;
    }

    public function getGoalsReceived()
    {
        return $this->goalsReceived;
    }


}