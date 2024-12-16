<?php

namespace Aternos\Creabit;

use Aternos\Nbt\Tag\StringTag;
use Exception;
use Aternos\Creabit\Enums\BiomeSourceType;
use Aternos\Creabit\Enums\DimensionType;
use Aternos\Creabit\Enums\GeneratorType;

class Type
{
    protected string $name;

    /**
     * Overloaded
     */
    protected function __construct()
    {
    }

    /**
     * Constructor
     *
     * @param StringTag $tag
     * @return static
     */
    public static function newFromTag(StringTag $tag): static
    {
        $type = new static();
        $type->setName($tag->getValue());
        return $type;
    }

    /**
     * Constructor Dimension
     *
     * @param DimensionType $dimensionType
     * @return static
     */
    public static function newDimensionType(DimensionType $dimensionType): static
    {
        $type = new static();
        $type->setName($dimensionType->value);
        return $type;
    }

    /**
     * Constructor Generator
     *
     * @param GeneratorType $generatorType
     * @return static
     */
    public static function newGeneratorType(GeneratorType $generatorType): static
    {
        $type = new static();
        $type->setName($generatorType->value);
        return $type;
    }

    /**
     * Constructor BiomeSource
     *
     * @param BiomeSourceType $biomeSourceType
     * @return static
     */
    public static function newBiomeSourceType(BiomeSourceType $biomeSourceType): static
    {
        $type = new static();
        $type->setName($biomeSourceType->value);
        return $type;
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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Creates "type" tag
     *
     * @return StringTag
     */
    public function createTag(): StringTag
    {
        $tag = new StringTag();
        $tag->setValue($this->getName());
        return $tag;
    }
}