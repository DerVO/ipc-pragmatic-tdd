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
        }

        if ($positionTeamB->getPoints() > $positionTeamA->getPoints()) {
            return 1;
        }

        if ($positionTeamA->getPoints() === $positionTeamB->getPoints()) {

            if ($positionTeamA->getGoalDifference() > $positionTeamB->getGoalDifference()) {
                return -1;
            }
            if ($positionTeamB->getGoalDifference() > $positionTeamA->getGoalDifference()) {
                return 1;
            }
            if ($positionTeamA->getGoalDifference() === $positionTeamB->getGoalDifference()) {

                if ($positionTeamA->getGoalsScored() > $positionTeamB->getGoalsScored()) {
                    return -1;
                }
                if ($positionTeamB->getGoalsScored() > $positionTeamA->getGoalsScored()) {
                    return 1;
                }
                if ($positionTeamA->getGoalsScored() === $positionTeamB->getGoalsScored()) {
                    return 0;
                }

            }
        }
    }
}