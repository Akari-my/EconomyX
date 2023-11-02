<?php

namespace EconomyX\commands;

use EconomyX\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\plugin\PluginOwned;

class SetMoneyCommand extends Command implements PluginOwned{

    protected Main $plugin;

    public function __construct(Main $economyAPI) {
        $this->plugin = $economyAPI;
        parent::__construct("setmoney", "Set money a player");
        $this->setPermission("economyx.setmoney");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if(!$sender instanceof Player){
            $sender->sendMessage($this->plugin->getConfig()->get('messages')['is_not_player']);
            return false;
        }

        if(!$this->testPermission($sender)){
            $sender->sendMessage($this->plugin->getConfig()->get('messages')['not_permission']);
            return false;
        }

        if (!isset($args[0]) || !isset($args[1]) || !is_numeric($args[1])) {
            $sender->sendMessage("§cUsage: /setmoney <player> <amount>");
            return false;
        }

        $player = $this->plugin->getServer()->getPlayerExact($args[0]);
        $payed = (int)$args[1];
        if($player !== null){
            $this->plugin->EconomyDB()->setMoney($player, $payed);

            $message = $this->plugin->getConfig()->get('messages')['set_money'];
            $message = str_replace(['{money}', '{player}'], [$payed, $args[0]], $message);
            $sender->sendMessage($message);

            return true;
        }
        return false;
    }

    public function getOwningPlugin() : Main {
        return $this->plugin;
    }
}