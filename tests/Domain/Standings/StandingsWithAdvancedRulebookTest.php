<?php
declare(strict_types=1);

namespace BallGame\Tests\Domain\Standings;

use BallGame\Domain\Match\Match;
use BallGame\Domain\RuleBook\AdvancedRuleBook;
use BallGame\Domain\Standings\Standings;
use BallGame\Domain\Team\Team;
use PHPUnit\Framework\TestCase;

class StandingsWithAdvancedRulebookTest extends TestCase
{
    /**
     * @var Standings
     */
    protected $standings;

    public function setUp()
    {
        $rulebook = new AdvancedRuleBook();
        $this->standings = new Standings($rulebook);
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

    public function testGetSortedStandingsWhenWithComplexTiebrakers()
    {
        // Given
        $tigers = Team::create('Tigers');
        $elephants = Team::create('Elephants');
        $snakes = Team::create('Snakes');
        $lions = Team::create('Lions');

        $this->standings->record(Match::create($tigers, $elephants, 2, 0));
        $this->standings->record(Match::create($tigers, $snakes, 2, 1));
        $this->standings->record(Match::create($tigers, $lions, 0, 1));
        $this->standings->record(Match::create($elephants, $snakes, 0, 1));
        $this->standings->record(Match::create($elephants, $lions, 1, 2));
        $this->standings->record(Match::create($snakes, $lions, 3, 1));

        // When
        $actualStandings = $this->standings->getSortedStandings();
        $expectedStandings = [
            ['Snakes',      5, 3, 6], # +2, 5 scored
            ['Tigers',      4, 2, 6], # +2, 4 scored
            ['Lions',       4, 4, 6], # +0
            ['Elephants',   1, 5, 0],
        ];

        // Then
        $this->assertSame($expectedStandings, $actualStandings);
    }

}
