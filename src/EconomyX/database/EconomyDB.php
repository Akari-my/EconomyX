<?php

namespace EconomyX\database;

use pocketmine\player\Player;
use poggit\libasynql\DataConnector;

class EconomyDB {

    private $database;

    public function __construct(DataConnector $database) {
        $this->database = $database;
        $this->database->executeGeneric("init");
    }

    public function getMoney(Player $player, callable $callback) : void {
        $this->database->executeSelect("getMoney", ['name' => $player->getName()], function(array $rows) use ($callback){
            $callback($rows[0]['Money'] ?? 0);
        });
    }

    public function addMoney(Player $player, int $amount) : void {
        $this->database->executeChange("addMoney", ['name' => $player->getName(), 'amount' => $amount]);
    }

    public function removeMoney(Player $player, int $amount) : void {
        $this->database->executeChange("removeMoney", ['name' => $player->getName(), 'amount' => $amount]);
    }

    public function setMoney(Player $player, int $amount) : void {
        $this->database->executeChange("setMoney", ['name' => $player->getName(), 'amount' => $amount]);
    }

    public function payMoney(Player $payer, Player $receiver, int $amount, callable $callback) : void {
        $this->removeMoney($payer, $amount);
        $this->addMoney($receiver, $amount);
        $callback(true);
    }

    public function getTopMoney(callable $callback) : void {
        $this->database->executeSelect("getTopMoney", ['limit' => 10], function(array $rows) use ($callback){
            $callback($rows);
        });
    }

    public function registerPlayer(Player $player, int $initialMoney = 1000) : void {
        $this->database->executeInsert("insertPlayer", ['name' => $player->getName(), 'initialMoney' => $initialMoney]);
    }
}