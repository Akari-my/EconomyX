<?php

namespace EconomyX\managers;

use EconomyX\Main;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;

class PlayerManager implements Listener {

    protected Main $plugin;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }

    public function onPlayerJoin(PlayerJoinEvent $event): void {
        $player = $event->getPlayer();
        $this->plugin->EconomyDB()->registerPlayer($player);
    }
}