<?php
declare(strict_types=1);

namespace BallGame\Tests\Domain\Standings;

use BallGame\Domain\Match\Match;
use BallGame\Domain\RuleBook\AdvancedRuleBook;
use BallGame\Domain\RuleBook\SimpleRuleBook;
use BallGame\Domain\Standings\Standings;
use BallGame\Domain\Team\Team;
use BallGame\Infrastructure\MatchRepository;
use PHPUnit\Framework\TestCase;

class StandingsWithAdvancedRuleBookTest extends TestCase
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
        $ruleBook = new AdvancedRuleBook();
        $this->repository = $this->getMockBuilder(MatchRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->standings = new Standings($ruleBook, $this->repository);
    }

    public function testGetSortedStandingsWhenThereWereTwoMatchBetweenTwoTeamsAndSecondTeamHasMoreGoalsScored()
    {
        // Given
        $tigers = Team::create('Tigers');
        $elephants = Team::create('Elephants');

        $this->repository
            ->method('findAll')
            ->willReturn([
                Match::create($tigers, $elephants, 2, 1),
                Match::create($tigers, $elephants, 0, 10),
            ]);

        // When
        $actualStandings = $this->standings->getSortedStandings();
        $expectedStandings = [
            ['Elephants', 11, 2, 3],
            ['Tigers', 2, 11, 3],
        ];

        // Then
        $this->assertSame($expectedStandings, $actualStandings);
    }
}
