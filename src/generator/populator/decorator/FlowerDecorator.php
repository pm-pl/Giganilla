<?php

namespace JonasWindmann\Giganilla\generator\populator\decorator;

use JonasWindmann\Giganilla\generator\populator\decorator\objects\Flower;
use JonasWindmann\Giganilla\GigaRandom;
use pocketmine\block\Block;
use pocketmine\world\ChunkManager;

class FlowerDecorator extends Decorator {
    private $decorations = [];

    public function setFlowers(array $decorations): void {
        $this->decorations = $decorations;
    }

    public function getRandomFlower(GigaRandom $random): ?Block {
        $totalWeight = array_sum(array_column($this->decorations, 0));

        $weight = $random->nextIntWithBound($totalWeight);
        foreach ($this->decorations as $deco) {
            $weight -= $deco[0];

            if ($weight < 0) {
                return $deco[1];
            }
        }

        return null;
    }

    public function decorate(ChunkManager $world, GigaRandom $random, int $chunkX, int $chunkZ): void {
        $chunk = $world->getChunk($chunkX, $chunkZ);

        $x = $random->nextIntWithBound(16);
        $z = $random->nextIntWithBound(16);
        $sourceY = $random->nextIntWithBound($chunk->getHighestBlockAt($x, $z) + 32);

        $species = $this->getRandomFlower($random);
        if ($species === null) {
            return;
        }

        (new Flower($species))->generate($world, $random, ($chunkX << 4) + $x, $sourceY, ($chunkZ << 4) + $z);
    }
}
