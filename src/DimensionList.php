<?php

namespace Aternos\Creabit;

use Aternos\Nbt\Tag\CompoundTag;
use Exception;
use Aternos\Creabit\Enums\DimensionName;
use Aternos\Creabit\Enums\DimensionType;

class DimensionList
{
    /**
     * @var Dimension[]
     */
    protected array $dimensions;

    /**
     * @param CompoundTag $tag
     */
    public function __construct(CompoundTag $tag)
    {
        foreach ($tag as $tagName => $tagValue) {
            $dimension = Dimension::newFromTag($tagName, $tagValue);
            $this->dimensions[$tagName] = $dimension;
        }
    }

    /**
     * @param DimensionName $name
     * @return bool
     */
    public function hasDimension(DimensionName $name): bool
    {
        return isset($this->dimensions[$name->value]);
    }

    /**
     * @param Dimension $dimension
     * @return void
     */
    public function addDimension(Dimension $dimension): void
    {
        $this->dimensions[] = $dimension;
    }

    /**
     * @return Dimension[]
     */
    public function getDimensions(): array
    {
        return $this->dimensions;
    }

    /**
     * @param DimensionType $type
     * @return Dimension|null
     */
    public function getDimensionByType(DimensionType $type): ?Dimension
    {
        foreach ($this->getDimensions() as $dimension) {
            if ($dimension->getType()->getName() === $type->value) {
                return $dimension;
            }
        }
        return null;
    }

    /**
     * @param DimensionName $name
     * @return Dimension|null
     */
    public function getDimensionByName(DimensionName $name): ?Dimension
    {
        return $this->getDimensions()[$name->value] ?? null;
    }

    /**
     * Creates "dimensions" tag
     *
     * @return CompoundTag
     * @throws Exception
     */
    public function createTag(): CompoundTag
    {
        $tag = new CompoundTag();
        foreach ($this->getDimensions() as $dimension) {
            $tag[$dimension->getName()] = $dimension->createTag();
        }
        return $tag;
    }
}