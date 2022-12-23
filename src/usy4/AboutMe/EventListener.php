<?php

declare(strict_types=1);

namespace usy4\AboutMe;

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\player\Player;

use usy4\AboutMe\Main;

class EventListener implements Listener {

    public function onDamage(EntityDamageEvent $event): void
    {
        $player = $event->getEntity();
        if(!$player instanceof Player) return;
        if(Main::$config->get("DamageToRead") == false) return;
        if($player->getWorld()->getFolderName() !== Main::$config->get("WorldName")) return;
        Main::WriteForm($player);
    }

}
