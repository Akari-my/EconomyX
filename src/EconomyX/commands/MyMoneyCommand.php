<?php

namespace EconomyX\commands;

use EconomyX\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\plugin\PluginOwned;

class MyMoneyCommand extends Command implements PluginOwned {

    protected Main $plugin;

    public function __construct(Main $economyAPI) {
        $this->plugin = $economyAPI;
        parent::__construct("mymoney", "See yoour money");
        $this->setPermission("economyx.mymoney");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if(!$sender instanceof Player){
            $sender->sendMessage($this->plugin->getConfig()->get('messages')['is_not_player']);
        }

        $money = $this->plugin->EconomyDB()->getMoney($sender);
        $message = $this->plugin->getConfig()->get('messages')['my_money'];
        $message = str_replace('{money}', $money, $message);
        $sender->sendMessage($message);
    }

    public function getOwningPlugin() : Main {
        return $this->plugin;
    }
}