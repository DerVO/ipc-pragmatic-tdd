<?php
declare(strict_types=1);

namespace BallGame\Domain\Team;


use BallGame\Domain\Standings\TeamPosition;

class Team
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var TeamPosition
     */
    private $teamPosition;

    private function __construct(string $name)
    {
        $this->name = $name;
        $this->teamPosition = new TeamPosition($this);
    }

    public static function create(string $name)
    {
        return new self($name);
    }

    public function getName() {
        return $this->name;
    }

    public function __toString() {
        return $this->name;
    }

    public function getTeamPosition(): TeamPosition
    {
        return $this->teamPosition;
    }
}