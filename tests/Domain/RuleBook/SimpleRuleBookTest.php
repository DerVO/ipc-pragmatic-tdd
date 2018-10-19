<?php
declare(strict_types=1);

namespace BallGame\Tests\Domain\RuleBook;

use BallGame\Domain\RuleBook\SimpleRuleBook;
use BallGame\Domain\Standings\TeamPosition;
use BallGame\Domain\Team\Team;
use PHPUnit\Framework\TestCase;

class SimpleRuleBookTest extends TestCase
{
    /**
     * @var SimpleRuleBook
     */
    protected $simpleRuleBook;

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

        $this->simpleRuleBook = new SimpleRuleBook();
    }

    public function testDecideShouldReturnLessThenZeroWhenFirstTeamHasMorePoints()
    {
        $this->teamPositionA->method('getPoints')->willReturn(42);
        $this->teamPositionB->method('getPoints')->willReturn(41);

        $this->assertSame(-1, $this->simpleRuleBook->decide($this->teamPositionA, $this->teamPositionB));
    }

    public function testDecideShouldReturnGreaterThanZeroWhenSecondTeamHasMorePoints()
    {
        $this->teamPositionA->method('getPoints')->willReturn(41);
        $this->teamPositionB->method('getPoints')->willReturn(42);

        $this->assertSame(1, $this->simpleRuleBook->decide($this->teamPositionA, $this->teamPositionB));
    }

    public function testDecideShouldReturnZeroWhenBothTeamsHaveEqualAmountOfPoints()
    {
        $this->teamPositionA->method('getPoints')->willReturn(42);
        $this->teamPositionB->method('getPoints')->willReturn(42);

        $this->assertSame(0, $this->simpleRuleBook->decide($this->teamPositionA, $this->teamPositionB));
    }
}
