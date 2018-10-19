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

class RecordTest extends TestCase
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

    public function testRecordActuallySavesAMatch()
    {
        $this->repository
            ->expects($this->exactly(1))
            ->method('save');

        $this->standings->record(Match::create(
            Team::create('Tigers'),
            Team::create('Elephants'),
            0,
            0
        ));
    }
}
