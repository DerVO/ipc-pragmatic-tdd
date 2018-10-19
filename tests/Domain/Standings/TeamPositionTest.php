<?php
declare(strict_types=1);

namespace BallGame\Tests\Domain\Standings;

use BallGame\Domain\Standings\TeamPosition;
use BallGame\Domain\Team\Team;
use PHPUnit\Framework\TestCase;

class TeamPositionTest extends TestCase
{
    /**
     * @var TeamPosition
     */
    protected $teamPosition;

    public function setUp()
    {
        $team = Team::create('Team name');

        $this->teamPosition = new TeamPosition($team);
    }

    public function testGetPointsAfterNoMatches()
    {
        $this->assertSame(0, $this->teamPosition->getPoints());
    }

    public function testGetPointsAfterThreeWins()
    {
        $this->teamPosition->recordWin();
        $this->teamPosition->recordWin();
        $this->teamPosition->recordWin();

        $this->assertSame(9, $this->teamPosition->getPoints());
    }

    public function testGetGoalsScoredWithNoGames()
    {
        $this->assertSame(0, $this->teamPosition->getGoalsScored());
    }

    public function testGetGoalsScoredAfterThreeGames()
    {
        $this->teamPosition->recordGoalsScored(1);
        $this->teamPosition->recordGoalsScored(2);
        $this->teamPosition->recordGoalsScored(3);

        $this->assertSame(6, $this->teamPosition->getGoalsScored());
    }

    public function testGetGoalsAgainstWithNoGames()
    {
        $this->assertSame(0, $this->teamPosition->getGoalsAgainst());
    }

    public function testGetGoalsAgainstAfterThreeGames()
    {
        $this->teamPosition->recordGoalsAgainst(10);
        $this->teamPosition->recordGoalsAgainst(20);
        $this->teamPosition->recordGoalsAgainst(30);

        $this->assertSame(60, $this->teamPosition->getGoalsAgainst());
    }
}
