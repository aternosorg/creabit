<?php

namespace Aternos\Creabit;

use Aternos\Nbt\Tag\CompoundTag;
use Exception;

class Data
{
    protected WorldGenSettings $worldGenSettings;

    /**
     * @param CompoundTag $tag
     * @throws Exception
     */
    public function __construct(CompoundTag $tag)
    {
        $this->worldGenSettings = new WorldGenSettings($tag->getCompound("WorldGenSettings"));
    }

    /**
     * @return WorldGenSettings
     */
    public function getWorldGenSettings(): WorldGenSettings
    {
        return $this->worldGenSettings;
    }

    /**
     * Creates "Data" tag
     *
     * @return CompoundTag
     * @throws Exception
     */
    public function createTag(): CompoundTag
    {
        $tag = new CompoundTag();
        $tag["WorldGenSettings"] = $this->getWorldGenSettings()->createTag();
        return $tag;
    }
}