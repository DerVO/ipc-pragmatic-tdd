<?php
declare(strict_types=1);

namespace BallGame\Tests\Domain\RuleBook;

use BallGame\Domain\RuleBook\AdvancedRuleBook;
use BallGame\Domain\Standings\TeamPosition;
use PHPUnit\Framework\TestCase;

class AdvancedRulebookTest extends TestCase
{

    /**
     * @var SimpleRuleBook
     */
    private $ruleBook;
    /**
     * @var TeamPosition
     */
    private $teamPositionA;
    private $teamPositionB;

    public function setUp()
    {
        $this->teamPositionA = $this->getMockBuilder(TeamPosition::class)
            ->disableOriginalConstructor()->getMock();
        $this->teamPositionB = $this->getMockBuilder(TeamPosition::class)
            ->disableOriginalConstructor()->getMock();

        $this->ruleBook = new AdvancedRuleBook();
    }

    public function testDecideShouldReturnLessThenZeroIfFirstTeamHasLessPoints()
    {
        $this->teamPositionA->method('getPoints')->willReturn(42);
        $this->teamPositionB->method('getPoints')->willReturn(41);

        $this->assertSame(-1, $this->ruleBook->decide($this->teamPositionA, $this->teamPositionB));
    }

    public function testDecideShouldReturnMoreThenZeroIfFirstTeamHasMorePoints()
    {
        $this->teamPositionA->method('getPoints')->willReturn(42);
        $this->teamPositionB->method('getPoints')->willReturn(44);

        $this->assertSame(1, $this->ruleBook->decide($this->teamPositionA, $this->teamPositionB));
    }

    public function testDecideShouldReturnPositiveIfBothTeamsHaveEqualPointsAndFirstTeamHasBetterGoalDifference()
    {
        $this->teamPositionA->method('getPoints')->willReturn(39);
        $this->teamPositionA->method('getGoalsScored')->willReturn(82);
        $this->teamPositionA->method('getGoalsAgainst')->willReturn(14);
        $this->teamPositionA->method('getGoalDifference')->willReturn(82-14);

        $this->teamPositionB->method('getPoints')->willReturn(39);
        $this->teamPositionB->method('getGoalsScored')->willReturn(85);
        $this->teamPositionB->method('getGoalsAgainst')->willReturn(24);
        $this->teamPositionB->method('getGoalDifference')->willReturn(85-24);

        $this->assertSame(-1, $this->ruleBook->decide($this->teamPositionA, $this->teamPositionB));
        $this->assertSame(1, $this->ruleBook->decide($this->teamPositionB, $this->teamPositionA));
    }

    public function testDecideShouldReturnPositiveIfBothTeamsHaveEqualPointsAndEqualGoalDifferenceAndFirstTeamScoredMoreGoals()
    {
        $this->teamPositionA->method('getPoints')->willReturn(39);
        $this->teamPositionA->method('getGoalsScored')->willReturn(86);
        $this->teamPositionA->method('getGoalsAgainst')->willReturn(25);
        $this->teamPositionA->method('getGoalDifference')->willReturn(86-25);

        $this->teamPositionB->method('getPoints')->willReturn(39);
        $this->teamPositionB->method('getGoalsScored')->willReturn(85);
        $this->teamPositionB->method('getGoalsAgainst')->willReturn(24);
        $this->teamPositionB->method('getGoalDifference')->willReturn(85-24);

        $this->assertSame(-1, $this->ruleBook->decide($this->teamPositionA, $this->teamPositionB));
    }

    public function testDecideShouldReturnZeroBothTeamsHaveEqualPointsAndEqualGoalDifferenceAndEqualScoredGoals()
    {
        $this->teamPositionA->method('getPoints')->willReturn(17);
        $this->teamPositionA->method('getGoalsScored')->willReturn(86);
        $this->teamPositionA->method('getGoalsAgainst')->willReturn(25);
        $this->teamPositionA->method('getGoalDifference')->willReturn(86-25);

        $this->teamPositionB->method('getPoints')->willReturn(17);
        $this->teamPositionB->method('getGoalsScored')->willReturn(86);
        $this->teamPositionB->method('getGoalsAgainst')->willReturn(25);
        $this->teamPositionB->method('getGoalDifference')->willReturn(86-25);

        $this->assertSame(0, $this->ruleBook->decide($this->teamPositionA, $this->teamPositionB));
    }
}
