<?php
namespace Aliance\InfiniteBitmask;

use Aliance\Bitmask\Bitmask;

/**
 * Infinite bitmask implementation.
 */
class InfiniteBitmask
{
    /**
     * Mask slices list.
     * @var int[]
     */
    private $maskSlices = [];

    /**
     * @param int[] $maskSlices
     */
    public function __construct(array $maskSlices = [])
    {
        $this->maskSlices = $maskSlices;
    }

    /**
     * @return int[]
     */
    public function getMaskSlices()
    {
        return $this->maskSlices;
    }

    /**
     * @param int $bit
     * @return $this
     */
    public function setBit($bit)
    {
        $indexKey = $this->getBitIndex($bit);

        if (!isset($this->maskSlices[$indexKey])) {
            $this->maskSlices[$indexKey] = 0;
        }

        $Bitmask = Bitmask::create($this->maskSlices[$indexKey]);
        $Bitmask->setBit($this->getBitInSlice($bit));
        $this->maskSlices[$indexKey] = $Bitmask->getMask();

        return $this;
    }

    /**
     * Returns bit index at bitmask slice.
     * For example, if we store [0;63] bits:
     * - bits [  0; 63] will be at index 0;
     * - bits [ 64;127] will be at index 1;
     * - bits [128;191] will be at index 2;
     * @param int $bit
     * @return int
     */
    protected function getBitIndex($bit)
    {
        return (int)($bit / (Bitmask::MAX_BIT + 1));
    }

    /**
     * Return bit representation in current bitmask slice.
     * For example:
     * - bit   0 will be  0 bit at slice #0;
     * - bit   5 will be  5 bit at slice #0;
     * - bit  63 will be 63 bit at slice #0;
     * - bit  64 will be  0 bit at slice #1;
     * - bit  69 will be  5 bit at slice #1;
     * - bit 128 will be  0 bit at slice #2;
     * @param int $bit
     * @return int
     */
    protected function getBitInSlice($bit)
    {
        return $bit % (Bitmask::MAX_BIT + 1);
    }

    /**
     * @param int $bit
     * @return bool
     */
    public function issetBit($bit)
    {
        $indexKey = $this->getBitIndex($bit);

        if (!isset($this->maskSlices[$indexKey])) {
            return false;
        }

        return Bitmask::create($this->maskSlices[$indexKey])->issetBit($this->getBitInSlice($bit));
    }

    /**
     * @param int $bit
     * @return $this
     */
    public function unsetBit($bit)
    {
        $indexKey = $this->getBitIndex($bit);

        if (isset($this->maskSlices[$indexKey])) {
            $Bitmask = Bitmask::create($this->maskSlices[$indexKey]);
            $Bitmask->unsetBit($this->getBitInSlice($bit));
            $this->maskSlices[$indexKey] = $Bitmask->getMask();
        }

        return $this;
    }
}
