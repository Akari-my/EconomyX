<?php

namespace EconomyX\commands;

use EconomyX\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\plugin\PluginOwned;

class SeeMoneyCommand extends Command implements PluginOwned{

    protected Main $plugin;

    public function __construct(Main $economyAPI) {
        $this->plugin = $economyAPI;
        parent::__construct("seemoney", "See money from player a money");
        $this->setPermission("economyx.seemoney");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if(!$sender instanceof Player){
            $sender->sendMessage($this->plugin->getConfig()->get('messages')['is_not_player']);
            return false;
        }

        if (!isset($args[0])) {
            $sender->sendMessage("§cUsage: /seemoney <player>");
            return false;
        }

        $playerName = $args[0];
        $player = $this->plugin->getServer()->getPlayerExact($playerName);

        if($player === null) {
            $sender->sendMessage($this->plugin->getConfig()->get('messages')['player_not_found']);
            return false;
        }

        $money = $this->plugin->EconomyDB()->getMoney($player);
        $message = $this->plugin->getConfig()->get('messages')['see_money'];
        $message = str_replace(["{player}", "{money}"], [$playerName, $money], $message);
        $sender->sendMessage($message);
    }

    public function getOwningPlugin() : Main {
        return $this->plugin;
    }
}