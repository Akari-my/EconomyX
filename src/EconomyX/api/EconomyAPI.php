<?php

namespace EconomyX\api;

use EconomyX\database\EconomyDB;
use pocketmine\player\Player;

class EconomyAPI {

    private static $instance = null;
    private EconomyDB $database;

    private function __construct(EconomyDB $db){
        $this->database = $db;
    }

    public static function getInstance(): ?EconomyAPI {
        return self::$instance;
    }

    /**
     * Initialize the EconomyAPI singleton
     *
     * @param EconomyDB $db
     */
    public static function initialize(EconomyDB $db): void {
        if(self::$instance === null){
            self::$instance = new EconomyAPI($db);
        }
    }

    /**
     * Get the amount of money for a player
     *
     * @param Player $player
     */
    public function getMoney(Player $player) {
        return $this->database->getMoney($player);
    }

    /**
     * Add money to a player
     *
     * @param Player $player
     * @param int $amount
     */
    public function addMoney(Player $player, int $amount) {
        return $this->database->addMoney($player, $amount);
    }

    /**
     * Set the amount of money for a player
     *
     * @param Player $player
     * @param int $amount
     */
    public function setMoney(Player $player, int $amount) {
        return $this->database->setMoney($player, $amount);
    }

    /**
     * Remove money from a player
     *
     * @param Player $player
     * @param int $amount
     */
    public function removeMoney(Player $player, int $amount) {
        return $this->database->removeMoney($player, $amount);
    }
}