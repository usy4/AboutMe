<?php

namespace usy4\AboutMe\commands\subs;

use CortexPE\Commando\BaseSubCommand;
use pocketmine\command\CommandSender;

use usy4\AboutMe\Main;

class WriteSubCommand extends BaseSubCommand {

    protected function prepare(): void {
        //nothing
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void {
        Main::WriteForm($sender);
    }

}