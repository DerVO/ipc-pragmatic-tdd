<?php
declare(strict_types=1);


namespace BallGame\Domain\Match;


use BallGame\Domain\Exception\BadMatchException;
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

    /**
     * @return Team
     */
    public function getHomeTeam(): Team
    {
        return $this->homeTeam;
    }

    /**
     * @return Team
     */
    public function getAwayTeam(): Team
    {
        return $this->awayTeam;
    }

    /**
     * @return int
     */
    public function getHomeTeamGoals(): int
    {
        return $this->homeTeamGoals;
    }

    /**
     * @return int
     */
    public function getAwayTeamGoals(): int
    {
        return $this->awayTeamGoals;
    }

    public static function create(
        Team $homeTeam,
        Team $awayTeam,
        int $homeTeamGoals,
        int $awayTeamGoals
    )
    {
        if ($homeTeam->getName() === $awayTeam->getName()) {
            throw new BadMatchException();
        }

        return new self($homeTeam, $awayTeam, $homeTeamGoals, $awayTeamGoals);
    }
}
