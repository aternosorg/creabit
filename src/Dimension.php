<?php

namespace Aternos\Creabit;

use Aternos\Nbt\Tag\CompoundTag;
use Exception;
use Aternos\Creabit\Enums\BiomeSourceType;
use Aternos\Creabit\Enums\DimensionType;
use Aternos\Creabit\Enums\GeneratorType;
use Aternos\Creabit\Enums\SettingsType;

class Dimension
{
    protected string $name;

    protected ?Type $type = null;

    protected ?Generator $generator = null;

    /**
     * Overloaded
     */
    protected function __construct()
    {
    }

    /**
     * Constructor
     *
     * @param string $name
     * @param DimensionType $dimensionType
     * @param GeneratorType $generatorType
     * @param SettingsType $settingsType
     * @param BiomeSourceType $biomeSourceType
     * @param Seed $seed
     * @param Preset|null $preset
     * @return static
     */
    public static function new(
        string          $name,
        DimensionType   $dimensionType,
        GeneratorType   $generatorType,
        SettingsType    $settingsType,
        BiomeSourceType $biomeSourceType,
        Seed            $seed,
        Preset          $preset = null
    ): Dimension
    {
        $dimension = new static();
        $dimension->setName($name);
        $dimension->setGenerator(
            Generator::new(
                $generatorType,
                $settingsType,
                $biomeSourceType,
                $seed,
                $preset
            )
        );
        $dimension->setType(Type::newDimensionType($dimensionType));
        return $dimension;
    }

    /**
     * Constructor
     *
     * @param string $name
     * @param CompoundTag $tag
     * @return static
     */
    public static function newFromTag(string $name, CompoundTag $tag): static
    {
        $dimension = new static();
        $dimension->name = $name;
        $generatorTag = $tag->getCompound("generator");
        if ($generatorTag !== null) {
            $dimension->generator = Generator::newFromTag($generatorTag);
        }
        $typeTag = $tag->getString("type");
        if ($typeTag !== null) {
            $dimension->type = Type::newFromTag($typeTag);
        }
        return $dimension;
    }

    /**
     * Constructor Nether
     *
     * @param $seed
     * @return static
     */
    public static function newNether($seed): static
    {
        return static::new(
            DimensionType::NETHER->value,
            DimensionType::NETHER,
            GeneratorType::NOISE,
            SettingsType::NETHER,
            BiomeSourceType::MULTI_NOISE,
            $seed,
            preset: Preset::new("minecraft:nether")
        );
    }

    /**
     * Constructor End
     *
     * @param Seed $seed
     * @return static
     */
    public static function newEnd(Seed $seed): static
    {
        return static::new(
            DimensionType::END->value,
            DimensionType::END,
            GeneratorType::NOISE,
            SettingsType::END,
            BiomeSourceType::END,
            $seed
        );
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return Type|null
     */
    public function getType(): ?Type
    {
        return $this->type;
    }

    /**
     * @param Type $type
     * @return void
     */
    public function setType(Type $type): void
    {
        $this->type = $type;
    }

    /**
     * @return Generator|null
     */
    public function getGenerator(): ?Generator
    {
        return $this->generator;
    }

    /**
     * @param Generator $generator
     * @return void
     */
    public function setGenerator(Generator $generator): void
    {
        $this->generator = $generator;
    }

    /**
     * @return Seed
     */
    public function getSeed(): Seed
    {
        return $this->generator->getSeed();
    }

    /**
     * Creates "dimension" tag
     *
     * @return CompoundTag
     * @throws Exception
     */
    public function createTag(): CompoundTag
    {
        $tag = new CompoundTag();
        if ($this->getGenerator() !== null) {
            $tag["generator"] = $this->getGenerator()->createTag();
        }
        if ($this->getType() !== null) {
            $tag["type"] = $this->getType()->createTag();
        }
        return $tag;
    }
}