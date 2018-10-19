<?php
declare(strict_types=1);


namespace BallGame\Domain\RuleBook;


use BallGame\Domain\Standings\TeamPosition;

class AdvancedRuleBook implements RuleBookInterface
{

    public function decide(TeamPosition $teamA, TeamPosition $teamB)
    {
        if ($teamA->getPoints() > $teamB->getPoints()) {
            return -1;
        }

        if ($teamB->getPoints() > $teamA->getPoints()) {
            return 1;
        }

        if ($teamA->getPoints() === $teamB->getPoints()) {
            if ($teamA->getGoalsScored() > $teamB->getGoalsScored()) {
                return -1;
            }

            if ($teamB->getGoalsScored() > $teamA->getGoalsScored()) {
                return 1;
            }

            return 0;
        }
    }
}
