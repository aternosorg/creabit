<?php

namespace Aternos\Creabit;

use Aternos\Nbt\Tag\CompoundTag;
use Aternos\Nbt\Tag\StringTag;
use Exception;
use Aternos\Creabit\Enums\BiomeSourceType;

class BiomeSource
{
    protected ?Preset $preset;

    protected Seed $seed;

    protected Type $type;

    /**
     * Overloaded
     */
    protected function __construct()
    {
    }

    /**
     * Constructor
     *
     * @param CompoundTag $tag
     * @return static
     */
    public static function newFromTag(CompoundTag $tag): static
    {
        $biomeSource = new static();
        $biomeSource->type = Type::newFromTag($tag->getString("type"));

        $presetString = $tag->getString("preset");
        $biomeSource->preset = $presetString ? Preset::newFromTag($presetString) : null;

        $seed = $tag->getLong("seed");
        if ($seed !== null) {
            $biomeSource->seed = new Seed($seed->getValue());
        }

        return $biomeSource;
    }

    /**
     * Constructor
     *
     * @param BiomeSourceType $type
     * @param Seed|null $seed
     * @param Preset|null $preset
     * @return static
     */
    public static function new(BiomeSourceType $type, Seed $seed = null, Preset $preset = null): static
    {
        $biomeSource = new static();
        $biomeSource->type = Type::newBiomeSourceType($type);
        if ($seed !== null) {
            $biomeSource->seed = $seed;
        }
        if ($preset !== null) {
            $biomeSource->preset = $preset;
        }
        return $biomeSource;
    }

    /**
     * @return Preset|null
     */
    public function getPreset(): ?Preset
    {
        return $this->preset;
    }

    /**
     * @return Type
     */
    public function getType(): Type
    {
        return $this->type;
    }

    /**
     * @return Seed
     */
    public function getSeed(): Seed
    {
        return $this->seed;
    }

    /**
     * Creates "biome_source" tag
     *
     * @return CompoundTag
     * @throws Exception
     */
    public function createTag(): CompoundTag
    {
        $tag = new CompoundTag();
        $tag["type"] = $this->getType()->createTag();
        if (isset($this->seed)) {
            $tag["seed"] = $this->getSeed()->createTag();
        }
        if (isset($this->preset)) {
            $tag["preset"] = (new StringTag())->setValue($this->getPreset()->getName());
        }
        return $tag;
    }
}