<?php

declare(strict_types=1);

namespace JonasWindmann\Giganilla;

use JonasWindmann\Giganilla\command\GiganillaCommand;
use JonasWindmann\Giganilla\dev\PerformanceServer;
use JonasWindmann\Giganilla\generator\Giganilla;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\world\generator\GeneratorManager;

class Main extends PluginBase{

    // Something that i just lerned, bc i had a lot off time to do so
    // BlockTypeIds are just the basic form of a block (could be a closed and at the same time open door)
    // BlockStateIds are the complete full representation of a block (closed door, open door, etc.)
    // So when using block state then it makes a difference if a door is open and closed
    // When using block type then it does not make a difference
    // I understand now lol

    // Small update, im very unsure about the BlockTypeIds because in an older project i var_dumped them and it just returned 0 for all blocks
    // Lemme see where that takes us lol

    // Still have to fix all the naming conventions to match php8 standards

    // Im done translating now i guess, 24.3.2024 7:46 PM

    public function onLoad(): void
    {
        GeneratorManager::getInstance()->addGenerator(Giganilla::class, "giganilla", fn () => null);
    }

    protected function onEnable(): void
    {
        $this->getScheduler()->scheduleRepeatingTask(new PerformanceServer(), 1);
    }
}
