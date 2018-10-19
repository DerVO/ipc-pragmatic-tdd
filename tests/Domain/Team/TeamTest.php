<?php
declare(strict_types=1);

namespace BallGame\Tests\Domain\Team;

use BallGame\Domain\Exception\BadTeamException;
use BallGame\Domain\Team\Team;
use PHPUnit\Framework\TestCase;

class TeamTest extends TestCase
{
    public function testCreateIsNotAllowedWhenTeamDoesNotHaveAName()
    {
        $this->expectException(BadTeamException::class);

        Team::create('');
    }
}
