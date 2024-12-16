<?php

namespace Aternos\Creabit;

use Aternos\Nbt\Tag\CompoundTag;
use Exception;

class WorldGenSettings
{
    protected Seed $seed;

    protected DimensionList $dimensionList;

    /**
     * @param CompoundTag $tag
     * @throws Exception
     */
    public function __construct(CompoundTag $tag)
    {
        $this->seed = new Seed($tag->getLong("seed")->getValue());
        $this->dimensionList = new DimensionList($tag->getCompound("dimensions"));
    }

    /**
     * @return DimensionList
     */
    public function getDimensionList(): DimensionList
    {
        return $this->dimensionList;
    }

    /**
     * @return Seed
     */
    public function getSeed(): Seed
    {
        return $this->seed;
    }

    /**
     * Creates "WorldGenSettings" tag
     *
     * @return CompoundTag
     * @throws Exception
     */
    public function createTag(): CompoundTag
    {
        $tag = new CompoundTag();
        $tag["seed"] = $this->seed->createTag();
        $tag["dimensions"] = $this->getDimensionList()->createTag();
        return $tag;
    }
}