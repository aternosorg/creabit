<?php

namespace Aternos\Creabit\Enums;

enum DimensionType: string
{
    case OVERWORLD = "minecraft:overworld";
    case OVERWORLD_CAVES = "minecraft:overworld_caves";
    case NETHER = "minecraft:the_nether";
    case END = "minecraft:the_end";
}