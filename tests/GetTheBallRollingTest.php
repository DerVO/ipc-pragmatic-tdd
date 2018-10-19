<?php
declare(strict_types=1);

namespace BallGame\Tests;

use BallGame\GetTheBallRolling;
use PHPUnit\Framework\TestCase;

class GetTheBallRollingTest extends TestCase
{
    /**
     * @var GetTheBallRolling
     */
    protected $ball;

    public function setUp()
    {
        $this->ball = GetTheBallRolling::create('Hello');
    }

    public function testGetNameReturnsCreatedName()
    {
        $this->assertSame('Hello', $this->ball->getName());
    }

    public function testGetBinaryGapReturnsTwoWhenInMiddle()
    {
        // 1001
        $number = 9;

        $expectedBinaryGap = 2;
        $actualBinaryGap = $this->ball->getBinaryGap($number);

        $this->assertSame($expectedBinaryGap, $actualBinaryGap);
    }

    public function testBinaryGapReturnsZeroWhenThereIsNoBinaryGap()
    {
        // 1100
        $number = 12;

        $expectedBinaryGap = 0;
        $actualBinaryGap = $this->ball->getBinaryGap($number);

        $this->assertSame($expectedBinaryGap, $actualBinaryGap);
    }

    public function testBinaryGapReturnsBiggerOneWhenThereAreTwoGaps()
    {
        // 100001001
        $number = 529;

        $expectedBinaryGap = 4;
        $actualBinaryGap = $this->ball->getBinaryGap($number);

        $this->assertSame($expectedBinaryGap, $actualBinaryGap);
    }
}
