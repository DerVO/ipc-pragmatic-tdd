<?php
declare(strict_types=1);

namespace BallGame\Tests\Domain\Match;

use BallGame\Domain\Exception\BadMatchException;
use BallGame\Domain\Match\Match;
use BallGame\Domain\Team\Team;
use PHPUnit\Framework\TestCase;

class MatchTest extends TestCase
{
    public function testMatchBetweenSameTeamThrowsException()
    {
        $this->expectException(BadMatchException::class);
        Match::create(Team::create('foo'), Team::create('foo'), 1, 2);
    }
}
