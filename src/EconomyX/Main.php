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
use _7aa34c74ea11067a2510poggit\libasynql\DataConnector;
use _7aa34c74ea11067a2510poggit\libasynql\libasynql;

class Main extends PluginBase {

    private DataConnector $database;

    private EconomyDB $economyDB;

    public function onEnable() : void {
        $this->database = libasynql::create($this, $this->getConfig()->get("database"), [
            "sqlite" => "sqlite.sql"
        ]);
        $this->saveResource("sqlite.sql");
        $this->database->waitAll();

        $this->economyDB = new EconomyDB($this->database);
        EconomyAPI::initialize($this->economyDB);
        $this->saveResource("config.yml");

        $this->registerCommands();
        $this->registerManagers();
    }

    public function onDisable() : void {
        if($this->database !== null){
            $this->database->waitAll();
            $this->database->close();
        }
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