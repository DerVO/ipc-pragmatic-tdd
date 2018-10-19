<?php
declare(strict_types=1);

namespace BallGame\Tests\Domain\Standings;

use BallGame\Domain\Match\Match;
use BallGame\Domain\RuleBook\SimpleRuleBook;
use BallGame\Domain\Standings\Standings;
use BallGame\Domain\Team\Team;
use BallGame\Infrastructure\MatchRepository;
use PHPUnit\Framework\TestCase;

class StandingsWithRepositoryTest extends TestCase
{
    /**
     * @var Standings
     */
    protected $standings;

    public function setUp()
    {
        $ruleBook = new SimpleRuleBook();
        $repository = new MatchRepository();

        $this->standings = new Standings($ruleBook, $repository);
    }

    /**
     * @group integration
     */
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
            ['Tigers', 1, 2, 1, 3],
            ['Elephants', 0, 1, 2, 0],
        ];

        // Then
        $this->assertSame($expectedStandings, $actualStandings);
    }
}
