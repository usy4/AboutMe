<?php

namespace usy4\AboutMe;

use usy4\AboutMe\commands\AboutMeCommand;
use usy4\AboutMe\EventListener;

use CortexPE\Commando\PacketHooker;

use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

use Vecnavium\FormsUI\CustomForm;
use Vecnavium\FormsUI\SimpleForm;

class Main extends PluginBase{
    
    public static $AM;
    public static $config;

    public function onEnable() : void{
        if (!PacketHooker::isRegistered()){
            PacketHooker::register($this);
        }
        Server::getInstance()->getPluginManager()->registerEvents(new EventListener(), $this);
        Server::getInstance()->getCommandMap()->register($this->getName(), new AboutMeCommand($this, "aboutme", "To write about yourself or read about others", aliases: ["am"])); 
        $this->saveResource("config.yml");
        self::$AM = new Config($this->getDataFolder().'/AboutMe.yml', 2);
        self::$config = new Config($this->getDataFolder().'/config.yml');
        $this->saveDefaultConfig();
    }

    public static function ReadForm(Player $player, string $target) : void {
        $form = new SimpleForm(function (Player $player, $data){
            if($data === null) {
                return true;
            }
        });
        $form->setTitle("§fAboutMe §7- §0" . $target);
        if(self::$AM->get($target) == true){
            $addLineAndColor = str_replace(["{line}", "{color}"], ["\n", "§"], self::$AM->get($target));
            $form->setContent($addLineAndColor);
        } else {
            $form->setContent('""');
        }
        $player->sendForm($form);
    }

    public static function WriteForm(Player $player) : void {
        $form = new CustomForm(function (Player $player, $data){
            if($data === null) {
                return true;
            }
            if($data[0] == ""){
                $player->sendMessage("§cError, Empty message, \nIf you want to make about me empty; write {empty}");
                return;
            }
            if (!preg_match('/[A-Za-z]/', $data[0])){
                $player->sendMessage("§cError, AboutMe must contain at least one letter");
                return;
            }
            if(str_contains($data[0], '{empty}')){
                self::$AM->removeNested($player->getName());
                self::$AM->save();
                $player->sendMessage("Done.");
                return;
            }
            self::$AM->set($player->getName(), $data[0]);
            self::$AM->save();
            $player->sendMessage($data[0]);
        });
        $form->setTitle("§fAboutMe");
        if(self::$AM->get($player->getName()) == true){
            $form->addInput("Write about urself:",  "{line} to new line,\n{color} to color messages.", self::$AM->get($player->getName()));
        } else {
             $form->addInput("Write about urself:", "{line} to new line,\n{color} to color messages.");
        }
        $player->sendForm($form);
    }

}
