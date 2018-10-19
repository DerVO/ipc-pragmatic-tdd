<?php
declare(strict_types=1);

namespace BallGame\Tests\Domain\Standings;

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

    public function testGetPointsAfterThreeWins()
    {
        $this->teamPosition->recordWin();
        $this->teamPosition->recordWin();
        $this->teamPosition->recordWin();

        $this->assertSame(9, $this->teamPosition->getPoints());
    }

    public function testGetPointsAfterNoMatches()
    {
        $this->assertSame(0, $this->teamPosition->getPoints());
    }
}
