<?php

namespace EconomyX\commands;

use EconomyX\api\EconomyAPI;
use EconomyX\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

class TopMoneyCommand extends Command {

    protected Main $plugin;

    public function __construct(Main $economyAPI) {
        $this->plugin = $economyAPI;
        parent::__construct("topmoney", "See Top money");
        $this->setPermission("economyx.topmoney");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if(!$sender instanceof Player){
            $sender->sendMessage($this->plugin->getConfig()->get('messages')['is_not_player']);
        }

        $topMoney = $this->plugin->EconomyDB()->getTopMoney();

        $message = $this->plugin->getConfig()->get('messages')['top_money'];
        $sender->sendMessage($message);

        foreach ($topMoney as $playerName => $money) {
            $sender->sendMessage("§7{$playerName}: §e{$money}");
        }
    }
}