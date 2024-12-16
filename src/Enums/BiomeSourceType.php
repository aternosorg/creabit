<?php

namespace Aternos\Creabit\Enums;

enum BiomeSourceType: string
{
    case MULTI_NOISE = "minecraft:multi_noise";
    case FIXED = "minecraft:fixed";
    case CHECKERBOARD = "minecraft:checkerboard";
    case END = "minecraft:the_end";
}