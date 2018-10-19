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
    private $teamPositions;

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
        $teamsArray = array();
        foreach ($this->matches as $match)
        {
            $homeTeam = $match->getHomeTeam();
            $homeTeam->getTeamPosition()->recordGame($match->getHomeGoals(), $match->getAwayGoals());
            $awayTeam = $match->getAwayTeam();
            $awayTeam->getTeamPosition()->recordGame($match->getAwayGoals(), $match->getHomeGoals());

            $teamsArray[] = $homeTeam;
            $teamsArray[] = $awayTeam;
        }

        $standings = array();
        foreach (array_unique($teamsArray) as $team) {
            $pos = $team->getTeamPosition();
            $standings[] = [$team->getName(), $pos->getGoalsScored(), $pos->getGoalsReceived(), $pos->getPoints()];
        }
        usort($standings, function ($a, $b) {
            return $b[3] - $a[3];
        });
        return $standings;
    }
}