<?php
declare(strict_types=1);

namespace BallGame\Tests\Domain\Standings;

use BallGame\Domain\Match\Match;
use BallGame\Domain\Standings\Standings;
use BallGame\Domain\Team\Team;
use PHPUnit\Framework\TestCase;

class StandingsTest extends TestCase
{
    /**
     * @var Standings
     */
    protected $standings;

    public function setUp()
    {
        $this->standings = new Standings();
    }

    public function testGetSortedStandingsWhenThereWasAMatchBetweenTwoTeams()
    {
        // Given
        $tigers = Team::create('Tigers');
        $elephants = Team::create('Elephants');

        $match = Match::create($tigers, $elephants, 2, 1);

        $this->standings->record($match);

        // When
        $actualStandings = $this->standings->getSortedStandings();
        $expectedStandings = [
            ['Tigers', 2, 1, 3],
            ['Elephants', 1, 2, 0],
        ];

        // Then
        $this->assertSame($expectedStandings, $actualStandings);
    }

    public function testGetSortedStandingsWhenTheSecondTeamEndsUpFirst()
    {
        // Given
        $tigers = Team::create('Tigers');
        $elephants = Team::create('Elephants');

        $match = Match::create($tigers, $elephants, 0, 1);

        $this->standings->record($match);

        // When
        $actualStandings = $this->standings->getSortedStandings();
        $expectedStandings = [
            ['Elephants', 1, 0, 3],
            ['Tigers', 0, 1, 0],
        ];

        // Then
        $this->assertSame($expectedStandings, $actualStandings);
    }

    public function testgetSortedStandingsCanBeWeirdWithManyTeams()
    {
        $tigers = Team::create('Tigers');
        $elephants = Team::create('Elephants');

        $match = Match::create($tigers, $elephants, 0, 1);

        $this->standings->record($match);

        $tigers = Team::create('Tigers');
        $elephants = Team::create('Elephants');

        $match = Match::create($tigers, $elephants, 0, 2);

        $this->standings->record($match);

        // When
        $actualStandings = $this->standings->getSortedStandings();
        $expectedStandings = [
            ['Elephants', 3, 0, 6],
            ['Tigers', 0, 3, 0],
        ];

        // Then
        $this->assertSame($expectedStandings, $actualStandings);
    }
}
