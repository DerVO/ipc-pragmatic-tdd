<?php
declare(strict_types=1);

namespace BallGame\Tests\Domain\Match;

use BallGame\Domain\Exception\BadMatchException;
use BallGame\Domain\Match\Match;
use BallGame\Domain\Team\Team;
use PHPUnit\Framework\TestCase;

class MatchTest extends TestCase
{
    public function testCreateMatchIsNotAllowedWhenTeamsHaveSameName()
    {
        $this->expectException(BadMatchException::class);

        Match::create(
            Team::create('Name'),
            Team::create('Name'),
            0,
            0
        );
    }
}
