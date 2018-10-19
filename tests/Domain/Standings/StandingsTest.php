<?php
declare(strict_types=1);

namespace BallGame\Tests\Domain\Standings;

use BallGame\Domain\Standings\Standings;
use BallGame\Domain\Team\Team;
use BallGame\Domain\Match\Match;
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

    public function testGetSortedStandingsWhenThereWereSomeMatches()
    {
        // Given
        $tigers = Team::create('Tigers');
        $elephants = Team::create('Elephants');
        $snakes = Team::create('Snakes');

        $this->standings->record(Match::create($tigers, $elephants, 2, 1));
        $this->standings->record(Match::create($tigers, $snakes, 4, 1));
        $this->standings->record(Match::create($elephants, $snakes, 0, 0));

        $this->standings->record(Match::create($elephants, $tigers, 3, 1));
        $this->standings->record(Match::create($snakes, $tigers, 2, 0));
        $this->standings->record(Match::create($snakes, $elephants, 0, 1));

        // When
        $actualStandings = $this->standings->getSortedStandings();
        $expectedStandings = [
            ['Elephants', 5, 3, 7],
            ['Tigers', 7, 7, 6],
            ['Snakes', 3, 5, 4],
        ];

        // Then
        $this->assertSame($expectedStandings, $actualStandings);
    }

}
