<?php
declare(strict_types=1);

namespace BallGame\Tests;

use BallGame\GetTheBallRolling;
use PHPUnit\Framework\TestCase;

class GetTheBallRollingTest extends TestCase
{
    private $ball;

    public function setUp() {
        $this->ball = GetTheBallRolling::create('Hello');
    }

    public function testGetNameReturnsCreatedName()
    {
        $this->assertSame('Hello', $this->ball->getName());
    }

    public function testBinaryGapReturnsTwoThenInTheMiddle() {
        // 1001
        $n = 9;

        $expectedBinaryGap = 2;
        $actualBinaryGap = $this->ball->getBinaryGap($n);

        $this->assertSame($expectedBinaryGap, $actualBinaryGap);
    }

    /*
    public function testBinaryGapCheckForPositiveInt() {
        $ball = GetTheBallRolling::create('binary');

        $ball->binaryGap(0);

        $ball->binaryGap(-1);


        $ball->binaryGap('foo');
    }*/
}
