<?php
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
                [0 => 1], // 0 = 0/63, 1 = 2 ^ (0 % 63)
            ],
            [
                1,
                [0 => 2], // 0 = 1/63, 2 = 2 ^ (1 % 63)
            ],
            [
                2,
                [0 => 4], // 0 = 2/63, 4 = 2 ^ (2 % 63)
            ],
            [
                3,
                [0 => 8], // 0 = 3/63, 8 = 2 ^ (2 % 63)
            ],
            [
                33,
                [0 => 8589934592], // 0 = 33/63, 8589934592 = 2 ^ (33 % 63)
            ],
            [
                62,
                [0 => 4611686018427387904], // 0 = 62/63, 4611686018427387904 = 2 ^ (62 % 63)
            ],
            [
                63,
                [1 => 1], // 1 = 63/63, 1 = 2 ^ (63 % 63)
            ],
            [
                64,
                [1 => 2], // 1 = 64/63, 2 = 2 ^ (64 % 63)
            ],
            [
                2000,
                [31 => 140737488355328], // 31 = 2000/63, 140737488355328 = 2 ^ (2000 % 63)
            ],
            [
                10000,
                [158 => 70368744177664], // 158 = 10000/63, 70368744177664 = 2 ^ (10000 % 63)
            ],
            [
                1000000,
                [15873 => 2], // 15873 = 1000000/63, 2 = 2 ^ (1000000 % 63)
            ],
            [
                PHP_INT_MAX, // 9223372036854775807 for x64
                [146402730743726592 => 128], // 146402730743726592 = 9223372036854775807/63, 128 = 2 ^ (9223372036854775807 % 63)
            ],
        ];
    }
}
