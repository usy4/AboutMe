<?php

declare(strict_types=1);

namespace usy4\AboutMe;

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;

use usy4\AboutMe\Main;

class EventListener implements Listener {

    public function onDamage(EntityDamageEvent $event): void
    {
        $player = $event->getEntity();
        if(!$player instanceof Player) return;
        if(Main::getConfig()->get("DamageToWrite") == false) return;
        if($player->getWorld()->getFolderName() !== Main::getConfig()->get("WorldName")) return;
        Main::WriteForm($player);
    }

}