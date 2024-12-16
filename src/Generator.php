<?php

namespace Aternos\Creabit;

use Aternos\Nbt\Tag\CompoundTag;
use Exception;
use Aternos\Creabit\Enums\BiomeSourceType;
use Aternos\Creabit\Enums\GeneratorType;
use Aternos\Creabit\Enums\SettingsType;

class Generator
{
    protected ?BiomeSource $biomeSource = null;

    protected ?Seed $seed = null;

    protected ?Settings $settings = null;

    protected ?Type $type = null;

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
        $generator = new static();
        $biomeSource = $tag->getCompound("biome_source");
        if ($biomeSource !== null) {
            $generator->biomeSource = BiomeSource::newFromTag($biomeSource);
        }

        $seed = $tag->getLong("seed");
        if ($seed !== null) {
            $generator->seed = new Seed($seed->getValue());
        }

        $settings = $tag->getString("settings");
        if ($settings !== null) {
            $generator->settings = Settings::newFromTag($settings);
        }

        $type = $tag->getString("type");
        if ($type !== null) {
            $generator->type = Type::newFromTag($type);
        }

        return $generator;
    }

    /**
     * Constructor
     *
     * @param GeneratorType $generatorType
     * @param SettingsType $settingsType
     * @param BiomeSourceType $biomeSourceType
     * @param Seed $seed
     * @param Preset|null $preset
     * @return static
     */
    public static function new(
        GeneratorType $generatorType,
        SettingsType $settingsType,
        BiomeSourceType $biomeSourceType,
        Seed $seed,
        Preset $preset = null
    ): static
    {
        $generator = new static();
        $generator->type = Type::newGeneratorType($generatorType);
        $generator->settings = Settings::new($settingsType);
        $generator->seed = $seed;
        if ($settingsType === SettingsType::NETHER) $seed = null;
        $generator->biomeSource = BiomeSource::new($biomeSourceType, $seed, $preset);
        return $generator;
    }

    /**
     * @return Seed|null
     */
    public function getSeed(): ?Seed
    {
        return $this->seed;
    }

    /**
     * @return BiomeSource|null
     */
    public function getBiomeSource(): ?BiomeSource
    {
        return $this->biomeSource;
    }

    /**
     * @return Type|null
     */
    public function getType(): ?Type
    {
        return $this->type;
    }

    /**
     * @return Settings|null
     */
    public function getSettings(): ?Settings
    {
        return $this->settings;
    }

    /**
     * Creates "generator" tag
     *
     * @return CompoundTag
     * @throws Exception
     */
    public function createTag(): CompoundTag
    {
        $tag = new CompoundTag();
        if ($this->getSeed() !== null) {
            $tag["seed"] = $this->getSeed()->createTag();
        }
        if ($this->getSettings() !== null) {
            $tag["settings"] = $this->getSettings()->createTag();
        }
        if ($this->getType() !== null) {
            $tag["type"] = $this->getType()->createTag();
        }
        if ($this->getBiomeSource() !== null) {
            $tag["biome_source"] = $this->getBiomeSource()->createTag();
        }
        return $tag;
    }
}