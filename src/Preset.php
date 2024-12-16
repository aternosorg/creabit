<?php

namespace Aternos\Creabit;

use Aternos\Nbt\Tag\StringTag;

class Preset
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
        $preset = new static();
        $preset->setName($tag->getValue());
        return $preset;
    }

    /**
     * Constructor
     *
     * @param string $name
     * @return static
     */
    public static function new(string $name): static
    {
        $preset = new static();
        $preset->setName($name);
        return $preset;
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
}