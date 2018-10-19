<?php
declare(strict_types=1);

namespace BallGame\Tests\Domain\Standings;

use BallGame\Domain\Match\Match;
use BallGame\Domain\RuleBook\AdvancedRuleBook;
use BallGame\Domain\RuleBook\SimpleRuleBook;
use BallGame\Domain\Standings\Standings;
use BallGame\Domain\Team\Team;
use PHPUnit\Framework\TestCase;

class StandingsWithAdvancedRuleBookTest extends TestCase
{
    /**
     * @var Standings
     */
    protected $standings;

    public function setUp()
    {
        $ruleBook = new AdvancedRuleBook();
        $this->standings = new Standings($ruleBook);
    }

    public function testGetSortedStandingsWhenThereWereTwoMatchBetweenTwoTeamsAndSecondTeamHasMoreGoalsScored()
    {
        // Given
        $tigers = Team::create('Tigers');
        $elephants = Team::create('Elephants');

        $match = Match::create($tigers, $elephants, 2, 1);
        $this->standings->record($match);

        $match = Match::create($tigers, $elephants, 0, 10);
        $this->standings->record($match);

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
