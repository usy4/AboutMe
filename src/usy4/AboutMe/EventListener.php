<?php

declare(strict_types=1);

namespace usy4\AboutMe;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\player\Player;

use usy4\AboutMe\Main;

class EventListener implements Listener {

    /**
     * @ignoreCancelled true
      * @priority MONITOR
     */  
    
    public function onDamage(EntityDamageEvent $event): void
    {
        $player = $event->getEntity();
        if(!$player instanceof Player) return;
        if($event instanceof EntityDamageByEntityEvent && ($damager = $event->getDamager()) instanceof Player){
            if(Main::$config->get("DamageToRead") == false) return;
            if($player->getWorld()->getFolderName() !== Main::$config->get("WorldName")) return;
            Main::ReadForm($damager, $player->getName());
        }
    }

}
