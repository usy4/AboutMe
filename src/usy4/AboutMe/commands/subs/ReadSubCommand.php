<?php

namespace usy4\AboutMe\commands\subs;

use CortexPE\Commando\BaseSubCommand;
use pocketmine\command\CommandSender;

use usy4\AboutMe\commands\TargetPlayerArgument;
use usy4\AboutMe\Main;

class ReadSubCommand extends BaseSubCommand {

    protected function prepare(): void {
        $this->registerArgument(0, new TargetPlayerArgument(true));
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void {
        if(count($args) < 1){
            $sender->sendMessage("Usage: /aboutme read (player)");
            return;
        }
        Main::ReadForm($sender, $args["player"]);
    }

}