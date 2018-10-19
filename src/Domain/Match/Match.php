<?php
declare(strict_types=1);


namespace BallGame\Domain\Match;


use BallGame\Domain\Team\Team;

class Match
{
    /**
     * @var Team
     */
    private $homeTeam;

    /**
     * @var Team
     */
    private $awayTeam;

    /**
     * @var int
     */
    private $homeTeamGoals;

    /**
     * @var int
     */
    private $awayTeamGoals;

    private function __construct(
        Team $homeTeam,
        Team $awayTeam,
        int $homeTeamGoals,
        int $awayTeamGoals
    )
    {
        $this->homeTeam = $homeTeam;
        $this->awayTeam = $awayTeam;
        $this->homeTeamGoals = $homeTeamGoals;
        $this->awayTeamGoals = $awayTeamGoals;
    }

    public static function create(
        Team $homeTeam,
        Team $awayTeam,
        int $homeTeamGoals,
        int $awayTeamGoals
    )
    {
        return new self($homeTeam, $awayTeam, $homeTeamGoals, $awayTeamGoals);
    }
}
