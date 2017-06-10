<?php
namespace Aliance\InfiniteBitmask\Tests;

use Aliance\InfiniteBitmask\InfiniteBitmask;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * Unit tests for infinite bitmask implementation.
 */
class InfiniteBitmaskTest extends TestCase
{
    /**
     * @dataProvider getBitsWithMaskSlicesPairs
     * @param int   $bit
     * @param int[] $expectedMask
     */
    public function testBits($bit, array $expectedMask)
    {
        $InfiniteBitmask = new InfiniteBitmask();

        $this->assertFalse($InfiniteBitmask->issetBit($bit));
        $this->assertEmpty($InfiniteBitmask->getMaskSlices());

        $InfiniteBitmask->setBit($bit);

        $this->assertTrue($InfiniteBitmask->issetBit($bit));
        $this->assertEquals($expectedMask, $InfiniteBitmask->getMaskSlices());

        $InfiniteBitmask->unsetBit($bit);

        $this->assertFalse($InfiniteBitmask->issetBit($bit));
        // TODO: mb unset whole key while only 0 mask present?
        //$this->assertEmpty($InfiniteBitmask->getMaskSlices());
    }

    /**
     * @dataProvider getBitsWithMaskSlicesPairs
     * @param int   $expectedBit
     * @param int[] $maskSlices
     */
    public function testGeneralUsage($expectedBit, array $maskSlices)
    {
        $InfiniteBitmask = new InfiniteBitmask($maskSlices);

        $this->assertTrue(
            $InfiniteBitmask->issetBit($expectedBit),
            sprintf('Bit #%d was not set as expected.', $expectedBit)
        );
    }

    /**
     * @return array
     */
    public function getBitsWithMaskSlicesPairs()
    {
        return [
            [
                0,
                [0 => 1], // 0 = 0/64, 1 = 2 ^ (0 % 64)
            ],
            [
                1,
                [0 => 2], // 0 = 1/64, 2 = 2 ^ (1 % 64)
            ],
            [
                2,
                [0 => 4], // 0 = 2/64, 4 = 2 ^ (2 % 64)
            ],
            [
                3,
                [0 => 8], // 0 = 3/64, 8 = 2 ^ (2 % 64)
            ],
            [
                33,
                [0 => 8589934592], // 0 = 33/64, 8589934592 = 2 ^ (33 % 64)
            ],
            [
                62,
                [0 => 4611686018427387904], // 0 = 62/64, 4611686018427387904 = 2 ^ (62 % 64)
            ],
            [
                64,
                [1 => 1], // 1 = 64/64, 1 = 2 ^ (64 % 64)
            ],
            [
                65,
                [1 => 2], // 1 = 65/64, 2 = 2 ^ (65 % 64)
            ],
            [
                2000,
                [31 => 65536], // 31 = 2000/64, 65536 = 2 ^ (2000 % 64)
            ],
            [
                10000,
                [156 => 65536], // 156 = 10000/64, 65536 = 2 ^ (10000 % 64)
            ],
            [
                1000000,
                [15625 => 1], // 15625 = 1000000/64, 1 = 2 ^ (1000000 % 64)
            ],
            [
                PHP_INT_MAX, // 9223372036854775807 for x64
                [144115188075855872 => -9223372036854775808], // 144115188075855872 = 9223372036854775807/64, -9223372036854775808 = 2 ^ (9223372036854775807 % 64)
            ],
        ];
    }
}
