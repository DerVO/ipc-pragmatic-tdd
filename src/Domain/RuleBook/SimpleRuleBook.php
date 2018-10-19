<?php
declare(strict_types=1);

namespace BallGame\Domain\RuleBook;


use BallGame\Domain\Standings\TeamPosition;

class SimpleRuleBook implements RuleBookInterface
{

    /**
     * SimpleRuleBook constructor.
     */
    public function __construct()
    {
    }

    public function decide(TeamPosition $positionTeamA, TeamPosition $positionTeamB)
    {
        if ($positionTeamA->getPoints() > $positionTeamB->getPoints()) {
            return -1;
        }

        if ($positionTeamB->getPoints() > $positionTeamA->getPoints()) {
            return 1;
        }

        if ($positionTeamA->getPoints() === $positionTeamB->getPoints()) {
            return 0;
        }
    }
}