<?php
declare(strict_types=1);


namespace BallGame\Domain\Team;


use BallGame\Domain\Exception\BadTeamException;

class Team
{
    /**
     * @var string
     */
    private $name;

    private function __construct(string $name)
    {
        if (empty(trim($name))) {
            throw new BadTeamException();
        }
        $this->name = $name;
    }

    public static function create(string $name)
    {
        return new self($name);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
