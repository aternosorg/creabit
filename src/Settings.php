<?php

namespace Aternos\Creabit;

use Aternos\Nbt\Tag\StringTag;
use Exception;
use Aternos\Creabit\Enums\SettingsType;

class Settings
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
        $settings = new static();
        $settings->name = $tag->getValue();
        return $settings;
    }

    /**
     * Constructor
     *
     * @param SettingsType $type
     * @return static
     */
    public static function new(SettingsType $type): static
    {
        $settings = new static();
        $settings->name = $type->value;
        return $settings;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Creates "settings" tag
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