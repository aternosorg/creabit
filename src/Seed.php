<?php

namespace Aternos\Creabit;

use Aternos\Nbt\Tag\LongTag;
use Exception;

class Seed
{
    protected int $seed;

    /**
     * @param int $seed
     */
    public function __construct(int $seed)
    {
        $this->seed = $seed;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->seed;
    }

    /**
     * Creates "seed" tag
     *
     * @return LongTag
     * @throws Exception
     */
    public function createTag():LongTag
    {
        if($this->getValue() === null) {
            throw new Exception("seed is null");
        }
        $tag = new LongTag();
        $tag->setValue($this->seed);
        return $tag;
    }
}