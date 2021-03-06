<?php

declare(strict_types=1);

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
    private array $maskSlices;

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
    public function getMaskSlices(): array
    {
        return $this->maskSlices;
    }

    public function setBit(int $bit): self
    {
        $indexKey = $this->getBitIndex($bit);

        if (!isset($this->maskSlices[$indexKey])) {
            $this->maskSlices[$indexKey] = 0;
        }

        $Bitmask = new Bitmask($this->maskSlices[$indexKey]);
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
     */
    protected function getBitIndex(int $bit): int
    {
        return (int)($bit / (PHP_INT_SIZE * 8));
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
     */
    protected function getBitInSlice(int $bit): int
    {
        return $bit % (PHP_INT_SIZE * 8);
    }

    public function issetBit(int $bit): bool
    {
        $indexKey = $this->getBitIndex($bit);

        if (!isset($this->maskSlices[$indexKey])) {
            return false;
        }

        return (new Bitmask($this->maskSlices[$indexKey]))->issetBit($this->getBitInSlice($bit));
    }

    public function unsetBit(int $bit): self
    {
        $indexKey = $this->getBitIndex($bit);

        if (isset($this->maskSlices[$indexKey])) {
            $Bitmask = new Bitmask($this->maskSlices[$indexKey]);
            $Bitmask->unsetBit($this->getBitInSlice($bit));
            $this->maskSlices[$indexKey] = $Bitmask->getMask();
        }

        return $this;
    }
}
