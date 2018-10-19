<?php
declare(strict_types=1);


namespace BallGame\Domain\Standings;


use BallGame\Domain\Match\Match;

class Standings
{
    /**
     * @var Match[]
     */
    protected $matches;

    /**
     * @var TeamPosition[]
     */
    protected $teamPositions;

    public function __construct()
    {
    }

    public function record(Match $match)
    {
        $this->matches[] = $match;
    }

    public function getSortedStandings()
    {
        foreach ($this->matches as $match) {
            if (!isset($this->teamPositions[spl_object_hash($match->getHomeTeam())])) {
                $this->teamPositions[spl_object_hash($match->getHomeTeam())] = new TeamPosition($match->getHomeTeam());
            }

            if (!isset($this->teamPositions[spl_object_hash($match->getAwayTeam())])) {
                $this->teamPositions[spl_object_hash($match->getAwayTeam())] = new TeamPosition($match->getAwayTeam());
            }

            $homeTeamPosition = $this->teamPositions[spl_object_hash($match->getHomeTeam())];
            $awayTeamPosition = $this->teamPositions[spl_object_hash($match->getAwayTeam())];

            // Home team won, yay!
            if ($match->getHomeTeamGoals() > $match->getAwayTeamGoals()) {
                $homeTeamPosition->recordWin();
            }

            // Away team won, awww :(
            if ($match->getAwayTeamGoals() > $match->getHomeTeamGoals()) {
                $awayTeamPosition->recordWin();
            }

            // Record who scored what
            $homeTeamPosition->recordGoalsScored($match->getHomeTeamGoals());
            $homeTeamPosition->recordGoalsAgainst($match->getAwayTeamGoals());

            $awayTeamPosition->recordGoalsScored($match->getAwayTeamGoals());
            $awayTeamPosition->recordGoalsAgainst($match->getHomeTeamGoals());
        }

        // Sort the team positions
        uasort($this->teamPositions, function (TeamPosition $teamA, TeamPosition $teamB) {
            if ($teamA->getPoints() > $teamB->getPoints()) {
                return -1;
            }

            if ($teamB->getPoints() > $teamA->getPoints()) {
                return 1;
            }

            if ($teamA->getPoints() === $teamB->getPoints()) {
                return 0;
            }
        });

        // Prepare the output
        $output = [];
        foreach ($this->teamPositions as $teamPosition) {
            $output[] = [
                $teamPosition->getTeam()->getName(),
                $teamPosition->getGoalsScored(),
                $teamPosition->getGoalsAgainst(),
                $teamPosition->getPoints(),
            ];
        }

        return $output;
    }
}
