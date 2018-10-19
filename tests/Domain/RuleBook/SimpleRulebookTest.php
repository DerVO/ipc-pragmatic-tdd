<?php
declare(strict_types=1);

namespace BallGame\Tests\Domain\RuleBook;

use BallGame\Domain\RuleBook\SimpleRuleBook;
use BallGame\Domain\Standings\TeamPosition;
use BallGame\Domain\Team\Team;
use PHPUnit\Framework\TestCase;

class SimpleRulebookTest extends TestCase
{

    /**
     * @var SimpleRuleBook
     */
    private $simpleRuleBook;
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

        $this->simpleRuleBook = new SimpleRuleBook();
    }

    public function testDecideShouldReturnLessThenZeroIfFirstTeamHasLessPoints()
    {
        $this->teamPositionA->method('getPoints')->willReturn(42);
        $this->teamPositionB->method('getPoints')->willReturn(41);

        $this->assertSame(-1, $this->simpleRuleBook->decide($this->teamPositionA, $this->teamPositionB));
    }

    public function testDecideShouldReturnMoreThenZeroIfFirstTeamHasMorePoints()
    {
        $this->teamPositionA->method('getPoints')->willReturn(42);
        $this->teamPositionB->method('getPoints')->willReturn(44);

        $this->assertSame(1, $this->simpleRuleBook->decide($this->teamPositionA, $this->teamPositionB));
    }

    public function testDecideShouldReturnZeroIfBothTeamsHaveEqualPoints()
    {
        $this->teamPositionA->method('getPoints')->willReturn(39);
        $this->teamPositionB->method('getPoints')->willReturn(39);

        $this->assertSame(0, $this->simpleRuleBook->decide($this->teamPositionA, $this->teamPositionB));
    }
}
