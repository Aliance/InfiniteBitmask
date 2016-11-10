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
     * @throws \InvalidArgumentException
     */
    public function __construct(array $maskSlices = [])
    {
        if (!is_array($maskSlices)) {
            throw new \InvalidArgumentException('Passed invalid argument: ' . gettype($maskSlices));
        }

        $this->maskSlices = $maskSlices;
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
     * For example, if we store [0;62] bits:
     * - bits [  0; 62] will be at index 0;
     * - bits [ 63;125] will be at index 1;
     * - bits [126;188] will be at index 2;
     * @param int $bit
     * @return int
     */
    protected function getBitIndex($bit)
    {
        return (int)($bit / Bitmask::MAX_BIT + 1);
    }

    /**
     * Return bit representation in current bitmask slice.
     * For example:
     * - bit   0 will be  0 bit at slice #0;
     * - bit   5 will be  5 bit at slice #0;
     * - bit  62 will be 62 bit at slice #0;
     * - bit  63 will be  0 bit at slice #1;
     * - bit  68 will be  5 bit at slice #1;
     * - bit 126 will be  0 bit at slice #2;
     * @param int $bit
     * @return int
     */
    protected function getBitInSlice($bit)
    {
        return $bit % Bitmask::MAX_BIT + 1;
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
