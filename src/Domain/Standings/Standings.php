<?php
declare(strict_types=1);


namespace BallGame\Domain\Standings;


use BallGame\Domain\Match\Match;
use BallGame\Domain\RuleBook\RuleBookInterface;
use BallGame\Domain\Team\Team;

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

    /**
     * @var RuleBookInterface
     */
    private $rulebook;

    public function __construct(RuleBookInterface $rulebook)
    {
        $this->rulebook = $rulebook;
    }

    public function record(Match $match)
    {
        $this->matches[] = $match;
    }

    public function getSortedStandings()
    {
        foreach ($this->matches as $match) {
            $homeTeamPosition = $this->getTeamPosition($match->getHomeTeam());
            $awayTeamPosition = $this->getTeamPosition($match->getAwayTeam());

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
        uasort($this->teamPositions, [$this->rulebook, 'decide']);

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

    /**
     * @param $match
     * @return TeamPosition
     */
    public function getTeamPosition(Team $team): TeamPosition
    {
        if (!isset($this->teamPositions[spl_object_hash($team)])) {
            $this->teamPositions[spl_object_hash($team)] = new TeamPosition($team);
        }
        $homeTeamPosition = $this->teamPositions[spl_object_hash($team)];
        return $homeTeamPosition;
    }
}
