<?php
declare(strict_types=1);

namespace BallGame\Tests\Domain\RuleBook;

use BallGame\Domain\RuleBook\AdvancedRuleBook;
use BallGame\Domain\Standings\TeamPosition;
use PHPUnit\Framework\TestCase;

class AdvancedRuleBookTest extends TestCase
{
    /**
     * @var AdvancedRuleBook
     */
    protected $advancedRuleBook;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|TeamPosition
     */
    protected $teamPositionA;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|TeamPosition
     */
    protected $teamPositionB;

    public function setUp()
    {
        $this->teamPositionA = $this->getMockBuilder(TeamPosition::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->teamPositionB = $this->getMockBuilder(TeamPosition::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->advancedRuleBook = new AdvancedRuleBook();
    }

    public function testDecideShouldReturnLessThenZeroWhenFirstTeamHasMorePoints()
    {
        $this->teamPositionA->method('getPoints')->willReturn(42);
        $this->teamPositionB->method('getPoints')->willReturn(41);

        $this->assertSame(-1, $this->advancedRuleBook->decide($this->teamPositionA, $this->teamPositionB));
    }

    public function testDecideShouldReturnGreaterThanZeroWhenSecondTeamHasMorePoints()
    {
        $this->teamPositionA->method('getPoints')->willReturn(41);
        $this->teamPositionB->method('getPoints')->willReturn(42);

        $this->assertSame(1, $this->advancedRuleBook->decide($this->teamPositionA, $this->teamPositionB));
    }

    public function testDecideShouldReturnLessThenZeroWhenBothTeamsHaveEqualPointsButFirstTeamHasMoreGoalsScored()
    {
        $this->teamPositionA->method('getPoints')->willReturn(42);
        $this->teamPositionA->method('getGoalsScored')->willReturn(13);

        $this->teamPositionB->method('getPoints')->willReturn(42);
        $this->teamPositionB->method('getGoalsScored')->willReturn(12);

        $this->assertSame(-1, $this->advancedRuleBook->decide($this->teamPositionA, $this->teamPositionB));
    }

    public function testDecideShouldReturnGreaterThenZeroWhenBothTeamsHaveEqualPointsButSecondTeamHasMoreGoalsScored()
    {
        $this->teamPositionA->method('getPoints')->willReturn(42);
        $this->teamPositionA->method('getGoalsScored')->willReturn(13);

        $this->teamPositionB->method('getPoints')->willReturn(42);
        $this->teamPositionB->method('getGoalsScored')->willReturn(14);

        $this->assertSame(1, $this->advancedRuleBook->decide($this->teamPositionA, $this->teamPositionB));
    }

    public function testDecideShouldReturnZeroWhenBothTeamsHaveEqualPointsAndEqualGoalsScored()
    {
        $this->teamPositionA->method('getPoints')->willReturn(42);
        $this->teamPositionA->method('getGoalsScored')->willReturn(13);

        $this->teamPositionB->method('getPoints')->willReturn(42);
        $this->teamPositionB->method('getGoalsScored')->willReturn(13);

        $this->assertSame(0, $this->advancedRuleBook->decide($this->teamPositionA, $this->teamPositionB));
    }

}
