<?php
declare(strict_types=1);

namespace BallGame\Tests\Domain\Standings;

use BallGame\Domain\Match\Match;
use BallGame\Domain\RuleBook\SimpleRuleBook;
use BallGame\Domain\Standings\Standings;
use BallGame\Domain\Team\Team;
use BallGame\Infrastructure\MatchRepository;
use PHPUnit\Framework\TestCase;

class StandingsWithSimpleRulebookTest extends TestCase
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
        $rulebook = new SimpleRuleBook();

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
            // Name, Goals Scores, Goals Agains, Points, Total Games, Games Won, Games Tied, Games Lost
            ['Tigers', 2, 1, 3, 1, 1, 0, 0],
            ['Elephants', 1, 2, 0, 1, 0, 0, 1],
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
            // Name, Goals Scores, Goals Agains, Points, Total Games, Games Won, Games Tied, Games Lost
            ['Elephants', 1, 0, 3, 1, 1, 0, 0],
            ['Tigers', 0, 1, 0, 1, 0, 0, 1],
        ];

        // Then
        $this->assertSame($expectedStandings, $actualStandings);
    }
}
