<?php
declare(strict_types=1);


namespace BallGame\Domain\Standings;


use BallGame\Domain\Match\Match;
use BallGame\Domain\RuleBook\RuleBookInterface;
use BallGame\Infrastructure\MatchRepository;

class Standings
{
    /**
     * @var TeamPosition[]
     */
    protected $teamPositions;

    /**
     * @var RuleBookInterface
     */
    private $ruleBook;

    /**
     * @var MatchRepository
     */
    private $matchRepository;

    public function __construct(
        RuleBookInterface $ruleBook,
        MatchRepository $matchRepository
    )
    {
        $this->ruleBook = $ruleBook;
        $this->matchRepository = $matchRepository;
    }

    public function record(Match $match)
    {
        $this->matchRepository->save($match);
    }

    public function getSortedStandings()
    {
        foreach ($this->matchRepository->findAll() as $match) {
            $homeTeamPosition = $this->getHomeTeam($match);
            $awayTeamPosition = $this->getAwayTeam($match);

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
        uasort($this->teamPositions, [$this->ruleBook, 'decide']);

        // Prepare the output
        $output = [];
        foreach ($this->teamPositions as $teamPosition) {
            $output[] = [
                $teamPosition->getTeam()->getName(),
                $teamPosition->getGamesWon(),
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
    private function getHomeTeam(Match $match): TeamPosition
    {
        if (!isset($this->teamPositions[sha1($match->getHomeTeam()->getName())])) {
            $this->teamPositions[sha1($match->getHomeTeam()->getName())] = new TeamPosition($match->getHomeTeam());
        }
        $homeTeamPosition = $this->teamPositions[sha1($match->getHomeTeam()->getName())];
        return $homeTeamPosition;
    }

    /**
     * @param $match
     * @return TeamPosition
     */
    private function getAwayTeam(Match $match): TeamPosition
    {
        if (!isset($this->teamPositions[sha1($match->getAwayTeam()->getName())])) {
            $this->teamPositions[sha1($match->getAwayTeam()->getName())] = new TeamPosition($match->getAwayTeam());
        }
        $awayTeamPosition = $this->teamPositions[sha1($match->getAwayTeam()->getName())];
        return $awayTeamPosition;
    }
}
