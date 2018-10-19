<?php
declare(strict_types=1);

namespace BallGame\Tests\Domain\Standings;

use BallGame\Domain\Match\Match;
use BallGame\Domain\RuleBook\SimpleRuleBook;
use BallGame\Domain\Standings\Standings;
use BallGame\Domain\Team\Team;
use BallGame\Infrastructure\MatchRepository;
use PHPUnit\Framework\TestCase;

class StandingsWithSimpleRuleBookTest extends TestCase
{
    /**
     * @var Standings
     */
    protected $standings;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|MatchRepository
     */
    protected $repository;

    public function setUp()
    {
        $ruleBook = new SimpleRuleBook();
        $this->repository = $this->getMockBuilder(MatchRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->standings = new Standings($ruleBook, $this->repository);
    }

    public function testGetSortedStandingsWhenThereWasAMatchBetweenTwoTeams()
    {
        // Given
        $tigers = Team::create('Tigers');
        $elephants = Team::create('Elephants');

        $this->repository
            ->method('findAll')
            ->willReturn([
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

        $this->repository
            ->method('findAll')
            ->willReturn([
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

    public function testGetSortedStandingsCanBeWeirdWithManyTeams()
    {
        $tigers = Team::create('Tigers');
        $elephants = Team::create('Elephants');

        $this->repository
            ->method('findAll')
            ->willReturn([
                Match::create($tigers, $elephants, 0, 1),
                Match::create($tigers, $elephants, 0, 2),
            ]);

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
