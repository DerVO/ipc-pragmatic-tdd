<?php
declare(strict_types=1);

use BallGame\Domain\Standings\TeamPosition;
use BallGame\Domain\Team\Team;
use PHPUnit\Framework\TestCase;


class TeamPositionTest extends TestCase
{
    /**
     * @var TeamPosition
     */
    private $teamPosition;

    public function setUp()
    {
        $team = Team::create('snakes');

        $this->teamPosition = new TeamPosition($team);
    }

    public function testGetPointsAfterThreeWins()
    {
        $this->teamPosition->recordWin();
        $this->teamPosition->recordWin();
        $this->teamPosition->recordWin();

        $this->assertSame(9, $this->teamPosition->getPoints());
    }

    public function testGetPointsAfterNoGames()
    {
        $this->assertSame(0, $this->teamPosition->getPoints());
    }

    public function testGetGoalsScoredAfterThreeGames()
    {
        $this->teamPosition->recordGoalsScored(3);
        $this->teamPosition->recordGoalsScored(1);
        $this->teamPosition->recordGoalsScored(0);

        $this->assertSame(4, $this->teamPosition->getGoalsScored());
    }

    public function testGetGoalsScoredAfterNoGames()
    {
        $this->assertSame(0, $this->teamPosition->getGoalsScored());
    }

    public function testGetGoalsReceivedAfterThreeGames()
    {
        $this->teamPosition->recordGoalsReceived(0);
        $this->teamPosition->recordGoalsReceived(4);
        $this->teamPosition->recordGoalsReceived(2);

        $this->assertSame(6, $this->teamPosition->getGoalsReceived());
    }

    public function testGetGoalsReceivedAfterNoGames()
    {
        $this->assertSame(0, $this->teamPosition->getGoalsReceived());
    }

}
