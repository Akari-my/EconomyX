<?php

namespace EconomyX\commands;

use EconomyX\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\plugin\PluginOwned;

class PayCommand extends Command implements PluginOwned{

    protected Main $plugin;

    public function __construct(Main $economyAPI) {
        $this->plugin = $economyAPI;
        parent::__construct("pay", "Pay player a money");
        $this->setPermission("economyx.pay");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if(!$sender instanceof Player){
            $sender->sendMessage($this->plugin->getConfig()->get('messages')['is_not_player']);
            return false;
        }

        if (!isset($args[0]) || !isset($args[1]) || !is_numeric($args[1])) {
            $sender->sendMessage("§cUsage: /pay <player> <amount>");
            return false;
        }

        if(isset($args[0]) && is_numeric($args[1])){
            $receiver = $this->plugin->getServer()->getPlayerExact($args[0]);
            $payed = (int)$args[1];
            if($receiver !== null){
                $result = $this->plugin->EconomyDB()->payMoney($sender, $receiver, $payed);
                if($result){
                    $message = $this->plugin->getConfig()->get('messages')['payer_money'];
                    $message = str_replace(['{money}', '{player}'], [$payed, $args[0]], $message);
                    $sender->sendMessage($this->plugin->getConfig()->get('prefix') . ' ' . $message);

                    $message = $this->plugin->getConfig()->get('messages')['payed_money'];
                    $message = str_replace(['{money}', '{player}'], [$payed, $sender->getName()], $message);
                    $receiver->sendMessage($message);

                } else {
                    $sender->sendMessage($this->plugin->getConfig()->get('messages')['not_enough_money']);
                }
                return true;
            }
        }
    }

    public function getOwningPlugin() : Main {
        return $this->plugin;
    }
}