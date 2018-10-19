<?php
declare(strict_types=1);

namespace BallGame\Tests\Domain\Standings;

use BallGame\Domain\Match\Match;
use BallGame\Domain\RuleBook\SimpleRuleBook;
use BallGame\Domain\Standings\Standings;
use BallGame\Domain\Team\Team;
use BallGame\Infrastructure\MatchRepository;
use PHPUnit\Framework\TestCase;

class StandingsTest extends TestCase
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

    public function testRecordActuallySavedAMatch()
    {
        $this->repository_mock->expects($this->exactly(1))->method('save');

        $this->standings->record(Match::create(
            Team::create('Team A'),
            Team::create('Team B'),
            0,
            0
        ));
    }
}
