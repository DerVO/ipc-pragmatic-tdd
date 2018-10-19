<?php
declare(strict_types=1);

namespace BallGame\Domain\RuleBook;


use BallGame\Domain\Standings\TeamPosition;

class AdvancedRuleBook implements RuleBookInterface
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
        } elseif ($positionTeamB->getPoints() > $positionTeamA->getPoints()) {
            return 1;
        } else {
            if ($positionTeamA->getGoalDifference() > $positionTeamB->getGoalDifference()) {
                return -1;
            } elseif ($positionTeamB->getGoalDifference() > $positionTeamA->getGoalDifference()) {
                return 1;
            } else {
                if ($positionTeamA->getGoalsScored() > $positionTeamB->getGoalsScored()) {
                    return -1;
                } elseif ($positionTeamB->getGoalsScored() > $positionTeamA->getGoalsScored()) {
                    return 1;
                } else {
                    return 0;
                }
            }
        }
    }
}