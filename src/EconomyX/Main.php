<?php

namespace EconomyX;

use EconomyX\api\EconomyAPI;
use EconomyX\commands\MyMoneyCommand;
use EconomyX\commands\PayCommand;
use EconomyX\commands\SeeMoneyCommand;
use EconomyX\commands\SetMoneyCommand;
use EconomyX\commands\TopMoneyCommand;
use EconomyX\database\EconomyDB;
use EconomyX\managers\PlayerManager;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase {

    private EconomyDB $economyDB;

    public function onEnable() : void {
        $this->economyDB = new EconomyDB($this->getDataFolder());
        EconomyAPI::initialize($this->economyDB);
        $this->saveResource("config.yml");
    
        $this->registerCommands();
        $this->registerManagers();
    }
    public function registerCommands(){
        $this->getServer()->getCommandMap()->registerAll("economyx", [
            new MyMoneyCommand($this),
            new PayCommand($this),
            new SetMoneyCommand($this),
            new TopMoneyCommand($this),
            new SeeMoneyCommand($this)
        ]);
    }

    public function registerManagers(){
        $this->getServer()->getPluginManager()->registerEvents(new PlayerManager($this), $this);
    }

    public function EconomyDB(): EconomyDB{
        return $this->economyDB;
    }
}