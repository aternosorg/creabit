<?php

namespace Aternos\Creabit;

use Aternos\Nbt\IO\Reader\GZipCompressedStringReader;
use Aternos\Nbt\IO\Writer\GZipCompressedStringWriter;
use Aternos\Nbt\NbtFormat;
use Aternos\Nbt\Tag\CompoundTag;
use Aternos\Nbt\Tag\Tag;
use Exception;
use Aternos\Creabit\Enums\DimensionName;
use Aternos\Creabit\Enums\DimensionType;


class Creabit
{
    protected CompoundTag $rootTag;

    protected Data $data;

    /**
     * @param string $fileContent
     * @throws Exception
     */
    public function __construct(string $fileContent)
    {
        $reader = new GZipCompressedStringReader($fileContent, NbtFormat::JAVA_EDITION);
        $tag = Tag::load($reader);
        if (!($tag instanceof CompoundTag)) {
            throw new Exception("Wrong tag type");
        }
        $this->rootTag = $tag;
        $this->data = new Data($this->rootTag->getCompound("Data"));
    }

    /**
     * @return void
     * @throws Exception
     */
    protected function updateDimensionsTag(): void
    {
        $this->rootTag->getCompound("Data")
            ->getCompound("WorldGenSettings")
            ->set("dimensions", $this->data->getWorldGenSettings()->getDimensionList()->createTag());
    }

    /**
     * @param DimensionType $type
     * @return Dimension|null
     */
    public function getDimensionByType(DimensionType $type): ?Dimension
    {
        return $this->data->getWorldGenSettings()->getDimensionList()->getDimensionByType($type);
    }


    /**
     * @param DimensionName $name
     * @return Dimension|null
     */
    public function getDimensionByName(DimensionName $name): ?Dimension
    {
        return $this->data->getWorldGenSettings()->getDimensionList()->getDimensionByName($name);
    }

    /**
     * @param DimensionName $name
     * @return bool
     */
    public function hasDimension(DimensionName $name): bool
    {
        return $this->data->getWorldGenSettings()->getDimensionList()->hasDimension($name);
    }

    /**
     * @return Dimension[]
     */
    public function getDimensions(): array
    {
        return $this->data->getWorldGenSettings()->getDimensionList()->getDimensions();
    }

    /**
     * @param Dimension $dimension
     * @return void
     */
    public function addDimension(Dimension $dimension): void
    {
        $this->data->getWorldGenSettings()->getDimensionList()->addDimension($dimension);
    }

    /**
     * @return string
     * @throws Exception
     */
    public function repair(): string
    {
        if ($this->hasDimension(DimensionName::NETHER) && $this->hasDimension(DimensionName::END)){
            throw new Exception("nothing to do here");
        }
        if (!$this->hasDimension(DimensionName::NETHER)) {
            $this->addDimension(Dimension::newNether($this->data->getWorldGenSettings()->getSeed()));
        }
        if (!$this->hasDimension(DimensionName::END)) {
            $this->addDimension(Dimension::newEnd($this->data->getWorldGenSettings()->getSeed()));
        }
        $this->updateDimensionsTag();
        $writer = (new GZipCompressedStringWriter())->setFormat(NbtFormat::JAVA_EDITION);
        $this->rootTag->write($writer);
        return $writer->getStringData();
    }
}
