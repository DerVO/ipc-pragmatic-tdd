<?php
declare(strict_types=1);

namespace BallGame\Tests\Domain\Standings;

use BallGame\Domain\Match\Match;
use BallGame\Domain\RuleBook\AdvancedRuleBook;
use BallGame\Domain\Standings\Standings;
use BallGame\Domain\Team\Team;
use BallGame\Infrastructure\MatchRepository;
use PHPUnit\Framework\TestCase;

class StandingsWithAdvancedRulebookTest extends TestCase
{
    /**
     * @var Standings
     */
    protected $standings;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|MatchRepository
     */
    private $repository_mock;

    public function setUp()
    {
        $rulebook = new AdvancedRuleBook();

        $this->repository_mock = $this->getMockBuilder(MatchRepository::class)
            ->disableOriginalConstructor()->getMock();

        $this->standings = new Standings($rulebook, $this->repository_mock);
    }

    public function testGetSortedStandingsWhenThereWasAMatchBetweenTwoTeams()
    {
        // Given
        $tigers = Team::create('Tigers');
        $elephants = Team::create('Elephants');

        $this->repository_mock->method('findAll')->willReturn([
            Match::create($tigers, $elephants, 2, 1),
        ]);

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

        $this->repository_mock->method('findAll')->willReturn([
            Match::create($tigers, $elephants, 0, 1),
        ]);

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

        $this->repository_mock->method('findAll')->willReturn([
            Match::create($tigers, $elephants, 2, 0),
            Match::create($tigers, $snakes, 2, 1),
            Match::create($tigers, $lions, 0, 1),
            Match::create($elephants, $snakes, 0, 1),
            Match::create($elephants, $lions, 1, 2),
            Match::create($snakes, $lions, 3, 1),
        ]);

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
